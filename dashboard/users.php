<?php

require_once "../includes/auth_check.php";
require_once "../config/database.php";


$sql = "SELECT * FROM users ORDER BY id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}

?>

<?php include "../includes/header.php"; ?>

<?php include "../includes/navbar.php"; ?>

<div class="container-fluid">

    <div class="row">

        <?php include "../includes/sidebar.php"; ?>

        <div class="col-md-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>Users Management</h2>
<button
    class="btn btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#addUserModal">

    <i class="bi bi-plus-circle"></i>

    Add User

</button>
            </div>

            <div class="card shadow">

                <div class="card-body">

                <div class="row mb-3">

    <div class="col-md-4">

        <input
            type="text"
            id="search"
            class="form-control"
            placeholder="Search by name or email...">

    </div>

</div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-dark">

                                <tr>

                                    <th>ID</th>

                                    <th>Photo</th>

                                    <th>Name</th>

                                    <th>Email</th>

                                    <th>Role</th>

                                    <th>Status</th>

                                    <th width="180">Action</th>

                                </tr>

                            </thead>

                            <tbody id="usersTable">

    
    
    
                          
</tbody>

                        </table>

                    </div>

                    <div id="pagination" class="mt-3 d-flex justify-content-center"></div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modalTitle">

    Add New User

</h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

         <form id="addUserForm" enctype="multipart/form-data">

         <input type="hidden" id="userId" name="id">

                <div class="modal-body">


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Name

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Role

                            </label>

                            <select
                                class="form-select"
                                id="role"
                                name="role">

                                <option value="Admin">

                                    Admin

                                </option>

                                <option value="Employee">

                                    Employee

                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Status

                            </label>

                            <select
                                class="form-select"
                                id="status"
                                name="status">

                                <option value="Active">

                                    Active

                                </option>

                                <option value="Inactive">

                                    Inactive

                                </option>

                                <option value="Blocked">

                                    Blocked

                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Profile Image

                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="profile_image"
                                name="profile_image"
                                accept="image/*">

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="saveUserBtn">

                        Save User

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<?php include "../includes/footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

$("#addUserForm").submit(function(e){

    e.preventDefault();

    let formData = new FormData(this);

    let url = $("#userId").val()
    ? "../ajax/update_user.php"
    : "../ajax/add_user.php";

    $.ajax({

        url: url,

        type: "POST",

        data: formData,

        processData: false,

        contentType: false,

        dataType: "json",

        success: function(response){

    if(response.status){

    alert(response.message);

    $("#addUserForm")[0].reset();

    bootstrap.Modal.getInstance(
        document.getElementById("addUserModal")
    ).hide();

    loadUsers();

}
else{

    alert(response.message);

}

}

    });

});

let currentPage = 1;

function loadUsers(page = 1) {

    currentPage = page;

    $.ajax({

        url: "../ajax/get_users.php",

        type: "GET",

        data: {

            page: page,
            search: $("#search").val()

        },

        dataType: "json",

        success: function(response){

            $("#usersTable").html(response.table);
            $("#pagination").html(response.pagination);

        }

    });

}

$("#search").on("keyup", function () {

    loadUsers(1);

});


$(document).on("click", ".editBtn", function () {

    let id = $(this).data("id");

    $.ajax({

        url: "../ajax/get_user.php",

        type: "GET",

        data: { id: id },

        dataType: "json",

        success: function (response) {

            if (response.status) {

                let user = response.data;

                $("#userId").val(user.id);
                $("#name").val(user.name);
                $("#email").val(user.email);
                $("#password").val("");
                $("#role").val(user.role);
                $("#status").val(user.status);

                $("#modalTitle").text("Edit User");
                $("#saveUserBtn").text("Update User");

                const modal = new bootstrap.Modal(document.getElementById("addUserModal"));
                modal.show();

            } else {

                alert(response.message);

            }

        }

    });

});


$("#addUserModal").on("show.bs.modal", function () {

    if ($("#userId").val() == "") {

        $("#addUserForm")[0].reset();

        $("#modalTitle").text("Add New User");

        $("#saveUserBtn").text("Save User");

    }

});


$(document).on("click", ".deleteBtn", function () {

    let id = $(this).data("id");

    if (!confirm("Are you sure you want to delete this user?")) {
        return;
    }

    $.ajax({

        url: "../ajax/delete_user.php",

        type: "POST",

        data: { id: id },

        dataType: "json",

        success: function (response) {

            alert(response.message);

            if (response.status) {

                loadUsers();

            }

        }

    });

});

$(document).on("click",".page-link",function(e){

    e.preventDefault();

    let page = $(this).data("page");

    loadUsers(page);

});

$(document).ready(function(){

    loadUsers();

});

</script>


