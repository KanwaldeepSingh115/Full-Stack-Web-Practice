<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">

    <div class="container-fluid">

        <span class="navbar-brand">
            User Management System
        </span>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">

                Welcome,

                <strong>

                    <?php echo htmlspecialchars($_SESSION["email"]); ?>

                </strong>

            </span>

            <a href="../includes/logout.php"
                class="btn btn-danger btn-sm">

                Logout

            </a>

        </div>

    </div>

</nav>