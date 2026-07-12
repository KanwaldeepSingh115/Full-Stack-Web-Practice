<?php

header("Content-Type: application/json");

require_once "../config/database.php";

$id = $_POST["id"] ?? "";

if (empty($id) || !is_numeric($id)) {

    echo json_encode([
        "status" => false,
        "message" => "Invalid user ID."
    ]);

    exit;
}


$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");

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



if (
    !empty($user["profile_image"]) &&
    strpos($user["profile_image"], "uploads/profiles/") === 0 &&
    file_exists("../" . $user["profile_image"])
) {

    unlink("../" . $user["profile_image"]);
}



$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "User deleted successfully."
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Failed to delete user."
    ]);
}