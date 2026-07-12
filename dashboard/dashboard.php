<?php

require_once "../includes/auth_check.php";

?>

<?php include "../includes/header.php"; ?>

<?php include "../includes/navbar.php"; ?>

<div class="container-fluid">

    <div class="row">

        <?php include "../includes/sidebar.php"; ?>

        <div class="col-md-10 p-4">

            <h2>

                Dashboard

            </h2>

            <hr>

            <div class="card shadow">

                <div class="card-body">

                    <h4>

                        Welcome,

                        <?php echo htmlspecialchars($_SESSION["email"]); ?>

                    </h4>

                    <p>

                        You have successfully logged in.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>