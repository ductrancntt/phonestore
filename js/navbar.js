(function ($) {
    let url = new URL(window.location.href);
    $("#search-product").val(url.searchParams.get("productName"));

    $("#search-button").click(function () {
        url = "./search-result.php?productName=" + $("#search-product").val().trim();
        try {
            let manufacturers = Array.from(selectedManufacturers);
            if (manufacturers.length > 0) {
                url += "&manufacturers=";
                manufacturers.forEach(function (ele) {
                    url += ele + ",";
                });
                url = url.substr(0, url.length - 1);
            }

        } catch (e) {

        }

        window.location.href = url;
    });

    $("#search-product").keyup(function (event) {
        if (event.keyCode === 13) {
            $("#search-button").click();
        }
    });


})(jQuery);

function logout() {
    sessionStorage.removeItem("userCart");
    window.location.href = "/logout";
}


