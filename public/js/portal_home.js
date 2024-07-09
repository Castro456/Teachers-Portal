$(document).ready( function() {
    var baseURL = window.location.origin

    toastr.options = {
      "positionClass": "toast-bottom-right",
    }
    // Get all students
    function getStudents() {
      $.ajax({
          url: baseURL + '/api/student',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
             var studenttblhtml = ''
             $.each(response, function(index, student) {
                studenttblhtml += '<tr>';
                studenttblhtml += '<td>' + student.name + '</td>';
                studenttblhtml += '<td>' + student.subject + '</td>';
                studenttblhtml += '<td>' + student.marks + '</td>';
                studenttblhtml += '<td>';
                studenttblhtml += '<button class="btn btn-warning btn-sm editBtn m-1" data-id="' + student.id + '">Edit</button>';
                studenttblhtml += '<button class="btn btn-danger btn-sm deleteBtn" data-id="' + student.id + '">Delete</button>';
                studenttblhtml += '</td>';
                studenttblhtml += '</tr>';
            });
            $('#studenttblbody').html(studenttblhtml); //Creating a table body using jQuery.
          },
          error: function(error) {
            console.log('error')
            $('#student-empty').html("<center> No students found </center>"); // If no record found, show as empty.
          }
      });
    }
    getStudents(); //Writtern getting all students as a fucntions so tha after a each action without page getting refreshed we can get the updated data.


    // Create student
    $('#create-stu').click(function() {
      var name = $('#name').val()
      var subject = $('#subject').val()
      var mark = $('#mark').val()

      if(name == '' || name == null){
        toastr.warning('Name cannot be empty')
        return false
      }
      else if(subject == '' || subject == null){
        toastr.warning('Subject cannot be empty')
        return false
      }
      else if(mark == '' || mark == null){
        toastr.warning('Mark cannot be empty')
        return false
      }

      $('#create-stu').val('Creating...')
      $('#create-stu').prop('disabled',true)

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : baseURL + '/api/student/create',
        data : {'name' : name, 'subject' : subject, 'mark' : mark},
        type : 'POST',
        dataType : 'json',
        success : function(result) {
          console.log(result)
          if(result.status == 'success') {
            $('#create-stu').val('Create')
            $('#create-stu').prop('disabled',false)
            $('#createStudent').modal('hide')
            $('#name').val('')
            $('#subject').val('')
            $('#mark').val('')
            toastr.success(result.message)
            getStudents();
          }
        },
        error: function(error) {
          console.log(error)
          if(error.responseJSON.status == 'failed') {
            toastr.error(error.responseJSON.message)
          }
          else {
            toastr.error('There was an error occurred, Please try again.')
          }
          $('#create-stu').val('Create')
          $('#create-stu').prop('disabled',false)
        }
      });
    })


    // Edit student
    $(document).on('click', '.editBtn', function() {
      var studentId = $(this).data('id');
      var url = baseURL + '/api/student/' + studentId + "/edit";
      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
          // Populate modal fields with student data
          $('#editStudentId').val(result.id);
          $('#editStudentName').val(result.name);
          $('#editStudentSubject').val(result.subject);
          $('#editStudentMarks').val(result.marks);
          $('#editModal').modal('show');
        },
        error: function(error) {
          toastr.error('There was an error, Please try again');
        }
      });
    });


    // Update student
    $(document).on('click', '#update-stu', function() {
      var editNname = $('#editStudentName').val()
      var editSubject = $('#editStudentSubject').val()
      var editMark = $('#editStudentMarks').val()

      if(editNname == '' || editNname == null){
        toastr.warning('Name cannot be empty')
        return false
      }
      else if(editSubject == '' || editSubject == null){
        toastr.warning('Subject cannot be empty')
        return false
      }
      else if(editMark == '' || editMark == null){
        toastr.warning('Mark cannot be empty')
        return false
      }

      var formData = $('#editStudentForm').serialize();
      var studentId = $('#editStudentId').val();
      var modurl = baseURL + '/api/student/update/' + studentId;

      $('#update-stu').val('Updating...')
      $('#update-stu').prop('disabled',true)

      $.ajax({
        url: modurl,
        type: 'PUT',
        dataType: 'json',
        data: formData,
        success: function(response) {
          toastr.success('Student details updated successfully.');
          $('#update-stu').val('Update')
          $('#update-stu').prop('disabled',false)
          $('#editModal').modal('hide');
          getStudents();
        },
        error: function(error) {
          if(error.responseJSON.status == 'validation_failed') {
            toastr.error(error.responseJSON.message)
          }
          else {
            toastr.error('There was an error occurred, Please try again.')
          }
          $('#update-stu').val('Update')
          $('#update-stu').prop('disabled',false)
        }
      });
    });


    // Delete student
    $(document).on('click', '.deleteBtn', function() {
      var studentId = $(this).data('id');
      if (confirm('Are you sure you want to delete this student?')) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseURL + '/api/student/delete',
          type: 'DELETE',
          dataType: 'json',
          data: {
            student_id: studentId
          },
          success: function(result) {
            toastr.success(result.message)
            getStudents();
          },
          error: function(error) {
            toastr.error('There was an error, Please try again');
          }
        });
      }
    });


    // Clear old values from create student fields after closing the modal
    $(document).on('click', '#clearFields', function() {
      $('#name').val('')
      $('#subject').val('')
      $('#mark').val('')
    });
  })