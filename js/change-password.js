(function ($) {
    $("#change-password-button").click(function () {
        let password = $("#password").val();
        let newPassword = $("#new-password").val();
        let confirmPassword = $("#confirm-password").val();

        if (confirmPassword !== newPassword) {
            $("#password-error").text("Confirm Password does not match!");
            $("#password-error").css("display", "");
        } else {
            $.post("./service/changePassword.php", {password: password, newPassword: newPassword}, function (response) {
                window.location.href = "./home.php";
            }).fail(function () {
                $("#password-error").text("Wrong Password!")
                $("#password-error").css("display", "");
            });
        }
    });
})(jQuery);