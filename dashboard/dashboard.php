<?php

require_once "../includes/auth_check.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h2>Dashboard</h2>

            <hr>

            <h5>Welcome, <?php echo $_SESSION["email"]; ?></h5>

            <p>You have successfully logged in.</p>

            <a href="../includes/logout.php" class="btn btn-danger">
                Logout
            </a>

        </div>

    </div>

</div>

</body>
</html>