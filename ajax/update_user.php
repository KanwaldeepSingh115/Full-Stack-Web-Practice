<?php

header("Content-Type: application/json");

require_once "../config/database.php";

$id = $_POST["id"] ?? "";

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$role = trim($_POST["role"] ?? "");
$status = trim($_POST["status"] ?? "");

if (empty($id) || !is_numeric($id)) {

    echo json_encode([
        "status" => false,
        "message" => "Invalid user ID."
    ]);

    exit;
}

if ($name == "") {

    echo json_encode([
        "status" => false,
        "message" => "Name is required."
    ]);

    exit;
}

if ($email == "") {

    echo json_encode([
        "status" => false,
        "message" => "Email is required."
    ]);

    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        "status" => false,
        "message" => "Invalid email format."
    ]);

    exit;
}



$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");

$stmt->bind_param("si", $email, $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo json_encode([
        "status" => false,
        "message" => "Email already exists."
    ]);

    exit;
}


$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");

$stmt->bind_param("i", $id);

$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

$profileImage = $user["profile_image"];

if (
    isset($_FILES["profile_image"]) &&
    $_FILES["profile_image"]["error"] === UPLOAD_ERR_OK
) {

    $file = $_FILES["profile_image"];

    $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    $allowed = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($extension, $allowed)) {

        echo json_encode([
            "status" => false,
            "message" => "Only JPG, JPEG, PNG and WEBP images are allowed."
        ]);

        exit;
    }

    $newFileName = uniqid("user_") . "." . $extension;

    $destination = "../uploads/profiles/" . $newFileName;

    if (!move_uploaded_file($file["tmp_name"], $destination)) {

        echo json_encode([
            "status" => false,
            "message" => "Failed to upload image."
        ]);

        exit;
    }

    if (
        !empty($profileImage) &&
        strpos($profileImage, "uploads/profiles/") === 0 &&
        file_exists("../" . $profileImage)
    ) {
        unlink("../" . $profileImage);
    }

    $profileImage = "uploads/profiles/" . $newFileName;
}



if (!empty($password)) {

    $stmt = $conn->prepare("
        UPDATE users
        SET
            name = ?,
            email = ?,
            password = ?,
             profile_image=?,
            role = ?,
            status = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssssssi",
        $name,
        $email,
        $password,
         $profileImage,
        $role,
        $status,
        $id
    );

} else {

    $stmt = $conn->prepare("
        UPDATE users
        SET
            name = ?,
            email = ?,
            profile_image=?,
            role = ?,
            status = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssssi",
        $name,
        $email,
        $profileImage,
        $role,
        $status,
        $id
    );

}

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "User updated successfully."
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Something went wrong."
    ]);

}