(function ($) {

    let generateProductCard = function (product) {
        let status = " disabled";
        if (authenticated)
            status = "";

        let productCard = "<div class='col-md-3'>" +
            "<figure class='card card-product'>" +
            "<div class='img-wrap'>" +
            "<img src='" + product.url + "'>" +
            "<a class='btn-overlay' href='/product/" + product.id + "'><i class='fa fa-search'></i> Detail</a>" +
            "</div>" +
            "<figcaption class='info-wrap'>" +
            "<a href='/product/" + product.id + "' class='title'>" + product.productName + "</a>" +
            "<div class='action-wrap'>" +
            "<button type='button' class='btn btn-primary btn-sm float-right' data-id='" + product.id + "'" + status + ">" +
            "<i class='fas fa-cart-plus'></i>" +
            "<span> ADD</span>" +
            "</button>";
        if (product.inWishList) {
            productCard += "<button type='button' class='btn btn-remove-wish-list btn-sm float-right' data-toggle='tooltip' data-placement='top' title='Remove from Wishlist' data-id='" + product.id + "'" + status + ">" +
                "<i class='fas fa-heart'></i>" +
                "</button>";
        } else {
            productCard += "<button type='button' class='btn wish-list btn-sm float-right' data-toggle='tooltip' data-placement='top' title='Add to Wishlist' data-id='" + product.id + "'" + status + ">" +
                "<i class='far fa-heart'></i>" +
                "</button>";
        }
        productCard += "<div class='price-wrap h5'>" +
            "<span class='price-new'>" + formatNumber(product.price) + " ₫</span>" +
            "<del class='price-old'></del>" +
            "</div>" +
            "</div>" +
            "</figcaption>" +
            "</figure>" +
            "</div>";

        return productCard;
    }

    let loadProductsHomePage = function () {
        $("#top-sellers").empty();
        $("#recommended-phones").empty();

        $.get("/api/public/products/top-sellers", function (response) {
            response.forEach(function (product) {
                $("#top-sellers").append(generateProductCard(product));
            });

            $.get("/api/public/products/recommended-phones", function (response) {
                response.forEach(function (product) {
                    $("#recommended-phones").append(generateProductCard(product));
                });

                addToCartListener();
                addToWishListListener();
                removeFromWishListListener();
                $("button[data-toggle='tooltip']").tooltip();
            });
        });
    }

    let addToCartListener = function () {
        $("button.btn.btn-primary.btn-sm.float-right").click(function () {
            let currentCart = JSON.parse(sessionStorage.getItem("userCart"));

            let cartMap = currentCart.reduce((map, product) => {
                return map.set(product.productId, product.quantity);
            }, new Map());

            let productId = $(this).data("id");

            if (cartMap.has(productId)) {
                let quantity = parseInt(cartMap.get(productId));
                quantity++;
                cartMap.set(productId, quantity);
            } else {
                cartMap.set(productId, 1);
            }

            currentCart = [];
            cartMap.forEach(function (value, key) {
                currentCart.push({
                    productId: key,
                    quantity: value
                });
            });

            sessionStorage.setItem("userCart", JSON.stringify(currentCart));
            updateNumberCart();
        });
    }

    let addToWishListListener = function () {
        $("button.btn.wish-list.btn-sm.float-right").off("click");
        $("button.btn.wish-list.btn-sm.float-right").click(function () {
            $(this).tooltip('dispose');
            let id = $(this).data("id");
            $.post("/api/wish-list/add", {productId: id}, function () {
                updateNumberWishList();
                $("button.btn.wish-list.btn-sm.float-right[data-id='" + id + "']").replaceWith("<button type='button' class='btn btn-remove-wish-list btn-sm float-right' data-toggle='tooltip' data-placement='top' title='Remove from Wishlist' data-id='" + id + "'>" +
                    "<i class='fas fa-heart'></i>" +
                    "</button>");
                removeFromWishListListener();
                $("button[data-toggle='tooltip']").tooltip();
            });
        });
    }

    let removeFromWishListListener = function () {
        $("button.btn.btn-remove-wish-list.btn-sm.float-right").off("click");
        $("button.btn.btn-remove-wish-list.btn-sm.float-right").click(function () {
            $(this).tooltip('dispose');
            let id = $(this).data("id");
            $.post("/api/wish-list/remove", {productId: id}, function () {
                updateNumberWishList();
                $("button.btn.btn-remove-wish-list.btn-sm.float-right[data-id='" + id + "']").replaceWith("<button type='button' class='btn wish-list btn-sm float-right' data-toggle='tooltip' data-placement='top' title='Add to Wishlist' data-id='" + id + "'>" +
                    "<i class='far fa-heart'></i>" +
                    "</button>");
                addToWishListListener();
                $("button[data-toggle='tooltip']").tooltip();
            });
        });
    }

    let init = function () {
        if (sessionStorage.getItem("userCart") == null)
            sessionStorage.setItem("userCart", JSON.stringify([]));

        loadProductsHomePage();
    }

    init();


})(jQuery);