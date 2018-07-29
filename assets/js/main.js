'use strict';

$(function(){
  $('#emailForm').submit(function(e){
    e.preventDefault();
    e.stopPropagation();

    sendEvent('form', 'submit');

    if ($(this).get(0).checkValidity() !== false) {
      // disable submit button
      $('#submit').prop('disabled', true).addClass('busy').find('.label').html("Sending...")

      //ajax submit the form
      var request = $.ajax({
        type: "POST",
        url: "/ajax-submit",
        data: $(this).serialize(),
        dataType: 'json',
        statusCode: {
          500: function(){
            swal("Oh oh!", "Watson we have a problem!", "error");
          }
        },
        success: function(data){
          if(data.message === "success"){
            sendEvent('email', 'sent');
            swal("Email sent!", "Your email is successfully sent.", "success").then(function(){
              // reset the form
              $('#emailForm').trigger("reset").removeClass('was-validated');;
            });
          } else {
            sendEvent('form', 'invalid');
            swal("Validation failed!", "Please check your form.", "error");
          }
        },
        error: function(data) {
          sendEvent('email', 'failed');
          console.log('error', data);
        },
        complete: function() {
          // enable submit button
          $('#submit').prop('disabled', false).removeClass('busy').find('.label').html("Submit")
        }

      });
    }

    $(this).addClass('was-validated');
  });
});

function sendEvent(category, action) {
  dataLayer.push({'event': 'ga', 'category': category, 'action': action});
}
