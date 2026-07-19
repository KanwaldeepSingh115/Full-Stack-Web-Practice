$('#menuBtn').on('click', function (e) {
    $('.sidebar').toggleClass('show');
});

$(document).on('click', function (e) {

    if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('#menuBtn').length) {

        $('.sidebar').removeClass('show');

    }
});

// $(".search-box").on("keyup", function () {
//     var value = $(this).val().toLowerCase();
//     $(".table tbody tr").filter(function () {
//         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
//     });

//     if ($(".table tbody tr:visible").length === 0) {
//         $(".no-users-found").show();
//     } else {
//         $(".no-users-found").hide();
//     }
// });

$(document).ready(function (e) {
    loadUsers();
});


let currentPage = 1;
let currentSearch = "";

function loadUsers(page = 1) {
    currentPage = page;
    $.ajax({
        url: "../ajax/new_get_users.php",
        type: "GET",
        dataType: "json",
        success: function (response) {

            let html = "";

            if (response.length > 0) {
                $(".no-users-found").hide();

                $.each(response, function (index, user) {

                    let image = user.profile_pic ? user.profile_pic : "../assets/images/default-user.png";

                    let status = user.status == "Active"
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';

                    html += `
                    <tr>
                    <td><img class = "table-img" src="${image}"></td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${status}</td>
                    </tr>
                    `;
                });
            } else {
                $(".no-users-found").show();
            }

            $("#usersTableBody").html(html);
   buildPagination(response.page,response.pages);
   
        }

    });
}

// function buildPagination(current, total){

//     let html = "";

//     // Previous

//     html += `
//         <li class="page-item ${current==1 ? "disabled" : ""}">
//             <a class="page-link" href="#" data-page="${current-1}">
//                 Previous
//             </a>
//         </li>
//     `;

//     for(let i=1;i<=total;i++){

//         html += `
//             <li class="page-item ${current==i ? "active" : ""}">
//                 <a class="page-link" href="#" data-page="${i}">
//                     ${i}
//                 </a>
//             </li>
//         `;
//     }

//     html += `
//         <li class="page-item ${current==total ? "disabled" : ""}">
//             <a class="page-link" href="#" data-page="${current+1}">
//                 Next
//             </a>
//         </li>
//     `;

//     $("#pagination").html(html);

// }

// $(document).on("click", ".page-link", function(e){

//     e.preventDefault();

//     let page = $(this).data("page");

//     if(page){
//         loadUsers(page);
//     }

// });


// $(".search-box").on("keyup", function(){

//     currentSearch = $(this).val();

//     loadUsers(1);

// });



$(".search-box").on("keyup", function () {
    let keyword = $(this).val();

    $.ajax({
        url: "../ajax/new_get_users.php",
        type: "GET",
        data: {
            search: keyword
        },
        dataType: "json",
        success: function (response) {
            let html = "";

            if (response.length > 0) {
                $(".no-users-found").hide();


                $.each(response, function (index, user) {

                    let image = user.profile_pic ? user.profile_pic : "../assets/images/default-user.png";

                    let status = user.status == "Active"
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';

                    html += `
                        <tr>
                            <td>
                                <img class="table-img" src="${image}">
                            </td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${status}</td>
                        </tr>
                    `;

                });
            } else {

                $(".no-users-found").show();

            }

            $("#usersTableBody").html(html);
        }

    });


});