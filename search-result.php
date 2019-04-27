<?php
if (!isset($_SESSION))
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "header.php";
    ?>

    <title>Search Result</title>
    <link href="./css/ui.css" rel="stylesheet" type="text/css">
    <style>
        .btn-add-to-cart {
        }

        .btn-add-to-wish-list {
        }

        .brand-checkbox {
        }

    </style>
</head>
<body>
<?php
include "navbar.php";
?>
<?php
require_once "./service/Connection.php";
$productList = array();
$manufacturerList = array();
$sql = null;
$productName = '';
$manufacturers = '0';
$connection = new Connection();
$connection->createConnection();
if(isset($_GET["productName"])){
    $productName = $_GET["productName"];
}
if (isset($_GET["manufacturers"])) {
    $manufacturers = $_GET["manufacturers"];
}

$sql = "SELECT p.*, m.name as manufacturer_name  FROM product p JOIN manufacturer m ON m.id = p.manufacturer_id 
        WHERE ('".$manufacturers."' = '0' OR p.manufacturer_id IN (" . $manufacturers.")) AND p.name LIKE '%".$productName."%'";
$result = $connection->excuteQuery($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($productList, $row);
    }
}

$getManufacturerSql = "SELECT * FROM manufacturer";
$result1 = $connection->excuteQuery($getManufacturerSql);

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        array_push($manufacturerList, $row);
    }
}
$connection->closeConnection();

?>


<?php
    include "banner.php";
?>
<!--        <img src="./image/banner.jpg" class="banner-image">-->
<!--        <span class="banner-text">PHONE SHOP</span>-->


<section class="section-content bg padding-y">
    <div class="container">

        <nav class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
                <li class="breadcrumb-item active">
                    <span>Search Result - </span>
                    <?php
                    if (count($productList) > 1) {
                        echo "<span>".count($productList)." products</span>";
                    } else {
                        echo "<span>".count($productList)." product</span>";
                    }
                    ?>


                </li>
            </ol>
        </nav>

        <div class="row">
            <aside class="col-sm-3">
                <div class="card card-filter">
                    <article class="card-group-item">
                        <header class="card-header">
                            <a aria-expanded="true" href="#" data-toggle="collapse" data-target="#brand-name">
                                <i class="icon-action fa fa-chevron-down"></i>
                                <h6 class="title">Smartphone Brand</h6>
                            </a>
                        </header>
                        <div class="filter-content collapse show" id="brand-name">
                            <div class="card-body">
                                <ul class="list-unstyled list-lg">
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check-all">
                                            <label class="custom-control-label" for="check-all">All Brands</label>
                                        </div>
                                    </li>
                                    <?php
                                        foreach ($manufacturerList as $manufacturer){
                                            echo '<li>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input brand-checkbox"
                                                           value="'.$manufacturer["id"].'" id="'.$manufacturer["id"].'m">
                                                    <label class="custom-control-label"
                                                           for="'.$manufacturer["id"].'m">'.$manufacturer["name"].'</label>
                                                </div>
                                            </li>';
                                        }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </article>

                    <article class="card-group-item">
                        <div class="card-body">
                            <button class="btn btn-block btn-primary" id="apply-button">Apply</button>
                        </div>
                    </article>
                </div>
            </aside>
            <main class="col-sm-9">
                <?php
                if (count($productList) == 0) {
                    echo '<div style="padding-top: 50px; display: flex; justify-content: center;">
                        <span class="h3 text-warning"><i class="fas fa-exclamation-circle"></i> NO PRODUCT WAS FOUND!</span>
                    </div>';
                }
                ?>
                <?php
                foreach ($productList as $product) {
                    echo '<article class="card card-product">
                        <div class="card-body">
                            <div class="row">
                                <aside class="col-sm-3">
                                    <div class="img-wrap">
                                        <a href="./product-detail.php?id=' . $product["id"] . '"><img src="' . $product["image"] . '"></a>
                                    </div>
                                </aside>
                                <article class="col-sm-6">

                                    <a class="title h4" href="./product-detail.php?id=' . $product["id"] . '">' . $product["name"] . '</a>
                                    
                                    <p>'.$product["description"].'</p>
                                    <dl class="dlist-align">
                                        <dt>Manufacturer</dt>
                                        <dd>'.$product["manufacturer_name"].'</dd>
                                    </dl>
                                    <dl class="dlist-align">
                                        <dt>Screen Size</dt>
                                        <dd>' . $product["screen_size"] . ' inch</dd>
                                    </dl>
                                        <dl class="dlist-align">
                                            <dt>Quantity</dt>
                                            '.($product["quantity"]==0?"<dd class=\"text-danger font-weight-bold\">":"<dd>")
                                            .($product["quantity"]==0?"Out of stock":$product["quantity"]."pcs").'</dd>
                                        </dl>
                                </article>
                                <aside class="col-sm-3 border-left">
                                    <div class="action-wrap">
                                        <div class="price-wrap h4">
                                            <span class="price"></span>
                                            <del class="price-old"></del>
                                        </div>
                                        <p class="text-success">Free shipping</p>
                                        <br>
                                        <div style="text-align: center;">
                                            
                                            <button type="button" class="btn btn-primary btn-add-to-cart"
                                                    style="width: 60%"
                                                    data-id="'.$product["id"].'" '.(!isset($_SESSION['signedIn']) ? "disabled" : "").'>
                                                <i class="fas fa-cart-plus"></i>
                                                <span> CART</span>
                                            </button>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </article>';
                }
                ?>
            </main>
        </div>

    </div>
</section>

<?php
include "footer.php";
?>

<script type="text/javascript" src="./js/search-product.js"></script>
</body>
</html>