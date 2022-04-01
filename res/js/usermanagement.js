$(document).ready(function () {

    //Function to add a new user
    $("#addUserForm").submit(function (event) {
        event.preventDefault();
        $.post("res/php/user/addUser.php", $(this).serialize(),
            function (result) {
                console.log(result);
                if (JSON.parse(result).statusCode === 200) {
                    $("#addUserModal").modal('toggle');
                    Swal.fire('User Added!', 'Reloading page for changes to become visible.', 'success', {heightAuto: false}).then(function(){ window.location.reload(); });
                } else if (JSON.parse(result).statusCode === 201) {
                    Swal.fire('Oops...', 'Something went wrong. Please try again', 'error', {heightAuto: false});
                } else if (JSON.parse(result).statusCode === 202) {
                    Swal.fire('Oops...', 'Please ensure you fill out all fields', 'error', {heightAuto: false});
                }
            }
        )
    });

    //Function to delete a user
    $(".delUUID").click(function () {
        Swal.fire('Are you sure?', 'This action is irreversible', 'warning', {
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete',
            heightAuto: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("res/php/user/delUser.php", {uuid: $(this).attr('data-id')},
                    function (result) {
                        if (JSON.parse(result).statusCode === 200) {
                            Swal.fire('Deleted!', 'User has been deleted.', 'success').then(function(){ window.location.reload(); });
                        } else if (JSON.parse(result).statusCode === 201) {
                            Swal.fire('Oops...', 'Something went wrong. Please try again', 'error', {heightAuto: false});
                        }
                    }
                );
            }
        })
    });

    //Datatables enablement
    $("#userTable").DataTable({columnDefs: [{
        targets: [5, 6],
        orderable: false
    }]});

    //Function to enable or disable the password reset functionality. but why... would you?
    $("#userPassReset").change(function () {
        $.post("res/php/user/toggleUserPassReset.php");
    });

    //Function to load in user data to edit form
    $(".editUUID").click(function () {
        $.post("res/php/user/getUser.php", {uuid: $(this).attr('data-id')},
            function (result) {
                var user = JSON.parse(result);
                $("#editFirstName").val(user.FirstName);
                $("#editLastName").val(user.LastName);
                $("#editUUID").val(user.UUID);
                $("#editEmail").val(user.Email);
                $("#editAccessLevel").val(user.AccessLevel);
                $("#editJobTitle").val(user.JobTitle);
                $("#editUserModal").modal('toggle');
            }
        );
    });

    //Function to clear modal data on close
    $("#editUserModal").on('hidden.bs.modal', function () {
        $("#editFirstName").val('');
        $("#editLastName").val('');
        $("#editUUID").val('');
        $("#editEmail").val('');
        $("#editAccessLevel").val('');
        $("#editJobTitle").val('');
    });
    
    //Function to edit a user
    $("#editUserForm").submit(function (event) {
        event.preventDefault();
        $.post("res/php/user/editUser.php", $(this).serialize(),
            function (result) {
                if (JSON.parse(result).statusCode === 200) {
                    $("#editUserModal").modal('toggle');
                    Swal.fire('User updated!', 'The page will reload to reflect the changes.', 'success').then(function(){ window.location.reload(); });
                } else if (JSON.parse(result).statusCode === 201) {
                    Swal.fire('Oops...', 'Something went wrong. Please try again', 'error');
                } else if (JSON.parse(result).statusCode === 202) {
                    Swal.fire('Oops...', 'Please ensure you fill out all fields', 'error', {heightAuto: false});
                }
            }
        )

    });
});