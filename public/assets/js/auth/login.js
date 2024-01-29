

// Handle Message

var showError = (field, message) => {

    console.log(field, message);
    if(!message){
        $('#' + field)
        .addClass('is-valid')
        .removeClass('is-invalid')
        .siblings('.invalid-feedback')
        .text('');
    } else {
        $('#' + field)
        .addClass('is-invalid')
        .removeClass('is-valid')
        .siblings('.invalid-feedback')
        .text(message);
    }
}



var removeValidationClasses = (form) => {
    $(form).each(function () {
        $(form).find(':input').removeClass('is-valid is-invalid');
    });
}


var showMessage = (type, message) => {
    return `<div class="alert alert-${type} alert-dismissible fade show mt-4" role="alert">
    <strong>${message}</strong> You should check in on some of those fields below.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>`;
}


var password = () => {

    $('#password_see').on('click', function () {
        var x = document.getElementById("password");
        var show_eye = document.getElementById("show_password");
    var hide_eye = document.getElementById("hide_password");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
    })
}

$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  // var login = () => {
  
  //   $('#loginForm').submit(function (e) { 
  //       e.preventDefault();

  // var formData  = $('#loginForm').serialize();

  //       $.ajax({
  //           type: "POST",
  //           url: "/login",
  //           data: formData,
  //           success: function (response) {
  //             if(response.status == 400){
  //               showError('username', response.messages.username);
  //               showError('password', response.messages.password);
  //             } else if(response.status == 401){
  //            $('#login_alert').html(showMessage('danger', response.message));    
  //             }  else {
  //               if(response.status == 200 && response.message == 'Success'){
                 
  //                   window.location = 'dashboard';
             
  //               }
  //             }
                
  //           }
  //       });
        
  //   });
  // }






document.addEventListener('DOMContentLoaded', function () {
    removeValidationClasses();
    showError();
    password();
    // login();

});