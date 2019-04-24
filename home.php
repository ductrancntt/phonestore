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

    <title>Phone Shop</title>
    <link href="./css/ui.css" rel="stylesheet" type="text/css">
</head>
<body>
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
            <a class="nav-link admin-link" href="./cart.php">
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
<div>
    <div class="banner">
        <img src="./image/banner.jpg" class="banner-image">
        <span class="banner-text">PHONE SHOP</span>
    </div>

    <section class="section-request bg padding-y-sm">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">BRANDS</h4>
            </header>
            <div class="row-sm">
                <th:block th:each="manufacturer : ${manufacturers}">
                    <div class="col-md-2">
                        <figure class="card card-product" style="height: 80px;">
                            <div class="img-wrap">
                                <img th:src="${manufacturer.url}">
                                <a class="btn-overlay"
                                   th:href="'/search-products?manufacturers=' + ${manufacturer.id}">
                                    <i class="fas fa-search"></i>
                                    <span> Show products</span>
                                </a>
                            </div>
                        </figure>
                    </div>
                </th:block>
            </div>
        </div>
    </section>

    <section class="section-request bg padding-y-sm">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">TOP SELLERS</h4>
            </header>

            <div class="row-sm" id="top-sellers">
            </div>
        </div>
    </section>

    <section class="section-request bg padding-y-sm">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">RECOMMENDED PHONES</h4>
            </header>

            <div class="row-sm" id="recommended-phones">
            </div>
        </div>
    </section>

</div>
<footer th:fragment="footer" class="footer-distributed">
    <div class="footer-right">
        <a class="font-responsive" href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
        <a class="font-responsive" href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
        <a class="font-responsive" href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
        <a class="font-responsive" href="https://github.com/"><i class="fab fa-github"></i></a>
    </div>
    <div class="footer-left">
        <p class="footer-links font-responsive">
            <a href="/">Home</a>
            ·
            <a href="/">Blog</a>
            ·
            <a href="/">Pricing</a>
            ·
            <a href="/">About</a>
            ·
            <a href="/">Faq</a>
            ·
            <a href="/">Contact</a>
        </p>
        <p class="font-responsive">Phone Shop &copy; 2019</p>
    </div>
</footer>
</body>
</html>