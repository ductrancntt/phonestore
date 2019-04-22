<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="jquery-1.9.0.min.js"></script>
  <title>Login</title>
</head>
<body>
  Username <input >
  <br>
  Password <input>
  <br>
  <input type="button" value="Login">
  <script>
    var fd = new FormData();    
    fd.append( 'username', "hello" );
    $.ajax({
      url: 'service/login.php',
      type: 'POST',
      data: fd,
      processData: false,
      contentType: false,
      success: function(data){
        console.log(data);
      }
    })
  </script>
</body>
</html>