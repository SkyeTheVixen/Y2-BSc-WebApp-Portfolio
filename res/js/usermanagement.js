$(document).ready(function () {

    //Function to add a new user
    $("#addUserForm").submit(function (event) {
        event.preventDefault();
        $.post("res/php/adduser.php", $(this).serialize(),
            function (result) {
                if (JSON.parse(result).statusCode === 200) {
                    $("#addUserModal").modal('toggle');
                    Swal.fire('User Added!', 'Reloading page for changes to become visible.', 'success').then(function(){ window.location.reload(); });
                } else if (JSON.parse(result).statusCode === 201) {
                    Swal.fire('Oops...', 'Something went wrong. Please try again', 'error');
                }
            }
        )
    });

    //Function to delete a user
    $(".delUUID").click(function (event) {
        event.preventDefault();
        Swal.fire('Are you sure?', 'This action is irreversible', 'warning', {
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("res/php/deluser.php", {uuid: $(this).attr('data-id')},
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

    //Function to edit a user
    $("#editUserForm").submit(function (event) {
        event.preventDefault();
        $.post("res/php/edituser.php", $(this).serialize(),
            function (result) {
                if (JSON.parse(result).statusCode === 200) {
                    $("#editUserModal").modal('toggle');
                    Swal.fire('User Added!', 'The page will reload to reflect the changes.', 'success').then(function(){ window.location.reload(); });
                } else if (JSON.parse(result).statusCode === 201) {
                    Swal.fire('Oops...', 'Something went wrong. Please try again', 'error');
                }
            }
        )

    });

    //Datatables enablement
    $("#userTable").DataTable();

    //Function to enable or disable the password reset functionality. but why... would you?
    $("#userPassReset").change(function () {
        $.post("res/php/toggleUserPassReset.php");
    });
});