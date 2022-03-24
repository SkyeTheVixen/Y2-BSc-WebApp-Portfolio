$(document).ready(function () {
    //Function to add a new user to the database
    $("#addUserForm").submit(function (event) {
        event.preventDefault();
        var email = $("#emailInput").val();
        var password = $("#passwordInput").val();
        var firstName = $("#firstNameInput").val();
        var lastName = $("#lastNameInput").val();
        var jobTitle = $("#jobTitleInput").val();
        var accessLevel = $("#accessLevelSelect").val();

        $.ajax({
            type: "post",
            url: "res/php/adduser.php",
            data: {
                email: email,
                password: password,
                firstname: firstName,
                lastname: lastName,
                jobtitle: jobTitle,
                accesslevel: accessLevel
            },
            cache: false,
            success: function (result) {
                var Data = JSON.parse(result);
                if (Data.statuscode === 200) {
                    $("#addUserModal").modal('toggle');
                    let timerInterval;
                    Swal.fire({
                        title: 'User Added!',
                        html: 'Reloading page for changes to become visible.',
                        timer: 2000,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then(function(){
                        window.location.reload();
                    })
                } else if (Data.statuscode === 201) {
                    let timerInterval;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong. Please try again',
                        timer: 2000,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    });
                }
            }
        })

    });



    //Function to delete a user
    function delUser(uuid) {
        $.ajax({
            type: "post",
            url: "res/php/deluser.php",
            data: {
                uuid: uuid
            },
            cache: false,
            success: function (result) {
                var Data = JSON.parse(result);
                if (Data.statuscode === 200) {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    ).then(function(){
                        window.location.reload();
                    })
                } else if (Data.statuscode === 201) {
                    let timerInterval;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong. Please try again',
                        timer: 2000,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    });
                }
            }
        });
    };

    $(".delUUID").click(function (event) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action is irreversible",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                delUser($(this).attr('data-id'));
            }
        })
    });



    //Datatables enablement
    $("#userTable").DataTable();



    //Function to enable or disable the password reset functionality. but why... would you?
    $("#userPassReset").change(function (event) {
        if($("#userPassReset").prop('checked')){
            $.ajax({
                type: "post",
                url: "res/php/enableuserpasswordreset.php",
                success: function (result) {
                }
            })
        } else {
            $.ajax({
                type: "post",
                url: "res/php/disableuserpasswordreset.php",
                success: function (result) {
                }
            })
        }
    });
});