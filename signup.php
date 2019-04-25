<?php
    if (!isset($_SESSION))
        session_start();
        
    if ((isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php
        include "header.php";
    ?>
    <title>Sign Up</title>
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
                    <h5 class="card-title text-center">Sign Up</h5>
                    <h6 id="username-error" class="text-center" style="color: red; margin-bottom: 15px; display: none;">
                        Please choose another name!</h6>
                    <form if="signup-form" class="form-sign-in">
                        <div class="form-label-group">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                                   required autofocus>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" id="confirm-password" name="confirm-password" class="form-control"
                                   placeholder="Confirm Password" required>
                            <label for="confirm-password">Confirm Password</label>
                        </div>
                        <div class="form-label-group">
                            <input type="text" id="fullname" name="fullname" class="form-control"
                                   placeholder="Full Name">
                            <label for="fullname">Full Name</label>
                        </div>
                        <div class="form-label-group">
                            <input type="text" id="address" name="address" class="form-control" placeholder="Address">
                            <label for="address">Address</label>
                        </div>
                        <div class="form-label-group">
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone"
                                   pattern="[0-9]{8,12}">
                            <label for="phone">Phone</label>
                        </div>
                        <hr class="my-4">
                        <button class="btn btn-lg btn-success btn-block text-uppercase" id="signup-button"
                                type="button">Sign Up
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./js/sign-up.js" type="text/javascript"></script>
</body>

</html>