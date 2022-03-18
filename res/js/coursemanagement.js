$(document).ready(function () {
    //Add a new course
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


    //Functions to delete course
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


    //Data table
    $("#pastCourseTable").DataTable({
        columnDefs: [{
            targets: [1, 4, 5, 6, 7, 8, 9],
            orderable: false
        }]
    });

    //Data Table
    $("#futureCourseTable").DataTable({
        columnDefs: [{
            targets: [1, 4, 5, 6, 7, 8, 9],
            orderable: false
        }]
    });


    //Load the form data when a user clicks the show icon
    $(".viewCourse").click(function (event) {
        var CUID = $(this).attr('data-id');
        event.preventDefault();
        $.ajax({
            type: "post",
            url: "res/php/getCourse.php",
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
                $("#enrollMemberBtn").attr('data-id', CUID);
                $("#generateAttendanceBtn").attr('data-id', CUID);
                if (data.SelfEnrol == 1) {
                    $("#viewCourseSelfEnrol").prop('checked', true);
                }
                $.ajax({
                    type: "post",
                    url: "res/php/getEnrolledMembers.php",
                    data: {
                        CUID: CUID
                    },
                    cache: false,
                    success: function (result) {
                        var data = JSON.parse(result);
                        for (var i = 0; i < data.length; i++) {
                            $("#viewCourseEnrolledMembers").append("<a class='unenrol-btn' data-unenrol-uuid='" + data[i] + "'>" + data[i + 1] + "</a><br>");
                            i++; //Fix for the weird array i passed back
                        }
                    }
                });
            }
        });
    });


    //Do this when modal closes - empty fields
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
        $("#enrolMemberBtn").attr('data-id', "");
        $("#generateAttendanceBtn").attr('data-id', "");
    });


    //Generate the attendance report
    $("#generateAttendanceBtn").click(function (event) {
        event.preventDefault();
        var names = [];
        $.ajax({
            type: "post",
            url: "res/php/functions.inc.php",
            data: {
                function: "getEnrolled",
                CUID: $(this).attr('data-id')
            },
            cache: false,
            success: function (result) {
                var data = JSON.parse(result);
                for (var i = 0; i < data.length; i++) {
                    names = names.concat(data[i + 1]);
                    i++; //Fix for the weird array i passed back
                }
                $.ajax({
                    type: "post",
                    url: "res/php/generateRegister.php",
                    data: {
                        courseName: $("#viewCourseName").text(),
                        names: names
                    },
                    cache: false,
                    success: function (result) {
                        var data = JSON.parse(result);
                        if (data.statusCode === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Generated!',
                                html: 'Register has been generated. <a download="' + data.URL + '" href="registers/' + data.URL + '">Download</a>',
                                heightAuto: false
                            }).then(function () {
                                $.ajax({
                                    type: "post",
                                    url: "res/php/deleteRegister.php",
                                    data: {
                                        URL: 'registers/' + data.URL
                                    },
                                    cache: false,
                                    success: function (result) {}
                                });
                            });
                        }
                    }
                });
            }
        });


    });


    //Admin enrol member
    $("#enrollMemberBtn").click(function (event) {
        event.preventDefault();
        var names = {};
        $.ajax({
            type: "post",
            url: "res/php/getUnenrolledMembers.php",
            data: {
                CUID: $(this).attr('data-id')
            },
            cache: false,
            success: function (result) {
                var data = JSON.parse(result);
                for (var i = 0; i < data.length; i++) {
                    names[data[i]] = data[i+1];
                    i++; //Fix for the weird array i passed back
                }
                console.log(names);
                if (Object.keys(names).length == 0) {
                    return Swal.fire({
                        title: "Oops...",
                        text: "No unenrolled members are available for this course",
                        icon: "error",
                    });
                }
                async function getNames() {
                    const { value: member } = await Swal.fire({
                        title: 'Enroll a staff member',
                        input: 'select',
                        inputOptions: names,
                        inputPlaceholder: 'Select staff to enrol',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            return new Promise((resolve) => {
                                if (value) {
                                    resolve()
                                } else {
                                    resolve('You need to select a staff member')
                                }
                            })
                        }
                    })
                    if (member) {
                        $.ajax({
                            type: "post",
                            url: "res/php/adminenrolcourse.php",
                            data: {
                                courseID: $("#enrollMemberBtn").attr('data-id'),
                                member: member
                            },
                            cache: false,
                            success: function (result) {
                                console.log(result);
                                var Data = JSON.parse(result);
                                if (Data.statuscode === 200) {
                                    swal.fire({
                                        icon: 'success',
                                        title: 'Enrolled!',
                                        text: 'You have successfully enrolled ' + Data.name +  ' in this course.',
                                    });
                                }
                            }
                
                        });
                    }
                }
                getNames();                
            }
        });

    });
})