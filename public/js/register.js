$(document).ready( function() {

  $('#submit').click(function() {
    var name = $('#name').val()
    var email = $('#email').val()
    var password = $('#password').val()
    var confirm_password = $('#confirm-password').val()
    var mailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/

    toastr.options = {
      "positionClass": "toast-bottom-right",
    }

    if(name == '' || name == null){
      toastr.warning('Name cannot be empty')
      return false
    }
    else if(email == '' || email == null){
      toastr.warning('Email cannot be empty')
      return false
    }
    else if(!(email.match(mailFormat))) {
      toastr.warning('Email is not valid') //Check if entered email address is a valid one
      return false
    }
    else if(password == '' || password == null){
      toastr.warning('Password cannot be empty')
      return false
    }
    else if(password.length < 8){
      toastr.warning('Password should be minimum of 8 characters')
      return false
    }
    else if(confirm_password == '' || confirm_password == null){
      toastr.warning('Confirm password cannot be empty')
      return false
    }
    else if(password !== confirm_password){
      toastr.warning('Passwords are not matching')
      return false
    }

    $('#submit').val('Registering...')
    $('#submit').prop('disabled',true)
    var baseURL = window.location.origin
    var url = '/register'
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url : baseURL + url,
      data : {'name' : name, 'email' : email, 'password' : password},
      type : 'POST',
      dataType : 'json',
      success : function(result) {
        if(result.status == 'success') {
          $('#submit').val('Register')
          $('#submit').prop('disabled',false)
          $('#name').val('')
          $('#email').val('')
          $('#password').val('')
          $('#confirm-password').val('')
          toastr.success('Registered successfully, Login now!')
        }
      },
      error: function(error) {
        //Catch the API validation error. Like entered email already exists
        if(error.responseJSON.status == 'validation_failed') {
          toastr.error(error.responseJSON.message)
        }
        else {
          toastr.error('There was an error occurred, Please try again.')
        }
        $('#submit').val('Register')
        $('#submit').prop('disabled',false)
      }
    });
  })
})
