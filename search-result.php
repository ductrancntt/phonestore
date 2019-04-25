<!DOCTYPE html>
<html>
<head>
    <?php
        include "header.php";
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

<section>
    <div class="banner">
        <img src="./image/banner.jpg" class="banner-image">
        <span class="banner-text">PHONE SHOP</span>
    </div>
</section>

<section class="section-content bg padding-y">
    <div class="container">

        <nav class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.html">Home</a></li>
                <li class="breadcrumb-item active">
                    <span>Search Result - </span>
                    <span th:if="${#lists.size(products)} > 0" th:text="${#lists.size(products)} + ' products'"></span>
                    <span th:if="${#lists.size(products)} == 0">0 product</span>
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
                                    <th:block th:each="manufacturer : ${manufacturers}">
                                        <li>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input brand-checkbox"
                                                       th:value="${manufacturer.id}" th:id="${manufacturer.id} + 'm'">
                                                <label class="custom-control-label"
                                                       th:text="${manufacturer.manufacturerName}"
                                                       th:for="${manufacturer.id} + 'm'"></label>
                                            </div>
                                        </li>
                                    </th:block>
                                </ul>
                            </div>
                        </div>
                    </article>
                    <article class="card-group-item">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#price-range">
                                <i class="icon-action fa fa-chevron-down"></i>
                                <h6 class="title">Price Range</h6>
                            </a>
                        </header>
                        <div class="filter-content collapse" id="price-range">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>From</label>
                                        <div class="input-group">
                                            <input class="form-control text-right" min="100000" step="50000"
                                                   placeholder="Min Price" type="number" id="min-price">
                                            <div class='input-group-append'>
                                                <span class='input-group-text font-responsive'>₫</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>To</label>
                                        <div class="input-group">
                                            <input class="form-control text-right" min="1000000" max="100000000"
                                                   step="50000" placeholder="Max Price" type="number" id="max-price">
                                            <div class='input-group-append'>
                                                <span class='input-group-text font-responsive'>₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-block btn-outline-danger" id="clear-button">Clear Price</button>
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
                <div th:if="${#lists.size(products)} == 0"
                     style="padding-top: 50px; display: flex; justify-content: center;">
                    <span class="h3 text-warning"><i class="fas fa-exclamation-circle"></i> NO PRODUCT WAS FOUND!</span>
                </div>
                <th:block th:each="product : ${products}">
                    <article class="card card-product">
                        <div class="card-body">
                            <div class="row">
                                <aside class="col-sm-3">
                                    <div class="img-wrap">
                                        <img th:src="${product.product.url}">
                                    </div>
                                </aside>
                                <article class="col-sm-6">
                                    <a class="title h4" th:text="${product.product.productName}"
                                       th:href="'/product/' + ${product.product.id}"></a>
                                    <div class="rating-wrap mb-2">
                                        <ul class="rating-stars">
                                            <li style="width: 100%" class="stars-active">
                                                <th:block th:if="${product.avgRating > 0}"
                                                          th:each="i : ${#numbers.sequence(0, product.avgRating - 1)}">
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
                                            <button type="button" class="btn wish-list btn-add-to-wish-list"
                                                    data-toggle='tooltip' data-placement='top' title='Add to Wishlist'
                                                    th:attr="data-id=${product.product.id}"
                                                    th:disabled="${!authenticated}"
                                                    th:if="${!product.inWishList}">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            <button type="button" class="btn btn-remove-wish-list"
                                                    data-toggle='tooltip' data-placement='top'
                                                    title='Remove from Wishlist'
                                                    th:attr="data-id=${product.product.id}"
                                                    th:disabled="${!authenticated}"
                                                    th:if="${product.inWishList}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-add-to-cart"
                                                    style="width: 60%"
                                                    th:attr="data-id=${product.product.id}"
                                                    th:disabled="${!authenticated}">
                                                <i class='fas fa-cart-plus'></i>
                                                <span> CART</span>
                                            </button>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </article>
                </th:block>
            </main>
        </div>

    </div>
</section>

<?php
    include "footer.php";
?>
<script type="text/javascript" src="/js/search-product.js"></script>
</body>
</html>