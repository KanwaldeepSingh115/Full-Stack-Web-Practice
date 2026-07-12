<?php

require_once "../config/database.php";

$limit = 5;

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$search = trim($_GET["search"] ?? "");

if ($search != "") {

    $searchValue = "%{$search}%";

    // Total Records
    $countStmt = $conn->prepare("
        SELECT COUNT(*) AS total
        FROM users
        WHERE name LIKE ? OR email LIKE ?
    ");

    $countStmt->bind_param("ss", $searchValue, $searchValue);
    $countStmt->execute();

    $totalRecords = $countStmt
        ->get_result()
        ->fetch_assoc()["total"];

    // Users
    $stmt = $conn->prepare("
        SELECT *
        FROM users
        WHERE name LIKE ? OR email LIKE ?
        ORDER BY id DESC
        LIMIT ? OFFSET ?
    ");

    $stmt->bind_param(
        "ssii",
        $searchValue,
        $searchValue,
        $limit,
        $offset
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $totalResult = $conn->query("SELECT COUNT(*) AS total FROM users");

    $totalRecords = $totalResult
        ->fetch_assoc()["total"];

    $result = $conn->query("
        SELECT *
        FROM users
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset
    ");
}

$totalPages = ceil($totalRecords / $limit);

$table = "";

if ($result->num_rows > 0) {

    while ($user = $result->fetch_assoc()) {

        $badge = "";

        if ($user["status"] == "Active") {
            $badge = '<span class="badge bg-success">Active</span>';
        } elseif ($user["status"] == "Inactive") {
            $badge = '<span class="badge bg-warning text-dark">Inactive</span>';
        } else {
            $badge = '<span class="badge bg-danger">Blocked</span>';
        }

        $table .= '
<tr>

<td>'.$user["id"].'</td>

<td>
<img
src="../'.htmlspecialchars($user["profile_image"]).'"
width="50"
height="50"
class="rounded-circle border"
style="object-fit:cover;">
</td>

<td>'.htmlspecialchars($user["name"]).'</td>

<td>'.htmlspecialchars($user["email"]).'</td>

<td>'.htmlspecialchars($user["role"]).'</td>

<td>'.$badge.'</td>

<td>

<button
class="btn btn-warning btn-sm editBtn"
data-id="'.$user["id"].'">
Edit
</button>

<button
class="btn btn-danger btn-sm deleteBtn"
data-id="'.$user["id"].'">
Delete
</button>

</td>

</tr>';
    }

} else {

    $table = '
<tr>

<td colspan="7" class="text-center">

No users found.

</td>

</tr>';
}

$pagination = '<ul class="pagination">';

for ($i = 1; $i <= $totalPages; $i++) {

    $active = ($page == $i) ? "active" : "";

    $pagination .= '
<li class="page-item '.$active.'">

<a
href="#"
class="page-link"
data-page="'.$i.'">

'.$i.'

</a>

</li>';
}

$pagination .= "</ul>";

echo json_encode([
    "table" => $table,
    "pagination" => $pagination
]);