$(document).ready(function () {
    $('#error').hide();
});
$("#login").click(function () {
    var email = $("#email").val();
    var password = $("#password").val();
    if (email == "" || password == "") {
        $('#error').html("<strong>Enter Email and Password</strong>");
        $('#error').show();
    }
    else {
        $.ajax({
            type: 'POST',
            url: 'php/verifyadmin.php',
            data: {email: email, password: password},
            success: function (response) {
                if (response == 1) {
                    window.open("index.php", "_self");
                }
                else if (response == 0) {
                    $('#error').html("<strong>Invalid Email or Password</strong>");
                    $('#error').show();
                    $("#email").val("");
                    $("#password").val("");
                }

            }
        });
    }
});