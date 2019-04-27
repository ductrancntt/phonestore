(function ($) {
    $("#update-information-button").click(function () {
        let name = $("#full-name").val();
        let address = $("#address").val();
        let phone = $("#phone").val();
        let email = $("#email").val();

        if (name.length != 0 || address.length != 0 || phone.length != 0 || email.length != 0) {
            $.post("./service/updateInformation.php", {name: name, address: address, phone: phone, email: email}, function () {
                window.location.href = "./home.php";
            });
        }
    });
})(jQuery);