@extends('layouts.header')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Student List</h1>
            <table class="table table-striped">
              <thead class="table-dark">
                <tr>
                  <th>Name</th>
                  <th>Subject</th>
                  <th>Mark</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="studenttblbody">
              </tbody>
            </table>
            <div id="student-empty"></div>
            <br>
            <button type="button" class="btn btn-dark mt-2" data-bs-toggle="modal" data-bs-target="#createStudent"> Create </button>

            {{-- Create Modal --}}
            <div class="modal fade" id="createStudent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="clearFields"></button>
                  </div>
                  <div class="modal-body">
                    <form action="" method="post">
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                      <div class="form-group">
                       <label for="name" class="text-dark">Name:</label><br>
                       <input type="text" name="name" id="name" class="form-control">
                      </div>
  
                      <div class="form-group mt-3">
                        <label for="subject" class="text-dark">Subject:</label><br>
                        <input type="text" name="subject" id="subject" class="form-control">
                      </div>
  
                      <div class="form-group mt-3">
                        <label for="mark" class="text-dark">Mark:</label><br>
                        <input type="number" name="mark" id="mark" class="form-control">
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mt-2" data-bs-dismiss="modal" id="clearFields">Close</button>
                    <button type="button" class="btn btn-dark mt-2" id="create-stu">Create</button>
                  </div>
                </div>
              </div>
            </div>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="editStudentForm">
                      <input type="hidden" id="editStudentId" name="id">
                      <div class="form-group">
                          <label for="editStudentName">Name</label>
                          <input type="text" class="form-control" id="editStudentName" name="name" required>
                      </div>
                      <div class="form-group">
                          <label for="editStudentSubject">Subject</label>
                          <input type="text" class="form-control" id="editStudentSubject" name="subject" required>
                      </div>
                      <div class="form-group">
                          <label for="editStudentMarks">Mark</label>
                          <input type="number" class="form-control" id="editStudentMarks" name="marks" required>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mt-2" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-dark mt-2" id="update-stu">Update</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('js/jquery.js') }}"></script>
<script>
  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})
</script>
<script src="{{ asset('js/portal_home.js') }}"></script>