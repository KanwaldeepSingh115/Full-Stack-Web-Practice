<?php
require_once "../config/database.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = (int)($_GET['page'] ?? 1);

$limit = 10;
$offset = ($page - 1) * $limit;

if ($search != '') {

   $stmt = $conn->prepare("SELECT COUNT(*) as total FROM users WHERE name LIKE ? OR email LIKE ?");

   $like = "%{$search}%";
   $stmt -> bind_param("ss",$like,$like);
   $stmt->execute();

   $total = $stmt->get_result()->fetch_assoc()['total'];

   $stmt =$conn->prepare("SELECT * FROM users WHERE name LIKE ? OR email LIKE ? ORDER BY id DESC LIMIT ? OFFSET ?");

   $stmt->bind_param("ssii",$like,$like,$limit,$offset);

   $stmt->execute();

   $result = $stmt->get_result();

} else {
    

 $total = $conn->query("SELECT COUNT(*) as total FROM users")
                  ->fetch_assoc()['total'];

    $stmt = $conn->prepare("
        SELECT *
        FROM users
        ORDER BY id DESC
        LIMIT ? OFFSET ?
    ");

    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();

    $result = $stmt->get_result();



}

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
header("Content-Type: application/json");
echo json_encode($users);
?>