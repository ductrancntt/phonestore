<?php
    if (!isset($_SESSION))
        session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <?php
        include "header.php";
    ?>

    <title>Phone Shop</title>
    <link href="./css/ui.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
    include "navbar.php";
?>
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
                <!-- <th:block th:each="manufacturer : ${manufacturers}"> -->
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
                <!-- </th:block> -->
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
<?php
    include "footer.php";
?>
</body>
</html>