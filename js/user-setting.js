(function ($) {
    $("#update-information-button").click(function () {
        let name = $("#full-name").val();
        let address = $("#address").val();
        let phone = $("#phone").val();

        if (name.length != 0 && address != 0 && phone != 0) {
            $.post("/update-information", {name: name, address: address, phone: phone}, function (response) {
                window.location.href = "/";
            });
        }
    });
})(jQuery);