let min = null;

let max = null;

let selectedManufacturers = new Set();

let url = new URL(window.location.href);

(function ($) {

    let addToCartListener = function () {
        $("button.btn.btn-primary.btn-add-to-cart").click(function () {
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

    try {
        let manufacturers = url.searchParams.get("manufacturers").split(",");
        manufacturers.forEach(function (id) {
            $("#" + id + "m").prop('checked', true);
            selectedManufacturers.add(id);
        });
    } catch (e) {

    }

    min = url.searchParams.get("min");
    max = url.searchParams.get("max");

    $("#min-price").val(min);
    $("#max-price").val(max);

    $("#apply-button").click(function () {
        let url = "/search-products?productName=" + $("#search-product").val();
        let manufacturers = Array.from(selectedManufacturers);
        if (manufacturers.length > 0) {
            url += "&manufacturers=";
            manufacturers.forEach(function (ele) {
                url += ele + ",";
            });
            url = url.substr(0, url.length - 1);
        }
        if (min != null && max != null) {
            url += "&min=" + min;
            url += "&max=" + max;
        }
        window.location.href = url;
    });

    $("#min-price").change(function () {
        if (max != null) {
            if ($(this).val() >= max) {
                $(this).val(max);
            } else
                min = $(this).val();
        } else {
            min = $(this).val();
        }
    });

    $("#max-price").change(function () {
        if (min != null) {
            if ($(this).val() <= min)
                $(this).val(min);
            else
                max = $(this).val();
        } else {
            max = $(this).val();
        }
    });

    $("#clear-button").click(function () {
        min = null;
        max = null;
        $("#min-price").val("");
        $("#max-price").val("");
    });

    $("#check-all").change(function () {
        $("input[type='checkbox']").prop('checked', $(this).prop("checked"));
        if ($(this).prop("checked")) {
            $(".brand-checkbox").each(function () {
                selectedManufacturers.add(this.value);
            });
        } else {
            selectedManufacturers.clear();
        }
    });

    $(".brand-checkbox").each(function () {
        $(this).change(function () {
            if ($(this).prop("checked")) {
                selectedManufacturers.add(this.value);
                isCheckedAll();
            } else {
                selectedManufacturers.delete(this.value);
                $("#check-all").prop("checked", false);
            }
        });
    });

    let isCheckedAll = function () {
        let checkedAll = true;
        $(".brand-checkbox").each(function () {
            if (!selectedManufacturers.has(this.value))
                checkedAll = false;
        });

        if (checkedAll)
            $("#check-all").prop("checked", true);
        else
            $("#check-all").prop("checked", false);

        return checkedAll;
    }

    addToCartListener();
    isCheckedAll();

    if (min != null && max != null) {
        $("#price-range").addClass('show');
    }

    let addToWishListListener = function () {
        $("button.btn.wish-list.btn-add-to-wish-list").off("click");
        $("button.btn.wish-list.btn-add-to-wish-list").click(function () {
            $(this).tooltip('dispose');
            let id = $(this).data("id");
            $.post("/api/wish-list/add", {productId: id}, function () {
                updateNumberWishList();
                $("button.btn.wish-list.btn-add-to-wish-list[data-id='" + id + "']").replaceWith("<button type='button' class='btn btn-remove-wish-list' data-toggle='tooltip' data-placement='top' title='Remove from Wishlist' data-id='" + id + "'>" +
                    "<i class='fas fa-heart'></i>" +
                    "</button>");
                removeFromWishListListener();
                $("button[data-toggle='tooltip']").tooltip();
            });
        });
    }

    let removeFromWishListListener = function () {
        $("button.btn.btn-remove-wish-list").off("click");
        $("button.btn.btn-remove-wish-list").click(function () {
            $(this).tooltip('dispose');
            let id = $(this).data("id");
            $.post("/api/wish-list/remove", {productId: id}, function () {
                updateNumberWishList();
                $("button.btn.btn-remove-wish-list[data-id='" + id + "']").replaceWith("<button type='button' class='btn wish-list btn-add-to-wish-list' data-toggle='tooltip' data-placement='top' title='Add to Wishlist' data-id='" + id + "'>" +
                    "<i class='far fa-heart'></i>" +
                    "</button>");
                addToWishListListener();
                $("button[data-toggle='tooltip']").tooltip();
            });
        });
    }

    addToWishListListener();
    removeFromWishListListener();

})(jQuery);