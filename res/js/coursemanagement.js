$(document).ready(function () {

    //Delegate Function to unenrol users
    $(document).on("click", ".unenrolBtn", async function (e) {
        e.preventDefault();
        await Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, unenrol!'
        }).then((result) => {
            if (result.isConfirmed) {
                var userID = $(this).attr('data-user-id');
                $.ajax({
                    type: "post",
                    url: "res/php/adminunenrolcourse.php",
                    data: {
                        CUID: $(".unenrolBtn").attr('data-course-id'),
                        UUID: userID
                    },
                    cache: false,
                    success: function (result) {
                        var Data = JSON.parse(result);
                        if (Data.statusCode === 200) {
                            $.ajax({
                                type: "post",
                                url: "res/php/getEnrolledMembers.php",
                                data: {
                                    CUID: $(".unenrolBtn").attr('data-course-id')
                                },
                                cache: false,
                                success: function (result) {
                                    var data = JSON.parse(result);
                                    $("#viewCourseEnrolledMembers").empty();
                                    for (var i = 0; i < data.length; i++) {
                                        $("#viewCourseEnrolledMembers").append("<a class=\"unenrolBtn link-dark " + data[i] + "\" data-course-id=" + CUID + " data-user-id='" + data[i] + "'>" + data[i + 1] + "</a><br>");
                                        i++; //Fix for the weird array i passed back
                                    }
                                }
                            });
                            swal.fire({
                                icon: 'success',
                                title: 'Unenrolled!',
                                text: 'You have successfully unenrolled ' + Data.name + ' from this course.',
                            });
                        }
                    }
                });
            }
        })
    });
    
    

    //Add a new course
    $("#addCourseForm").submit(function (event) {
        var data = $(this).serialize();
        event.preventDefault();
        $.ajax({
            type: "post",
            url: "res/php/addcourse.php",
            data: data + "&courseSelfEnrol=" + $("#courseSelfEnrol").prop("checked"),
            cache: false,
            success: function (result) {
                console.log(result);
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
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Course has been deleted.',
                        icon: 'success',
                        heightAuto: false
                    }).then(function () {
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



    //Enable Data table
    $("#pastCourseTable").DataTable({
        columnDefs: [{
            targets: [1, 4, 5, 6, 7, 8, 9],
            orderable: false
        }]
    });



    //Enable Data Table
    $("#futureCourseTable").DataTable({
        columnDefs: [{
            targets: [1, 4, 5, 6, 7, 8, 9],
            orderable: false
        }]
    });


    //Load the view modal content
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
                            $("#viewCourseEnrolledMembers").append("<a class=\"unenrolBtn link-dark " + data[i] + "\" data-course-id=" + CUID + " data-user-id='" + data[i] + "'>" + data[i + 1] + "</a><br>");
                            i++; //Fix for the weird array i passed back
                        }
                    }
                });
            }
        });
    });



    //Empty the view modal
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



    //Generate the attendance register
    $("#generateAttendanceBtn").click(function (event) {
        event.preventDefault();
        var names = [];
        $.ajax({
            type: "post",
            url: "res/php/getEnrolledMembers.php",
            data: {
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



    //Allow admins to enrol members
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
                    names[data[i]] = data[i + 1];
                    i++; //Fix for the weird array i passed back
                }
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
                                var Data = JSON.parse(result);
                                if (Data.statuscode === 200) {
                                    swal.fire({
                                        icon: 'success',
                                        title: 'Enrolled!',
                                        text: 'You have successfully enrolled ' + Data.name + ' in this course.',
                                    });
                                    $("#viewCourseEnrolledMembers").append("<a class=\"unenrolBtn link-dark " + data[i] + "\" data-course-id=" + $("#enrollMemberBtn").attr('data-id') + " data-user-id='" + member + "'>" + Data.name + "</a><br>");
                                }
                            }

                        });
                    }
                }
                getNames();
            }
        });

    });



    //Load the edit form data
    $(".editCourse").click(function (event) {
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
                $("#editCourseName").text(data.CourseTitle);
                $("#editCourseDescription").text(data.CourseDescription);
                $("#editCourseStartDate").text(data.StartDate);
                $("#editCourseEndDate").text(data.EndDate);
                $("#editCourseDeliveryMethod").text(data.DeliveryMethod);
                $("#editCourseCurrentParticipants").text(data.CurrentParticipants);
                $("#editCourseMaxParticipants").text(data.MaxParticipants);
                if (data.SelfEnrol == 1) {
                    $("#editCourseSelfEnrol").prop('checked', true);
                }
                $("#editCourseId").val(CUID);

            }
        });
    });



    //Empty the Edit Modal
    $("#editCourseModal").on("hidden.bs.modal", function (event) {
        event.preventDefault();
        $("#editCourseEnrolledMembers").empty();
        $("#editCourseName").text("");
        $("#editCourseDescription").text("");
        $("#editCourseStartDate").text("");
        $("#editCourseEndDate").text("");
        $("#editCourseDeliveryMethod").text("");
        $("#editCourseCurrentParticipants").text("");
        $("#editCourseMaxParticipants").text("");
        $("#editCourseId").val("");
    });



    //Edit the course
    $("#editCourseForm").submit(function (event) {
        event.preventDefault();
        var CUID = $("#editCourseId").val();
        var name = $("#editCourseName").val();
        var description = $("#editCourseDescription").val();
        var startDate = $("#editCourseStartDate").val();
        var endDate = $("#editCourseEndDate").val();
        var deliveryMethod = $("#editCourseDeliveryMethod").val();
        var maxParticipants = $("#editCourseMaxParticipants").val();
        var selfEnrol = $("#editCourseSelfEnrol").prop("checked");
        $.ajax({
            type: "post",
            url: "res/php/editCourse.php",
            data: {
                CUID: CUID,
                name: name,
                description: description,
                startDate: startDate,
                endDate: endDate,
                deliveryMethod: deliveryMethod,
                maxParticipants: maxParticipants,
                selfEnrol: selfEnrol
            },
            cache: false,
            success: function (result) {
                var data = JSON.parse(result);
                if (data.statuscode === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'You have successfully updated ' + data.name + '.',
                    }).then( function() {
                        $("#editCourseModal").modal("hide");
                    })
                }
            }
        });
    });
})