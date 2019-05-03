(function ($) {
    $("#update-information-button").click(function () {
        let name = $("#full-name").val().trim();
        let address = $("#address").val().trim();
        let phone = $("#phone").val().trim();
        let email = $("#email").val().trim();

        if (validateEmail(email)) {
            if (name.length != 0 || address.length != 0 || phone.length != 0) {
                $.post("./service/updateInformation.php", {name: name, address: address, phone: phone, email: email}, function () {
                    window.location.href = "./home.php";
                });
            } else {
                $("#error").text("Required fields are empty!");
                $("#error").css("display", "");
            }
        } else {
            $("#error").text("Invalid Email!");
            $("#error").css("display", "");
        }
    });
})(jQuery);