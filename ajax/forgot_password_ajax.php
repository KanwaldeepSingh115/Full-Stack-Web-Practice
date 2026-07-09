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

if (empty($email)) {

    echo json_encode([
        "status" => false,
        "message" => "Email is required."
    ]);

    exit;
}

$query = "SELECT * FROM login WHERE email = ?";

$stmt = $conn->prepare($query);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    echo json_encode([
        "status" => false,
        "message" => "Email not found."
    ]);

    exit;
}

// $otp = rand(100000, 999999);

$otp = 111111;

$query = "UPDATE login SET otp = ?, otp_sent_on = NOW() WHERE email = ?";

$stmt = $conn->prepare($query);

$stmt->bind_param("is", $otp, $email);

$stmt->execute();

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "OTP Generated",
        "otp" => $otp
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Something went wrong."
    ]);
}

