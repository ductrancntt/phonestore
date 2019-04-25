<?php
    if (!isset($_SESSION))
        session_start();

    if (!(isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php
        include "header.php";
    ?>
    <title>Change Password</title>
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
                    <h5 class="card-title text-center">Change Password</h5>
                    <h6 id="password-error" class="text-center"
                        style="color: red; margin-bottom: 15px; display: none;"></h6>
                    <form class="form-sign-in">
                        <div class="form-label-group">
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" id="new-password" name="new-password" class="form-control"
                                   placeholder="New Password" required>
                            <label for="new-password">New Password</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" id="confirm-password" name="confirm-password" class="form-control"
                                   placeholder="Confirm Password" required>
                            <label for="confirm-password">Confirm Password</label>
                        </div>
                        <hr class="my-4">
                        <button class="btn btn-lg btn-success btn-block text-uppercase" id="change-password-button"
                                type="button">Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/change-password.js" type="text/javascript"></script>
</body>
</html>