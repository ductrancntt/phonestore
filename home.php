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
require "./service/Connection.php";
$conn = new Connection();
?>
<?php
require_once "./service/Connection.php";
$productTopSaleList = array();
$productTopNewList = array();
$manufacturerList = array();
$sql = null;
$productName = '';
$connection = new Connection();
$connection->createConnection();


$getManufacturerSql = "SELECT * FROM manufacturer";
$result1 = $connection->excuteQuery($getManufacturerSql);

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        array_push($manufacturerList, $row);
    }
}

$getTopSale = "select * FROM product 
    JOIN (SELECT product_id FROM `item` GROUP BY item.product_id ORDER BY sum(quantity) DESC limit 4) as X 
    ON x.product_id = product.id";
$result = $connection->excuteQuery($getTopSale);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($productTopSaleList, $row);
    }
}

$getTopNew = "SELECT * FROM product ORDER BY id DESC limit 4";
$result2 = $connection->excuteQuery($getTopNew);
if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        array_push($productTopNewList, $row);
    }
}
$connection->closeConnection();


?>
<div>
    <?php
    include "banner.php";
    ?>

    <section class="section-request bg padding-y-sm">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">BRANDS</h4>
            </header>
            <div class="row-sm">
                <?php

                $conn->createConnection();
                $getManufacturersQuery = "SELECT * FROM manufacturer";
                $result = $conn->excuteQuery($getManufacturersQuery);
                $manufacturers = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        array_push($manufacturers, $row);
                    }
                }
                $conn->closeConnection();
                $link = "./search-result.php?manufacturers=";
                foreach ($manufacturers as $manufacturer) {
                    echo '<div class="col-md-2">
                        <figure class="card card-product" style="height: 80px;">
                            <div class="img-wrap">
                                <img src="' . $manufacturer['image'] . '">
                                <a class="btn-overlay" href="' . $link . $manufacturer['id'] . '">
                                    <i class="fas fa-search"></i>
                                    <span> Show products</span>
                                </a>
                            </div>
                        </figure>
                    </div>';
                }
                ?>

            </div>
        </div>
    </section>

    <section class="section-request bg padding-y-sm">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">TOP SELLERS</h4>
            </header>

            <div class="row-sm" id="top-sellers">
                <?php
                foreach ($productTopSaleList as $product) {
                    echo "<div class='col-md-3'>
                    <figure class='card card-product'>
                        <div class='img-wrap'>
                            <img src='".$product['image']."'>
                            <a class='btn-overlay' href='./product-detail.php?id=" . $product["id"] . "'><i
                                        class='fa fa-search'></i> Detail</a>
                        </div>
                        <figcaption class='info-wrap'>
                            <a href='./product-detail.php?id=" . $product["id"] . "' class='title'>" . $product["name"] . "</a>
                            <div class='action-wrap'>
                                <button type='button' class='btn btn-primary btn-sm float-right btn-add-to-cart'
                                        data-id='" . $product["id"] . "'>
                                <i class='fas fa-cart-plus'></i>
                                <span> ADD</span>
                                </button>
                            <div class='price-wrap h5'>
                            <span class='price-new'>" . number_format($product["price"]) . " đ</span >
                            <del class='price-old' ></del >
                            </div >
                            </div >
                            </figcaption >
                            </figure >
                            </div > ";
                }
                ?>
            </div>
        </div>
    </section>

    <section class="section-request bg padding-y-sm">
        <div class="container">
            <header class="section-heading heading-line">
                <h4 class="title-section bg text-uppercase">NEW PHONES</h4>
            </header>

            <div class="row-sm" id="recommended-phones">
                <?php
                foreach ($productTopNewList as $product) {
                    echo "<div class='col-md-3'>
                    <figure class='card card-product'>
                        <div class='img-wrap'>
                            <img src='".$product['image']."'>
                            <a class='btn-overlay' href='./product-detail.php?id=" . $product["id"] . "'><i
                                        class='fa fa-search'></i> Detail</a>
                        </div>
                        <figcaption class='info-wrap'>
                            <a href='./product-detail.php?id=" . $product["id"] . "' class='title'>" . $product["name"] . "</a>
                            <div class='action-wrap'>
                                <button type='button' class='btn btn-primary btn-sm float-right btn-add-to-cart'
                                        data-id='" . $product["id"] . "'>
                                <i class='fas fa-cart-plus'></i>
                                <span> ADD</span>
                                </button>
                            <div class='price-wrap h5'>
                            <span class='price-new'>" . number_format($product["price"]) . " đ</span >
                            <del class='price-old' ></del >
                            </div >
                            </div >
                            </figcaption >
                            </figure >
                            </div > ";
                }
                ?>

            </div>
        </div>
    </section>

</div>
<?php
include "footer.php";
?>
</body>
</html>