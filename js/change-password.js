(function ($) {
    $("#change-password-button").click(function () {
        let password = $("#password").val();
        let newPassword = $("#new-password").val();
        let confirmPassword = $("#confirm-password").val();

        if (confirmPassword !== newPassword) {
            $("#password-error").text("Confirm Password does not match!");
            $("#password-error").css("display", "");
        } else {
            $.post("/change-password", {password: password, newPassword: newPassword}, function (response) {
                window.location.href = "/";
            }).fail(function () {
                $("#password-error").text("Wrong Password!")
                $("#password-error").css("display", "");
            });
        }
    });
})(jQuery);