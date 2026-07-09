let currentStep = 1;

$(".otp-input").on("input", function () {

    if ($(this).val().length == 1) {
        $(this).next(".otp-input").focus();
    }

});

$(".otp-input").on("keydown", function (e) {

    if (e.key === "Backspace" && $(this).val() === "") {

        $(this).prev(".otp-input").focus();

    }

});



$("#loginForm").submit(function (e) {

    e.preventDefault();

    if (currentStep == 1) {

        checkEmail();

    }

    else if (currentStep == 2) {

        verifyOTP();

    }

    else if (currentStep == 3) {

        updatePassword();

    }

});






function checkEmail(){

    let email = $("#email").val().trim();

    $.ajax({

        url: "../ajax/forgot_password_ajax.php",

        type: "POST",

        data: {

            email: email

        },

        dataType: "json",

        success: function (response) {

    if (response.status) {

         currentStep = 2;


        console.log(response);

     
        $("#emailSection").addClass("d-none");

        $("#otpSection").removeClass("d-none");

        $("#btnText").text("Verify OTP");

    } else {

        alert(response.message);

    }

}

    });

}


function verifyOTP() {

    let email = $("#email").val().trim();

    let otp =
        $("#otp1").val() +
        $("#otp2").val() +
        $("#otp3").val() +
        $("#otp4").val() +
        $("#otp5").val() +
        $("#otp6").val();

    $.ajax({

        url: "../ajax/verify_otp_ajax.php",

        type: "POST",

        data: {

            email: email,
            otp: otp

        },

        dataType: "json",

        success: function (response) {

            if (response.status) {

                 alert(response.message);

                currentStep = 3;

                $("#otpSection").addClass("d-none");

                $("#passwordSection").removeClass("d-none");

                $("#btnText").text("Update Password");

            } else {

                alert(response.message);

            }

        }

    });

}



function updatePassword() {

    let email = $("#email").val().trim();

    let newPassword = $("#newPassword").val().trim();

    let confirmPassword = $("#confirmPassword").val().trim();

    $.ajax({

        url: "../ajax/reset_password_ajax.php",

        type: "POST",

        data: {

            email: email,
            newPassword: newPassword,
            confirmPassword: confirmPassword

        },

        dataType: "json",

        success: function (response) {

            if (response.status) {

                alert(response.message);

                window.location.href = "login.php";

            } else {

                alert(response.message);

            }

        }

    });

}