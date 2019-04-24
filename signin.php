<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script type="text/javascript" src="./libs/jquery/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="./libs/bootstrap/css/bootstrap.min.css"/>
    <script type="text/javascript" src="./libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./libs/fontawesome/css/all.css"/>
    <link rel="stylesheet" href="./css/main.css"/>

    <link rel="icon" href="./image/favicon.png">

    <script type="text/javascript">
        $(function () {
            $("button[data-toggle='tooltip']").tooltip();
        });

        let formatNumber = function (number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>

    <title>Sign In</title>
</head>
<body class="login-body">
<nav class="navbar navbar-light bg-light justify-content-between border-bottom shadow-sm fixed-top nav-padding">
    <div class="container-fluid">
        <a class="navbar-brand" href="./home.php">
            <img src="./image/logo-2.png" width="35" height="35" class="d-inline-block align-center logo-responsive">
            <span class="shop-brand">Phone Shop</span>
        </a>
        <div class="flex-grow-1 d-flex">
            <div class="form-inline flex-nowrap bg-light mx-0 mx-lg-auto rounded p-1">
                <div class="input-group">
                    <input id="search-product" name="productName" type="text"
                           class="form-control search-nav search-nav-width" placeholder="Search"
                           aria-label="Search"
                           aria-describedby="search">
                    <div class="input-group-append">
                        <button class="btn btn-primary search-nav" type="button" id="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <a class="nav-link wish-list-link" href="/customer/wish-list">
                <i class="fa fa-heart"></i>
                <span>WISH LIST</span>
                <span class="badge badge-pill badge-danger" id="number-wish-list"></span>
            </a>
        </div>
        <div class="nav-item">
            <a class="nav-link admin-link" href="/customer/cart">
                <i class="fas fa-shopping-cart"></i>
                <span>CART</span>
                <span class="badge badge-pill badge-success" id="number-cart"></span>
            </a>
        </div>
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle account-link" href="" id="navbarDropdown" role="button"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i>
                <span>ACCOUNT</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="font-size: 0.85rem" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="./signin.php">
                    <i class="fas fa-sign-in-alt" style="width: 15px"></i>
                    <span>Sign In</span>
                </a>
                <div>
                    <a class="dropdown-item" href="/change-password">
                        <i class="fas fa-key" style="width: 15px"></i>
                        <span> Change Password</span>
                    </a>
                    <a class="dropdown-item" href="/customer/invoices">
                        <i class="fas fa-file-invoice-dollar" style="width: 15px"></i>
                        <span> Purchase History</span>
                    </a>
                    <a class="dropdown-item" href="/user/setting">
                        <i class="fas fa-cog" style="width: 15px"></i>
                        <span> Setting</span>
                    </a>
                    <a class="dropdown-item" href="javascript: logout()">
                        <i class="fas fa-sign-out-alt" style="width: 15px"></i>
                        <span> Sign Out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-sign-in my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Sign In</h5>
                    <?php
                        if (isset($_GET['error']))
                            if ($_GET['error'] == true)
                                echo "<h6 class='text-center' style='color: red; margin-bottom: 15px;'>Wrong Username or Password!</h6>";
                    ?>
                    <form class="form-sign-in" method="POST" action="./service/doSignin.php">
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
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="remember-me">
                            <label class="custom-control-label" for="remember-me">Remember me</label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign In</button>
                        <hr class="my-4">
                        <a class="btn btn-lg btn-outline-success btn-block text-uppercase" href="/sign-up">Sign Up</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>