<?php
    if (!isset($_SESSION))
        session_start();

    if ((isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./home.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php
        include "header.php";
    ?>
    <title>Sign In</title>
</head>

<body class="login-body">
    <?php
        include "navbar.php";
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-sign-in my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Sign In</h5>
                        <?php
                            if (isset($_GET['error']) && $_GET['error']):
                        ?>
                                <h6 class='text-center' style='color: red; margin-bottom: 15px;'>Wrong Username or Password!</h6>
                        <?php
                            endif;
                        ?>
                        <form class="form-sign-in" method="POST" action="./service/doSignIn.php">
                            <div class="form-label-group">
                                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
                                <label for="username">Username</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="remember-me">
                                <label class="custom-control-label" for="remember-me">Remember me</label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign In</button>
                            <hr class="my-4">
                            <a class="btn btn-lg btn-outline-success btn-block text-uppercase" href="./signup.php">Sign Up</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>