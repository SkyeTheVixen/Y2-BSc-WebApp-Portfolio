$(document).ready(function () {

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

    //Add a new course
    $("#addCourseForm").submit(function () {
        $.post("res/php/course/addCourse.php", $(this).serialize(),
            function (result) {
                if (JSON.parse(result).statusCode === 200) {
                    $("#addCourseModal").modal('toggle');
                    Swal.fire('Course Added!', 'Reloading page to populate changes', 'success', {
                        heightAuto: false
                    }).then(function () {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Oops...', 'Something went wrong!', 'error');
                }
            }
        );


    });

    //Function to delete course
    $(".delCourse").click(function () {
        Swal.fire('Are you sure?', "You won't be able to revert this!", 'warning', {
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            heightAuto: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("res/php/course/deleteCourse.php", {
                        cuid: $(this).attr('data-id')
                    },
                    function (result) {
                        if (JSON.parse(result).statusCode === 200) {
                            $("#delUserModal").modal('toggle');
                            Swal.fire('Deleted!', 'Course has been deleted.', 'success', {
                                heightAuto: false
                            }).then(function () {
                                window.location.reload();
                            })
                        } else if (Data.statusCode === 201) {
                            Swal.fire('Oops...', 'Something went wrong. Please try again', 'error', {
                                heightAuto: false
                            });
                        }
                    }
                );
            }
        })
    });

    //Load the view modal content
    $(".viewCourse").click(function () {
        var CUID = $(this).attr('data-id');
        $.post("res/php/course/getCourse.php", {
                CUID: CUID
            },
            function (result) {
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
                $.post("res/php/course/getEnrolledMembers.php", {
                        CUID: CUID
                    },
                    function (result) {
                        var data = JSON.parse(result);
                        for (var i = 0; i < data.length; i++) {
                            $("#viewCourseEnrolledMembers").append("<a class=\"unenrolBtn link-dark " + data[i] + "\" data-course-id=" + CUID + " data-user-id='" + data[i] + "'>" + data[i + 1] + "</a><br>");
                            i++; //Fix for the weird array i passed back
                        }
                    }
                );
            }
        );
    });

    //Empty the view modal
    $("#viewCourseModal").on("hidden.bs.modal", function () {
        $(this).find('p').text("");
        $("#viewCourseSelfEnrol").prop('checked', false);
        $("#viewCourseEnrolledMembers").empty();
        $("#enrolMemberBtn").attr('data-id', "");
        $("#generateAttendanceBtn").attr('data-id', "");
    });

    //Generate the attendance register
    $("#generateAttendanceBtn").click(function () {
        var names = [];
        $.post("res/php/course/getEnrolledMembers.php", {
                CUID: $(this).attr('data-id')
            },
            function (result) {
                var data = JSON.parse(result);
                for (var i = 0; i < data.length; i++) {
                    names = names.concat(data[i + 1]);
                    i++; //Fix for the weird array i passed back
                }
                $.post("res/php/course/generateRegister.php", {
                        courseName: $("#viewCourseName").text(),
                        names: names
                    },
                    function (result) {
                        var data = JSON.parse(result);
                        if (data.statusCode === 200) {
                            Swal.fire({
                                title: 'Generated!',
                                icon: 'success',
                                html: 'Register has been generated. <a download="' + data.URL + '" href="registers/' + data.URL + '">Download</a>',
                                heightAuto: false
                            }).then(function () {
                                $.post("res/php/course/deleteRegister.php", {
                                    URL: 'registers/' + data.URL
                                });
                            });
                        }
                    }
                );
            }
        );
    });

    //Allow admins to enrol members
    $("#enrollMemberBtn").click(function () {
        var names = {};
        $.post("res/php/course/getUnenrolledMembers.php", {
                CUID: $(this).attr('data-id')
            },
            function (result) {
                var data = JSON.parse(result);
                for (var i = 0; i < data.length; i++) {
                    names[data[i]] = data[i + 1];
                    i++; //Fix for the weird array i passed back
                }
                if (Object.keys(names).length == 0) return Swal.fire('Oops...', 'No unenrolled members are available for this course', 'error', {
                    heightAuto: false
                });

                //Async function as this needs to be asynchronous
                async function getNames() {
                    const {
                        value: member
                    } = await Swal.fire({
                        title: 'Enroll a staff member',
                        input: 'select',
                        inputOptions: names,
                        inputPlaceholder: 'Select staff to enrol',
                        showCancelButton: true,
                        heightAuto: false,
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
                        $.post("res/php/course/adminEnrolCourse.php", {
                                courseID: $("#enrollMemberBtn").attr('data-id'),
                                member: member
                            },
                            function (result) {
                                if (JSON.parse(result).statusCode === 200) {
                                    Swal.fire('Enrolled!', 'You have successfully enrolled ' + JSON.parse(result).name + ' in this course.', 'success');
                                    $("#viewCourseEnrolledMembers").append("<a class=\"unenrolBtn link-dark " + JSON.parse(result)[i] + "\" data-course-id=" + $("#enrollMemberBtn").attr('data-id') + " data-user-id='" + member + "'>" + Data.name + "</a><br>");
                                }
                            }

                        );
                    }
                }
                getNames();
            }
        );

    });

    //Load the edit form data
    $(".editCourse").click(function () {
        $.post("res/php/course/getCourse.php", {
                CUID: $(this).attr('data-id')
            },
            function (result) {
                var data = JSON.parse(result);
                $("#editCourseName").val(data.CourseTitle);
                $("#editCourseDescription").val(data.CourseDescription);
                $("#editCourseStartDate").val(data.StartDate);
                $("#editCourseEndDate").val(data.EndDate);
                $("#editCourseDeliveryMethod").val(data.DeliveryMethod);
                $("#editCourseCurrentParticipants").val(data.CurrentParticipants);
                $("#editCourseMaxParticipants").val(data.MaxParticipants);
                if (data.SelfEnrol == 1) {
                    $("#editCourseSelfEnrol").prop('checked', true);
                }
                $("#editCourseId").val(data.CUID);

            }
        );
    });

    //Empty the Edit Modal
    $("#editCourseModal").on("hidden.bs.modal", function () {
        $("#editCourseEnrolledMembers").empty();
        $(this).find('input, p, textarea').text("");
        $("#editCourseId").val("");
    });

    //Edit the course
    $("#editCourseForm").submit(function (event) {
        event.preventDefault();
        $.post("res/php/course/editCourse.php", $(this).serialize() + "&editCourseSelfEnrol=" + $("#editCourseSelfEnrol").prop('checked'),
            function (data, statusText, xhr) {
                if (xhr.status == 200) {
                    Swal.fire('Updated!', 'You have successfully updated ' + JSON.parse(data).name + '.', 'success', { heightAuto: false }).then(function () { window.location.reload(); });
                } else {
                    Swal.fire('Oops...', 'Something went wrong. Please try again.', 'error', { heightAuto: false });
                }
            }
        );
    });

    //Delegate Function to unenrol users
    $(document).on("click", ".unenrolBtn", async function () {
        await Swal.fire('Are you sure?', 'You will unenrol this user from the course!', 'warning', {
            heightAuto: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, unenrol!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("res/php/course/adminUnenrolCourse.php", { CUID: $(".unenrolBtn").attr('data-course-id'), UUID: $(".unenrolBtn").attr('data-user-id') },
                    function (result) {
                        if (JSON.parse(result).statusCode === 200) {
                            $.post("res/php/course/getEnrolledMembers.php", {
                                    CUID: $(".unenrolBtn").attr('data-course-id')
                                },
                                function (result) {
                                    var data = JSON.parse(result);
                                    $("#viewCourseEnrolledMembers").empty();
                                    for (var i = 0; i < data.length; i++) {
                                        $("#viewCourseEnrolledMembers").append("<a class=\"unenrolBtn link-dark " + data[i] + "\" data-course-id=" + $(".unenrolBtn").attr('data-course-id') + " data-user-id='" + data[i] + "'>" + data[i + 1] + "</a><br>");
                                        i++; //Fix for the weird array i passed back
                                    }
                                }
                            );
                            Swal.fire('Unenrolled!', 'You have successfully unenrolled the member from this course.', 'success');
                        }
                    }
                );
            }
        })
    });
})