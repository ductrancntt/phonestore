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
            username: username,
            password: password,
            phone: phone,
            address: address,
            name: fullname
        }

        $.post('./service/doSignUp.php', {user: JSON.stringify(user)}, function(response) {
            window.location = "./signin.php";
        }).fail(function() {
            $("#username-error").css("display", "");
        });
    });

})(jQuery);