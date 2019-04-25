(function ($) {
    let url = new URL(window.location.href);
    $("#search-product").val(url.searchParams.get("productName"));

    $("#search-button").click(function () {
        // url = "/search-products?productName=" + $("#search-product").val();
        // try {
        //     let manufacturers = Array.from(selectedManufacturers);
        //     if (manufacturers.length > 0) {
        //         url += "&manufacturers=";
        //         manufacturers.forEach(function (ele) {
        //             url += ele + ",";
        //         });
        //         url = url.substr(0, url.length - 1);
        //     }
        //     if (min != null && max != null) {
        //         url += "&min=" + min;
        //         url += "&max=" + max;
        //     }
        // } catch (e) {

        // }

        window.location.href = "./search-result.php";
    });

    $("#search-product").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#search-button").click();
        }
    });

})(jQuery);

function logout() {
    sessionStorage.removeItem("userCart");
    window.location.href = "/logout";
}

let updateNumberCart = function () {
    if (sessionStorage.getItem("userCart") != null) {
        let currentCart = JSON.parse(sessionStorage.getItem("userCart"));
        let total = 0;
        currentCart.forEach(function (ele) {
            total += ele.quantity;
        });
        if (total > 0)
            $("#number-cart").text(total);
        else
            $("#number-cart").text("");
    } else {
        sessionStorage.setItem("userCart", JSON.stringify([]));
    }
};

let updateNumberWishList = function () {
    $.get("/api/wish-list/count", function (response) {
        if (response > 0)
            $("#number-wish-list").text(response);
        else
            $("#number-wish-list").text("");
    });
}