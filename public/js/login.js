$(document).ready( function() {

  $('#submit').click(function() {
    var email = $('#email').val()
    var password = $('#password').val()

    //Toastr is a 3rd party JS library used to display responses
    toastr.options = {
      "positionClass": "toast-bottom-right", //Display the toastr postion in bottom right
    }

    if(email == '' || email == null){
      toastr.warning('Email cannot be empty')
      return false
    }
    else if(password == '' || password == null){
      toastr.warning('Password cannot be empty')
      return false
    }

    //Disabling the login button while it checks for the validation using provided credentials.
    // If validations takes more time the user may keep on clicking the button.
    $('#submit').val('Logging...')
    $('#submit').prop('disabled',true)
    var baseURL = window.location.origin
    var url = '/login/auth'

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') //sending csrf token in header request
      },
      url : baseURL + url,
      data : {'email' : email, 'password' : password},
      type : 'POST',
      dataType : 'json',
      success : function(result) {
        if(result.status == 'success') {
          //If the response came from the server return back the button to its original html. So that it will become clickable again.
          $('#submit').val('Login')
          $('#submit').prop('disabled',false)
          toastr.success(result.message)
          //If login in success redirect the url to the teachers home page.
          window.location.href = baseURL + '/portal';
        }
      },
      error: function(error) {
        if(error.responseJSON.status == 'failed') {
          //Catches the error if email/password is incorrect
          toastr.error(error.responseJSON.message)
        }
        else {
          toastr.error('There was an error occurred, Please try again.')
        }
        $('#submit').val('Login')
        $('#submit').prop('disabled',false)
      }
    });
  })
})