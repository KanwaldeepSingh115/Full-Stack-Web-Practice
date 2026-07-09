<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login System</title>

    <link rel="icon" type="image/x-icon" href="../assets/images/map.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <section class="login-section">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-5 col-md-7 col-sm-10">

                    <div class="login-card">

                        <!-- Logo -->

                        <div class="text-center mb-4">

                            <img src="../assets/images/logo.png" class="logo" alt="Logo">

                        </div>

                        <!-- Heading -->

                        <h2 class="text-center fw-bold">
                            Forgot Password
                        </h2>

                        <p class="text-center text-muted mb-4">
                            Fill Below Details
                        </p>

                        <!-- Form -->

                        <form id="loginForm">

                            <!-- Email -->

                            <div id="emailSection">

    <div class="mb-3">

        <label class="form-label">Email Address</label>

        <div class="input-group">

            <span class="input-group-text">
                <i class="bi bi-envelope"></i>
            </span>

            <input
                type="email"
                id="email"
                class="form-control"
                placeholder="Enter your email">

        </div>

    </div>

</div>

                            <!-- Password -->

                          <div id="otpSection" class="d-none">

    <div class="mb-3">

        <label class="form-label">Enter OTP</label>

        <div class="d-flex justify-content-between gap-2">

            <input type="text" class="form-control text-center otp-input" maxlength="1" id="otp1">
            <input type="text" class="form-control text-center otp-input" maxlength="1" id="otp2">
            <input type="text" class="form-control text-center otp-input" maxlength="1" id="otp3">
            <input type="text" class="form-control text-center otp-input" maxlength="1" id="otp4">
            <input type="text" class="form-control text-center otp-input" maxlength="1" id="otp5">
            <input type="text" class="form-control text-center otp-input" maxlength="1" id="otp6">

        </div>

    </div>

</div>


<div id="passwordSection" class="d-none">

    <div class="mb-3">

        <label class="form-label">New Password</label>

        <input
            type="password"
            id="newPassword"
            class="form-control">

    </div>

    <div class="mb-3">

        <label class="form-label">Confirm Password</label>

        <input
            type="password"
            id="confirmPassword"
            class="form-control">

    </div>

</div>

                            
                            <!-- Login -->

                            <div class="d-grid">

                                <button type="submit" class="btn login-btn" id="loginBtn">

                                    <span id="btnText">

                                        Submit

                                    </span>

                                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none">

                                    </span>

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="../assets/js/forgot_password.js"></script>

</body>

</html>