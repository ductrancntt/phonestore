<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="/libs/jquery/jquery-3.3.1.min.js"></script>
  <title>Login</title>
</head>
<body>
  <span id="err" style="display:none; color: red">Tài khoản hoặc mật khẩu không chính xác</span><br>
  Username <input id="username">
  <br>
  Password <input id="password" type="password">
  <br>
  <input type="button" onclick="login()" value="Login">
  <input type="button" onclick="register()" value="Register">
  <script>
  function login(){
    var fd = new FormData();    
    fd.append( 'username', $('#username').val().trim() );
    fd.append( 'password', $('#password').val().trim() );
    $.ajax({
      url: 'service/login.php',
      type: 'POST',
      data: fd,
      processData: false,
      contentType: false,
      success: function(data){
        if(data){
          window.location.href = "/home.php";
        }else{
          $('#err').css("display","block");
        }
      }
    })
  }
  function register(){
    
  }
  </script>
</body>
</html>