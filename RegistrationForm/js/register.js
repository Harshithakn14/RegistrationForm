src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"

  function submitData(){
    $(document).ready(function(){
      var data = {
        firstname: $("#firstname").val(),
        lastname: $("#lastname").val(),
        email: $("#email").val(),
        phone: $("#phone").val(),
        dob: $("#dob").val(),
        password: $("#password").val(),
        repeatpassword: $("#repeatpassword").val(),
        action: $("#action").val(),
      };

      $.ajax({
        url: '../php/register.php',
        type: 'post',
        data: data,
        success:function(response){
          alert(response);
          if(response == "Registration Successful"){
            window.location.reload();
          }
        }
      });
    });
  }