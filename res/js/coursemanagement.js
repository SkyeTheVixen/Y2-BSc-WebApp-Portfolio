$(document).ready(function () {
    $("#addCourseForm").submit(function (event) {
        var data = $(this).serialize();
        event.preventDefault();
        $.ajax({
            type: "post",
            url: "php/addcourse.php",
            data: data,
            cache: false,
            success: function (result) {
                var Data = JSON.parse(result);
                if (Data.statuscode === 200) {
                    $("#addCourseModal").modal('toggle');
                    let timerInterval
                    Swal.fire({
                        title: 'Course Added!',
                        html: 'Please reload to see changes.',
                        timer: 2000,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
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

    function delCourse(cuid) {
        $.ajax({
            type: "post",
            url: "php/delcourse.php",
            data: {
                cuid: cuid
            },
            cache: false,
            success: function (result) {
                var Data = JSON.parse(result);
                if (Data.statuscode === 200) {
                    $("#delUserModal").modal('toggle');
                    Swal.fire(
                        'Deleted!',
                        'Course has been deleted.',
                        'success'
                    )
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

    $(".delCourse").click(function (event) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                delCourse($(this).attr('data-id'));
            }
        })
    });

    $("#courseTable").DataTable();
})