$(document).ready(function () {
    $("#addCourseForm").submit(function (event) {
        var data = $(this).serialize();
        event.preventDefault();
        $.ajax({
            type: "post",
            url: "res/php/addcourse.php",
            data: data,
            cache: false,
            success: function (result) {
                var Data = JSON.parse(result);
                if (Data.statuscode === 200) {
                    $("#addCourseModal").modal('toggle');
                    let timerInterval
                    Swal.fire({
                        title: 'Course Added!',
                        html: 'Reloading page for changes to become visible.',
                        timer: 2000,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then(function () {
                        window.location.reload();
                    });
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
            url: "res/php/delcourse.php",
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
                    ).then(function () {
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

    $(".viewCourse").click(function (event) {
        var CUID = $(this).attr('data-id');
        event.preventDefault();
        $.ajax({
            type: "post",
            url: "res/php/getcourse.php",
            data: {
                CUID: CUID
            },
            cache: false,
            success: function (result) {
                var data = JSON.parse(result);
                $("#viewCourseName").text(data.CourseTitle);
                $("#viewCourseDescription").text(data.CourseDescription);
                $("#viewCourseStartDate").text(data.StartDate);
                $("#viewCourseEndDate").text(data.EndDate);
                $("#viewCourseDeliveryMethod").text(data.DeliveryMethod);
                $("#viewCourseCurrentParticipants").text(data.CurrentParticipants);
                $("#viewCourseMaxParticipants").text(data.MaxParticipants);
                if (data.SelfEnrol == 1) {
                    $("#viewCourseSelfEnrol").prop('checked', true);
                }
                $.ajax({
                    type: "post",
                    url: "res/php/getenrolled.php",
                    data: {
                        CUID: CUID
                    },
                    cache: false,
                    success: function (result) {
                        var data = JSON.parse(result);
                        for (var i = 0; i < data.length; i++) {
                            $("#viewCourseEnrolledMembers").append("<a class='unenrol-btn' data-unenrol-uuid='" + data[i] + "'>" + data[i+1] + "</a><br>");
                            i++; //Fix for the weird array i passed back
                        }
                    }
                });
            }
        });
    });

    $("#viewCourseModal").on("hidden.bs.modal", function (event) {
        event.preventDefault();
        $("#viewCourseEnrolledMembers").empty();
        $("#viewCourseName").text("");
        $("#viewCourseDescription").text("");
        $("#viewCourseStartDate").text("");
        $("#viewCourseEndDate").text("");
        $("#viewCourseDeliveryMethod").text("");
        $("#viewCourseCurrentParticipants").text("");
        $("#viewCourseMaxParticipants").text("");
    });
})