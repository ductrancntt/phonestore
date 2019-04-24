(function ($) {

    let currentProductCart = new Map();

    let currentCustomer = null;

    let renderCurrentProducts = function (product) {
        let html = "<div class='card border-primary mb-3 shadow-sm' style='width: 100%;'>" +
            "<div class='card-header modal-header' style='padding: 0.5rem 1rem;'>" +
            "<h5 class='modal-title text-primary modal-title-cart'>" + product.productName + "</h5>" +
            "<button type='button' class='close wish-list' aria-label='Close' style='border: none; outline:none;' data-id='" + product.id + "'>" +
            "<span aria-hidden='true'>&times;</span>" +
            "</button>" +
            "</div>" +
            "<div class='card-body'>" +
            "<div class='row'>" +
            "<div class='col-md-3 image-cart'>" +
            "<img src='" + product.url + "' style='width: 5vw;'>" +
            "</div>" +
            "<div class='col-md-4'>" +
            "<div class='row customer-cart-font'>" +
            "<div class='bold' style='width: 50%;'>Manufacturer</div>" +
            "<div style='width: 50%;'>" + product.manufacturerName + "</div>" +
            "</div>" +
            "<div class='row customer-cart-font'>" +
            "<div class='bold' style='width: 50%;'>Screen Size</div>" +
            "<div style='width: 50%;'>" + product.screenSize + " inch</div>" +
            "</div>" +
            "<div class='row customer-cart-font'>" +
            "<div class='bold' style='width: 50%;'>Description</div>" +
            "<div style='width: 50%;'>" + product.description + "</div>" +
            "</div>" +
            "</div>" +
            "<div class='col-md-5'>" +
            "<div class='row' style='padding-right: 15px;'>" +
            "<div class='input-group mb-3'>" +
            "<div class='input-group-prepend'>" +
            "<span class='input-group-text customer-cart-title'>Price</span>" +
            "</div>" +
            "<span class='form-control customer-cart-font'>" + formatNumber(product.price) + "</span>" +
            "<div class='input-group-append'><span class='input-group-text customer-cart-font'>₫</span></div>" +
            "</div>" +
            "<div class='input-group mb-3' style='margin-bottom: 0px !important;'>" +
            "<div class='input-group-prepend'>" +
            "<span class='input-group-text customer-cart-title'>Quantity</span>" +
            "</div>" +
            "<input type='number' min='1' value='" + product.quantity + "' class='form-control customer-cart-font' name='quantity' id='" + product.id + "'>" +
            "<div class='input-group-append'><span class='input-group-text customer-cart-font'>pcs</span></div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

        return html;
    }

    let getCurrentCart = function () {
        let userCart = JSON.parse(sessionStorage.getItem("userCart"));
        let cartMap = userCart.reduce((map, product) => {
            return map.set(product.productId, product.quantity);
        }, new Map());

        $("#current-cart").empty();

        $.get("/api/products/list", {"listId[]": Array.from(cartMap.keys())}, function (response) {
            currentProductCart = response.reduce((map, product) => {
                return map.set(product.id, product);
            }, new Map());
            currentProductCart.forEach(function (product) {
                product.quantity = cartMap.get(product.id);
                $("#current-cart").append(renderCurrentProducts(product));
            });
            addRemoveProductCartListener();
            addQuantityChangeListener();
            renderInvoiceItems(formatNumber(calculateTotal()));
        });

    }

    let addRemoveProductCartListener = function () {
        $("button.close.wish-list").click(function () {
            let userCart = JSON.parse(sessionStorage.getItem("userCart"));
            let cartMap = userCart.reduce((map, product) => {
                return map.set(product.productId, product.quantity);
            }, new Map());
            cartMap.delete($(this).data("id"));
            currentProductCart.delete($(this).data("id"));

            userCart = [];
            cartMap.forEach(function (value, key) {
                userCart.push({
                    productId: key,
                    quantity: value
                });
            });

            sessionStorage.setItem("userCart", JSON.stringify(userCart));

            updateNumberCart();

            renderInvoiceItems(formatNumber(calculateTotal()));

            $($($(this).parent()).parent()).remove();
        });
    }

    let addQuantityChangeListener = function () {
        $("input[type='number'][name='quantity']").bind('keyup mouseup', function () {
            let productId = parseInt($(this).attr('id'));
            let product = currentProductCart.get(productId);
            product.quantity = parseInt($(this).val());
            currentProductCart.set(productId, product);

            let userCart = [];
            currentProductCart.forEach(function (p) {
                userCart.push({
                    productId: p.id,
                    quantity: p.quantity
                });
            });

            sessionStorage.setItem("userCart", JSON.stringify(userCart));

            updateNumberCart();

            renderInvoiceItems(formatNumber(calculateTotal()));
        });
    }

    let calculateTotal = function () {
        let total = 0;
        currentProductCart.forEach(function (product) {
            total += product.quantity * product.price;
        });

        return total;
    }

    let loadCustomerInfo = function () {
        $.get("/api/customers/current", function (response) {
            currentCustomer = response;
            $("#customer-name").text(response.customerName);
            $("#customer-phone").text(response.phone);
            $("#customer-address").text(response.customerAddress);
        });
    }

    let renderInvoiceItems = function (total) {
        $("#product-list tbody").empty();

        currentProductCart.forEach(function (p) {
            let row = "<tr>";
            row += "<td>" + p.productName + "</td>";
            row += "<td>" + formatNumber(p.price) + " ₫</td>";
            row += "<td>" + p.quantity + " pcs</td>";
            row += "<td>" + formatNumber(p.price * p.quantity) + " ₫</td>";
            $("#product-list tbody").append(row);
        });

        $("#product-list tbody").append("<tr><th colspan='3' scope='col' style='text-align: center'>Total Invoice</th><td>" + total + " ₫</td></tr>");
    }

    let initStores = function () {
        $.get("/api/stores", function (response) {
            response.forEach(function (store) {
                $("#store-selector").append("<option value='" + store.id + "'>" + store.storeName + "</option>");
            });
        });
    }

    $("#checkout-button").click(function () {
        if (currentProductCart.size == 0)
            $("#errorModal").modal("show");
        else {
            let invoice = {
                customerId: currentCustomer.id,
                storeId: parseInt($("#store-selector").val()),
                products: Array.from(currentProductCart.values())
            }

            $.ajax({
                type: "POST",
                url: "/api/invoices/online",
                data: JSON.stringify(invoice),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function () {
                    $("#successModal").modal('show');
                    sessionStorage.setItem("userCart", JSON.stringify([]));
                    currentProductCart = [];
                    $("#current-cart").empty();
                    $("#product-list tbody").empty();
                    $("#product-list tbody").append("<tr><th colspan='3' scope='col' style='text-align: center'>Total Invoice</th><td>0 ₫</td></tr>");
                    updateNumberCart();
                },
                error: function (error) {
                    console.log(error);
                }
            });

        }

    });

    $("#go-home").click(function () {
        window.location.href = "/";
    });

    getCurrentCart();
    loadCustomerInfo();
    initStores();

})(jQuery);