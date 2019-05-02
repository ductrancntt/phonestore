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

    <title>Product Detail</title>
    <link href="./css/ui.css" rel="stylesheet" type="text/css">

    <link href="./libs/fancybox/jquery.fancybox.min.css" rel="stylesheet" type="text/css">
    <script src="./libs/fancybox/jquery.fancybox.min.js" type="text/javascript"></script>

    <style>
        .btn-add-to-wish-list {
        }
    </style>
</head>
<body>
<?php
include "navbar.php";
?>
<?php
require "./service/Connection.php";
$product = null;
if (isset($_GET["id"])) {
    $connection = new Connection();
    $connection->createConnection();
    $sql = "SELECT p.*, m.name as manufacturer_name  FROM product p JOIN manufacturer m ON m.id = p.manufacturer_id  WHERE p.id = " . $_GET["id"];

    $result = $connection->excuteQuery($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product = $row;
            break;
        }
        $connection->closeConnection();

    } else {
        $connection->closeConnection();
    }
}
?>
<div>
    <section class="section-content bg padding-y-sm">
        <div class="container">
            <nav class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
                    <li class="breadcrumb-item"><a
                            <?php echo 'href="./search-result.php?manufacturers=' . $product["manufacturer_id"] . '"'; ?>><?php echo $product["manufacturer_name"]; ?></a>
                    </li>
                    <li class="breadcrumb-item active"><span><?php echo $product["name"]; ?></span></li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-xl-10 col-md-9 col-sm-12">

                    <main class="card">
                        <div class="row no-gutters">
                            <aside class="col-sm-6 border-right">
                                <article class="gallery-wrap">
                                    <div class="img-big-wrap">
                                        <div id="product-image" data-scale="1.25" style="transition: transform 0.2s">
                                            <a <?php echo "href='" . $product["image"] . "'"; ?> data-fancybox="">
                                                <?php echo '<img src=' . $product["image"] . '>'; ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="img-small-wrap">
                                        <div class="item-gallery">
                                            <?php echo '<img src=' . $product["image"] . '>'; ?>
                                        </div>
                                    </div>
                                </article>
                            </aside>
                            <aside class="col-sm-6">
                                <article class="card-body">
                                    <h3 class="title mb-3"><?php echo $product["name"]; ?></h3>

                                    <div class="mb-3">
                                        <var class="price h3 text-warning">
                                            <span>Price: </span>
                                            <span class="num"><?php echo number_format($product["price"]) . " đ"; ?></span>
                                        </var>
                                    </div>

                                    <dl class="row">
                                        <dt class="col-sm-5">Screen Size</dt>
                                        <dd class="col-sm-7">
                                            <span><?php echo $product["screen_size"]; ?></span>
                                            <span> inch</span>
                                        </dd>
                                        <dt class="col-sm-5">Memory</dt>
                                        <dd class="col-sm-7">
                                            <span><?php echo $product["memory"]; ?></span>
                                        </dd>
                                        <dt class="col-sm-5">Chipset</dt>
                                        <dd class="col-sm-7">
                                            <span><?php echo $product["chipset"]; ?></span>
                                        </dd>

                                        <dt class="col-sm-5">Quantity</dt>
                                        <?php
                                        if ($product["quantity"] == 0) {
                                            echo '<dd class="col-sm-7 text-danger font-weight-bold">Out of stock
                                                    </dd>';
                                        } else {
                                            echo '<dd class="col-sm-7">' . $product["quantity"] . '</dd>';
                                        }
                                        ?>

                                        <dt class="col-sm-5">Shipping</dt>
                                        <dd class="col-sm-7">
                                            <span class="text-success">Free Shipping</span>
                                        </dd>
                                    </dl>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php echo $product["description"]; ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text font-weight-bold">Quantity</span>
                                                </div>
                                                <input id="quantity-input" type="number" min="1" value="1"
                                                       class="form-control" style="text-align: center;"
                                                    <?php echo 'data-id="' . $_GET["id"] . '"'; ?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">

                                            <button type="button" class="btn btn-primary btn-add-to-cart"
                                                    style="width: 60%"
                                                <?php echo 'data-id="' . $_GET["id"] . '"'; ?>>
                                                <i class='fas fa-cart-plus'></i>
                                                <span onclick=""> CART</span>
                                            </button>
                                        </div>
                                    </div>
                                </article>
                            </aside>
                        </div>
                    </main>

<!--                    <article class="card mt-3">-->
<!--                        <div class="card-body">-->
<!--                            <h4>Product Detail</h4>-->
<!--                            <p>--><?php //echo $product["description"]; ?><!--</p>-->
<!--                        </div>-->
<!--                    </article>-->
                </div>
                <aside class="col-xl-2 col-md-3 col-sm-12">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Trade Assurance
                        </div>
                        <div class="card-body small">
                            <span>Phone Shop | Trading Company</span>
                            <hr>
                            Transaction Level: Good <br>
                            Supplier Assessments: Best
                            <hr>
                            11 Transactions $330,000+
                            <hr>
                            Response Time 24h <br>
                            Response Rate: 94% <br>
                            <hr>
                            <a href="/">Visit home</a>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header font-weight-bold">
                            You may like
                        </div>
                        <div class="card-body row">
                            <th:block th:each="product : ${recommendations}">
                                <div class="col-md-12 col-sm-3">
                                    <figure class="item border-bottom mb-3">
                                        <a href="#" class="img-wrap">
                                            <img th:src="${product.url}" class="img-small-wrap">
                                        </a>
                                        <figcaption class="info-wrap">
                                            <a th:href="'/product/' + ${product.id}" class="title font-weight-bold"
                                               th:text="${product.productName}"></a>
                                            <div class="price-wrap mb-3">
                                                <span class="price-new"
                                                      th:text="${#numbers.formatDecimal(product.price, 0, 'POINT', 0, 'COMMA')} + ' ₫'"></span>
                                                <del class="price-old"></del>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </div>
                            </th:block>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <div class="modal fade" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="comment-modal-title"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comment-modal-title">Review Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="display: flex; justify-content: center; padding-top: 15px; padding-bottom: 15px;">
                        <ul class="rating-stars rating-star-modal">
                            <li id="review-stars">
                                <i class="fa fa-star" id="1"></i>
                                <i class="fa fa-star" id="2"></i>
                                <i class="fa fa-star" id="3"></i>
                                <i class="fa fa-star" id="4"></i>
                                <i class="fa fa-star" id="5"></i>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="h5" style="padding-bottom: 15px;">Write Your Review</div>
                    <textarea id="review-comment" class="form-control" rows="5" style="resize: none"
                              placeholder="Is this product good or bad? Share your opinion here!"></textarea>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: center;">
                    <button type="button" class="btn btn-warning" th:attr="data-id=${product.product.id}"
                            id="submit-review">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
<script type="text/javascript" src="./js/product-detail.js"></script>
</body>
</html>