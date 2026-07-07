const form = document.getElementById("signupForm");
const email = document.getElementById("email");
const password = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const toggleIcon = document.getElementById("toggleIcon");
const signupBtn = document.getElementById("signupBtn");
const btnText = document.getElementById("btnText");
const btnSpinner = document.getElementById("btnSpinner");
const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

togglePassword.addEventListener("click", () => {
    if (password.type === "password") {

        password.type = "text";
        toggleIcon.classList.replace("bi-eye", "bi-eye-slash");

    } else {

        password.type = "password";
        toggleIcon.classList.replace("bi-eye-slash", "bi-eye");


    }
});

email.addEventListener("input", function () {
    email.classList.remove("is-invalid");
});

password.addEventListener("input", function () {
    password.classList.remove("is-invalid");
});

form.addEventListener("submit", function (e) {


    e.preventDefault();
    let isFormValid = true;
    if (!emailPattern.test(email.value.trim())) {
        email.classList.add("is-invalid");
        isFormValid = false;
    } else {
        email.classList.remove("is-invalid");
    }
    if (password.value.trim().length < 8) {
        password.classList.add("is-invalid");
        isFormValid = false;
    } else {
        password.classList.remove("is-invalid");
    }

    if (!isFormValid) {
        return;
    }

    signupBtn.disabled = true;

    togglePassword.disabled = true;

    btnText.textContent = "Signing up..";

    btnSpinner.classList.remove("d-none");

    $.ajax({

        url: "../ajax/signup_ajax.php",

        type: "POST",

        data: {

            email: email.value.trim(),

            password: password.value.trim()

        },

        dataType: "json",

        success: function (response) {

            signupBtn.disabled = false;

            togglePassword.disabled = false;

            btnText.textContent = "Sign Up";

            btnSpinner.classList.add("d-none");

            alert(response.message);

            if (response.status) {

                form.reset();

            }

        },

        error: function () {

            signupBtn.disabled = false;

            togglePassword.disabled = false;

            btnText.textContent = "Sign Up";

            btnSpinner.classList.add("d-none");

            alert("Something went wrong. Please try again.");

        }

    });
});