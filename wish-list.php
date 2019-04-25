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
    <title>Wish List</title>
    <link href="./css/ui.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./css/admin.css"/>
    <style>
        .btn-add-to-cart {
        }

        .btn-remove {
        }
    </style>
</head>
<body>
<?php
    include "navbar.php";
?>
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <div class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Personal Page</div>
        </div>
        <hr class="sidebar-divider my-0">
        <div class="sidebar-heading">
            Management
        </div>
        <li class="nav-item active">
            <a class="nav-link" href="./wish-list.php">
                <i class="fas fa-heart"></i>
                <span> Wish List</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./invoices.php">
                <i class="fas fa-file-invoice-dollar"></i>
                <span> Purchase History</span>
            </a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

    <div id="content-wrapper" class="d-flex flex-column" style="padding-top: 15px">
        <div class="container" id="content">
            <h3>Your Wish List (<span id="total-products" th:text="${#lists.size(products)}"></span>)</h3>
            <th:block th:each="product : ${products}">
                <article class="card card-product" th:id="'id-' + ${product.product.id}">
                    <div class="card-body">
                        <div class="row">
                            <aside class="col-sm-3">
                                <div class="img-wrap">
                                    <img th:src="${product.product.url}">
                                </div>
                            </aside>
                            <article class="col-sm-6">
                                <a class="title h4" style="text-decoration: none; font-weight: 500;"
                                   th:text="${product.product.productName}"
                                   th:href="'/product/' + ${product.product.id}"></a>
                                <div class="rating-wrap mb-2">
                                    <ul class="rating-stars">
                                        <li style="width: 100%" class="stars-active">
                                            <th:block th:if="${product.avgRating > 0}"
                                                      th:each="i : ${#numbers.sequence(0, product.avgRating)}">
                                                <i class="fa fa-star"></i>
                                            </th:block>
                                        </li>
                                        <li>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <div class="label-rating" style="padding-left: 10px"
                                         th:text="${product.totalRating} + ' reviews'"></div>
                                    <div class="label-rating" th:text="${product.totalOrder} + ' orders'"></div>
                                </div>
                                <p th:text="${product.product.description}"> Description here </p>
                                <dl class="dlist-align">
                                    <dt>Manufacturer</dt>
                                    <dd th:text="${product.manufacturer.manufacturerName}"></dd>
                                </dl>
                                <dl class="dlist-align">
                                    <dt>Screen Size</dt>
                                    <dd th:text="${product.product.screenSize} + ' inch'"></dd>
                                </dl>
                                <th:block th:each="store : ${product.storeQuantity}">
                                    <dl class="dlist-align">
                                        <dt th:text="${store.store.storeName}"></dt>
                                        <dd th:if="${store.quantity == 0}" class="text-danger font-weight-bold">Out
                                            of stock
                                        </dd>
                                        <dd th:if="${store.quantity != 0}"
                                            th:text="${store.quantity} + ' pcs'"></dd>
                                    </dl>
                                </th:block>
                            </article>
                            <aside class="col-sm-3 border-left">
                                <div class="action-wrap">
                                    <div class="price-wrap h4">
                                            <span class="price"
                                                  th:text="${#numbers.formatDecimal(product.product.price, 0, 'POINT', 0, 'COMMA')} + ' ₫'"></span>
                                        <del class="price-old"></del>
                                    </div>
                                    <p class="text-success">Free shipping</p>
                                    <br>
                                    <div style="text-align: center;">
                                        <button type="button" class="btn btn-primary btn-add-to-cart"
                                                style="width: 80%"
                                                th:attr="data-id=${product.product.id}">
                                            <i class='fas fa-cart-plus'></i>
                                            <span> CART</span>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-remove"
                                                style="width: 80%; margin-top: 15px;"
                                                th:attr="data-id=${product.product.id}">
                                            <i class="fas fa-times"></i>
                                            <span> Remove from list</span>
                                        </button>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </article>
            </th:block>
        </div>
        <?php
            include "footer.php";
        ?>
    </div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<script type="text/javascript" src="./js/customer/wish-list.js"></script>
</body>
</html>