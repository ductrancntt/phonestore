(function ($) {
    $("#update-information-button").click(function () {
        let name = $("#full-name").val().trim();
        let address = $("#address").val().trim();
        let phone = $("#phone").val().trim();
        let email = $("#email").val().trim();

        if (name.length != 0 || address.length != 0 || phone.length != 0 || email.length != 0) {
            $.post("./service/updateInformation.php", {name: name, address: address, phone: phone, email: email}, function () {
                window.location.href = "./home.php";
            });
        }
    });
})(jQuery);