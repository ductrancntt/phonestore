(function ($) {

    $('#password, #confirm-password').on('keyup', function () {
        if ($('#password').val() == $('#confirm-password').val()) {

        } else {

        }
    });

    $("#signup-button").click(function () {
        let username = $("#username").val();
        let password = $("#password").val();
        let confirmPassword = $("#confirm-password").val();
        let phone = $("#phone").val();
        let address = $("#address").val();
        let fullname = $("#fullname").val();

        let user = {
            'username': username,
            'password': password,
            'phone': phone,
            'address': address,
            'name': fullname
        }

        $.ajax({
            type: "POST",
            url: "/sign-up",
            data: JSON.stringify(user),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function () {
                window.location = "../sign.php";
            },
            error: function () {
                $("#username-error").css("display", "");
            }
        });
    });

})(jQuery);