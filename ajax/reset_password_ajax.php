<?php

header("Content-Type: application/json");

require_once("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {

    echo json_encode([
        "status" => false,
        "message" => "Invalid Request"
    ]);

    exit;
}

$email = trim($_POST["email"] ?? "");
$newPassword = trim($_POST["newPassword"] ?? "");
$confirmPassword = trim($_POST["confirmPassword"] ?? "");

if (empty($email) || empty($newPassword) || empty($confirmPassword)) {

    echo json_encode([
        "status" => false,
        "message" => "All fields are required."
    ]);

    exit;
}

if ($newPassword != $confirmPassword) {

    echo json_encode([
        "status" => false,
        "message" => "Passwords do not match."
    ]);

    exit;
}

$query = "UPDATE login
SET password = ?
WHERE email = ?";

$stmt = $conn->prepare($query);

$stmt->bind_param("ss", $newPassword, $email);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "Password Updated Successfully."
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Something went wrong."
    ]);

}