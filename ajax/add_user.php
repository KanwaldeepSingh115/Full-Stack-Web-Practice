<?php

header("Content-Type: application/json");

require_once "../config/database.php";

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$role = trim($_POST["role"] ?? "");
$status = trim($_POST["status"] ?? "");

if ($name === "") {

    echo json_encode([
        "status" => false,
        "message" => "Name is required."
    ]);

    exit;
}

if ($email === "") {

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

if ($password === "") {

    echo json_encode([
        "status" => false,
        "message" => "Password is required."
    ]);

    exit;
}




$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo json_encode([
        "status" => false,
        "message" => "Email already exists."
    ]);

    exit;
}


$profileImage = "";

if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] === 0) {

    $file = $_FILES["profile_image"];

    echo "<pre>";
print_r($_FILES);
exit;

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

   if (move_uploaded_file($file["tmp_name"], $destination)) {

    echo json_encode([
        "status" => true,
        "message" => $destination
    ]);
    exit;

} else {

    echo json_encode([
        "status" => false,
        "message" => error_get_last()
    ]);
    exit;
}

    $profileImage = "uploads/profiles/" . $newFileName;
}

$stmt = $conn->prepare("
   INSERT INTO users
(name, email, password, profile_image, role, status)
VALUES (?, ?, ?, ?, ?, ?)
");


$stmt->bind_param(
    "ssssss",
    $name,
    $email,
    $password,
    $profileImage,
    $role,
    $status
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "User added successfully."
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Something went wrong."
    ]);
}


