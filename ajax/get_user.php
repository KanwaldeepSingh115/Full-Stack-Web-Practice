<?php

header("Content-Type: application/json");

require_once "../config/database.php";

$id = $_GET["id"] ?? "";

if (empty($id) || !is_numeric($id)) {

    echo json_encode([
        "status" => false,
        "message" => "Invalid user ID."
    ]);

    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    echo json_encode([
        "status" => false,
        "message" => "User not found."
    ]);

    exit;
}

$user = $result->fetch_assoc();

echo json_encode([
    "status" => true,
    "data" => $user
]);