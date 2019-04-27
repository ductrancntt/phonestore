(function ($) {

    $("#signup-button").click(function () {
        let username = $("#username").val().trim();
        let password = $("#password").val().trim();
        let confirmPassword = $("#confirm-password").val().trim();
        let phone = $("#phone").val().trim();
        let address = $("#address").val().trim();
        let fullname = $("#fullname").val().trim();
        let email = $("#email").val().trim();

        if ((password == confirmPassword)) {
            if (username.length != 0 && email.length != 0 && password.length != 0 && fullname.length != 0) {
                let user = {
                    username: username,
                    password: password,
                    phone: phone,
                    address: address,
                    name: fullname,
                    email: email
                }

                $.post('./service/doSignUp.php', {user: JSON.stringify(user)}, function(response) {
                    window.location = "./signin.php";
                }).fail(function() {
                    $("#error").text("Please choose another name!");
                    $("#error").css("display", "");
                });
            } else {
                $("#error").text("Required fields are empty!");
                $("#error").css("display", "");
            }
        } else {
            $("#error").text("Passwords are not matched!");
            $("#error").css("display", "");
        }
    });

})(jQuery);