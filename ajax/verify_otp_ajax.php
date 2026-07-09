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
$otp = trim($_POST["otp"] ?? "");

if (empty($email) || empty($otp)) {

    echo json_encode([
        "status" => false,
        "message" => "Email and OTP are required."
    ]);

    exit;
}

$query = "SELECT * FROM login WHERE email = ? AND otp = ?";

$stmt = $conn->prepare($query);

$stmt->bind_param("si", $email, $otp);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo json_encode([
        "status" => true,
        "message" => "OTP Verified"
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Invalid OTP"
    ]);

}