<?php

    require "service/Connection.php";

    if (!isset($_SESSION))
        session_start();

    if (!(isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./index.php");
    } else {
        $connection = new Connection();
        $connection->createConnection();
        $getUserInfoQuery = "SELECT * FROM user WHERE `username` = '".$_SESSION['username']."'";

        $result = $connection->excuteQuery($getUserInfoQuery);

        $name = "";
        $address = "";
        $phone = "";
        $email = "";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['name'];
                $address = $row['address'];
                $phone = $row['phone'];
                $email = $row['email'];
            }
        }

    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php
        include "header.php";
    ?>
    <title>Update Information</title>
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
                    <h5 class="card-title text-center">Update Information</h5>
                    <h6 id="error" class="text-center" style="color: red; margin-bottom: 15px; display: none;"></h6>
                    <form class="form-sign-in">
                        <div class="form-label-group">
                            <input type="text" id="full-name" name="full-name" class="form-control"
                                   placeholder="Your Name" <?php echo "value='".$name."'"?> required>
                            <label for="full-name">Full Name</label>
                        </div>
                        <div class="form-label-group">
                            <input type="text" id="address" name="address" class="form-control" placeholder="Address" <?php echo "value='".$address."'"?> required>
                            <label for="address">Address</label>
                        </div>
                        <div class="form-label-group">
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" <?php echo "value='".$phone."'"?> required>
                            <label for="phone">Phone</label>
                        </div>
                        <div class="form-label-group">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" <?php echo "value='".$email."'"?> required>
                            <label for="email">Email</label>
                        </div>
                        <hr class="my-4">
                        <button class="btn btn-lg btn-success btn-block text-uppercase" id="update-information-button"
                                type="button">Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./js/user-setting.js" type="text/javascript"></script>
</body>
</html>