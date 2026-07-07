<?php

session_start();

header("Content-Type: application/json");

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "status" => false,
        "message" => "Invalid request."
    ]);

    exit;
}

$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$remember = isset($_POST["remember"]);

if (empty($email)) {

    echo json_encode([
        "status" => false,
        "message" => "Email is required."
    ]);

    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        "status" => false,
        "message" => "Invalid email address."
    ]);

    exit;
}

if (empty($password)) {

    echo json_encode([
        "status" => false,
        "message" => "Password is required."
    ]);

    exit;
}


$sql = "SELECT * FROM login WHERE email= ?";

$stmt= $conn->prepare($sql);

$stmt -> bind_param("s",$email);

$stmt -> execute();

$result = $stmt->get_result();


if($result->num_rows == 0){

 echo json_encode([
        "status" => false,
        "message" => "Email not found."
    ]);

    exit;
}


$user = $result->fetch_assoc();

if($password == $user["password"]){

$_SESSION["user_id"] = $user["login_id"];
$_SESSION["email"] = $user["email"];

if($remember){
    setcookie(
        "remember_user",
        $user["login_id"],
        time() + (30 * 24 * 60 * 60),
        "/"
    );
}

echo json_encode([
    "status" => true,
    "message" => "Login Successful!"
]);

}else{

echo json_encode([
    "status" => false,
    "message" => "Incorrect Password!"
]);


}
$stmt->close();
$conn->close();


?>