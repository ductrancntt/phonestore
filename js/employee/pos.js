(function ($) {

    let productSearchResult = [];

    let productKeyWord = "";

    let currentProducts = new Map();

    let renderCard = function (p) {
        let card = "<div class='card-deck col-auto mb-4 card-padding'>" +
            "<div class='card shadow card-width'>" +
            "<div class='card-header text-primary bg-light'>" +
            "<h5 class='my-0 font-weight-normal card-search-title-responsive'>" + p.product.productName + "</h5>" +
            "</div>" +
            "<div class='card-body'>" +
            "<div style='text-align: center;'>" +
            "<img src='" + p.product.url + "' style='width: 7vw;'>" +
            "</div>" +
            "<div class='phone-detail-card'>" +
            "<div class='row'>" +
            "<div class='bold' style='width: 50%'>Manufacturer</div>" +
            "<div style='width: 50%'>" + p.manufacturer.manufacturerName + "</div>" +
            "</div>" +
            "<div class='row'>" +
            "<div class='bold' style='width: 50%'>Screen Size</div>" +
            "<div style='width: 50%'>" + p.product.screenSize + " inch</div>" +
            "</div>" +
            "<div class='row'>" +
            "<div class='bold' style='width: 50%'>Quantity</div>" +
            "<div style='width: 50%'>";
        if (p.quantity == 0)
            card += "<span class='text-danger bold'>Out of Stock</span>";
        else
            card += p.quantity;
        card += "</div>" +
            "</div>" +
            "<div class='row'>" +
            "<div class='bold' style='width: 50%'>Price</div>" +
            "<div style='width: 50%'>" + formatNumber(p.product.price) + " ₫</div>" +
            "</div>" +
            "<div class='row'>" +
            "<div class='bold' style='width: 50%'>Description</div>" +
            "<div style='width: 50%'>" + p.product.description + "</div>" +
            "</div>" +
            "</div>" +
            "<div class='text-center'>" +
            "<div class='btn-group'>" +
            "<button type='button' class='btn btn-block btn-primary btn-add-to-cart-pos' data-id='" + p.id + "'";

        if (p.quantity == 0)
            card += " disabled";
        card += ">" +
            "<i class='fas fa-cart-plus'></i>" +
            "<span> ADD TO CART</span>" +
            "</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

        return card;
    }

    let renderSearchResult = function (products) {
        $("#result-search").empty();
        products.forEach(function (product) {
            $("#result-search").append(renderCard(product));
        });
        addToCartListener();
    }

    let searchProductByName = function () {
        productKeyWord = $("#search-product-input").val().trim();
        $.get("/api/employees/search-product", {productName: productKeyWord}, function (response) {
            productSearchResult = response;
            renderSearchResult(productSearchResult);
        });
    }

    let renderProductCart = function (p) {
        let productCart = "<div class='card border-primary mb-3 shadow-sm' style='width: 100%;'>" +
            "<div class='card-header modal-header' style='padding: 0.5rem 1rem;'>" +
            "<h5 class='modal-title text-primary modal-title-cart'>" + p.product.productName + "</h5>" +
            "<button type='button' class='close wish-list' aria-label='Close' style='border: none; outline:none;' data-id='" + p.id + "'>" +
            "<span aria-hidden='true'>&times;</span>" +
            "</button>" +
            "</div>" +
            "<div class='card-body'>" +
            "<div class='row'>" +
            "<div class='col-md-4 image-cart'>" +
            "<img src='" + p.product.url + "' style='width: 5vw;'>" +
            "</div>" +
            "<div class='col-md-8'>" +
            "<div class='row' style='padding-right: 15px'>" +
            "<div class='input-group mb-3'>" +
            "<div class='input-group-prepend'>" +
            "<span class='input-group-text input-cart-title'>Price</span>" +
            "</div>" +
            "<span class='form-control input-cart'>" + formatNumber(p.product.price) + "</span>" +
            "<div class='input-group-append'><span class='input-group-text input-cart'>₫</span></div>" +
            "</div>" +
            "<div class='input-group mb-3' style='margin-bottom: 0px !important;'>" +
            "<div class='input-group-prepend'>" +
            "<span class='input-group-text input-cart-title'>Quantity</span>" +
            "</div>" +
            "<input type='number' min='1' value='1' class='form-control input-cart' name='quantity' id='" + p.id + "'>" +
            "<div class='input-group-append'><span class='input-group-text input-cart'>pcs</span></div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

        return productCart;
    }

    let addToCartListener = function () {
        $("button.btn.btn-block.btn-primary").click(function () {
            let productStoreId = $(this).data("id");
            if (currentProducts.get(productStoreId) === undefined) {
                $.get("/api/product-stores/" + productStoreId, function (response) {
                    response.quantity = 1;
                    currentProducts.set(response.id, response);
                    $("#current-cart").append(renderProductCart(response));
                    let totalText = formatNumber(calculateCurrentTotal()) + " ₫";
                    $("#current-total").text(totalText);
                    addInputQuantityListener();
                    addRemoveCartListener();
                    renderPreviewInvoiceTable(totalText);
                });
            } else {
                let item = currentProducts.get(productStoreId);
                item.quantity++;
                currentProducts.set(productStoreId, item);
                $("#" + productStoreId).val(item.quantity);
                let totalText = formatNumber(calculateCurrentTotal()) + " ₫";
                $("#current-total").text(formatNumber(totalText));
                renderPreviewInvoiceTable(totalText);
            }
        });
    }

    let addInputQuantityListener = function () {
        $("input[type='number'][name='quantity']").bind('keyup mouseup', function () {
            let id = parseInt($(this).attr("id"));
            let quantity = $(this).val();
            let item = currentProducts.get(id);
            item.quantity = quantity;
            currentProducts.set(id, item);
            let totalText = formatNumber(calculateCurrentTotal()) + " ₫";
            $("#current-total").text(totalText);
            renderPreviewInvoiceTable(totalText);
        });
    }

    let addRemoveCartListener = function () {
        $("button.close.wish-list").click(function () {
            let id = parseInt($(this).data("id"));
            currentProducts.delete(id);
            let totalText = formatNumber(calculateCurrentTotal()) + " ₫";
            $("#current-total").text(totalText);
            renderPreviewInvoiceTable(totalText);
            $($($(this).parent()).parent()).remove();
        });
    }

    let calculateCurrentTotal = function () {
        let currentTotal = 0;
        currentProducts.forEach(function (p) {
            currentTotal += p.product.price * p.quantity;
        });

        return currentTotal;
    }

    $("#search-product-input").on('keypress', function (e) {
        let code = e.keyCode || e.which;
        if (code == 13)
            searchProductByName();
    });

    $("#search-button").click(function () {
        searchProductByName();
    });

    let validatePhoneNumber = function (phone) {
        return phone.match("(09|01[2|6|8|9])+([0-9]{8})\\b");
    }

    $("#checkout-button").click(function () {
        let customerName = $("input[name='customer-name']").val().trim();
        let phone = $("input[name='phone']").val().trim();
        let address = $("input[name='address']").val().trim();

        if (currentProducts.size != 0 && customerName.length != 0 && validatePhoneNumber(phone) && address.length != 0) {
            let invoice = {
                customer: {
                    id: null,
                    user: null,
                    customerName: customerName,
                    address: address,
                    phone: phone,
                    online: false
                },
                items: Array.from(currentProducts.values())
            };

            $.ajax({
                type: "POST",
                url: "/api/invoices/offline",
                data: JSON.stringify(invoice),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function () {
                    $("#successModal").modal('show');
                    $("#result-search").empty();
                    $("#current-cart").empty();
                    $("#current-total").text("0 ₫");
                    $("input[type='text']").val("");
                    currentProducts.clear();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else if (currentProducts.size == 0) {
            $("#errorMessage").text("CURRENT CART IS EMPTY!");
            $("#errorModal").modal('show');
        } else if (!validatePhoneNumber(phone)) {
            $("input[name='phone']").val("");
            $("#errorMessage").text("INVALID PHONE NUMBER!");
            $("#errorModal").modal('show');
        } else {
            $("#errorMessage").text("MISSING CUSTOMER'S INFORMATION!");
            $("#errorModal").modal('show');
        }
    });

    $("input[name='customer-name']").keyup(function () {
        $("#customer-name").text($(this).val());
    });

    $("input[name='phone']").keyup(function () {
        $("#customer-phone").text($(this).val());
    });

    $("input[name='address']").keyup(function () {
        $("#customer-address").text($(this).val());
    });

    let renderPreviewInvoiceTable = function (total) {
        $("#product-list tbody").empty();
        currentProducts.forEach(function (p) {
            let row = "<tr>";
            row += "<td>" + p.product.productName + "</td>";
            row += "<td>" + formatNumber(p.product.price) + " ₫</td>";
            row += "<td>" + p.quantity + " pcs</td>";
            row += "<td>" + formatNumber(p.product.price * p.quantity) + " ₫</td>";
            $("#product-list tbody").append(row);
        });

        $("#product-list tbody").append("<tr><th colspan='3' scope='col' style='text-align: center'>Total Invoice</th><td>" + total + "</td></tr>");
    }

})(jQuery);