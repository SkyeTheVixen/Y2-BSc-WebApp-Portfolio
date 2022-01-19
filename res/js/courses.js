$(document).ready(function () {
    $(".enrol-btn").click(function (event) {
        var courseID = $(this).attr("data-courseid");
        $.ajax({
            type: "post",
            url: "res/php/enrolcourse.php",
            data: {
                courseID: courseID
            },
            cache: false,
            success: function (result) {
                var Data = JSON.parse(result);
                if (Data.statuscode === 200) {
                    swal.fire({
                        icon: 'success',
                        title: 'Enrolled!',
                        text: 'You have successfully enrolled in this course.',
                        timer: 2000,
                        willClose: () => {
                            $(this).removeClass("btn-primary").addClass("btn-success").text("Enrolled");
                            $(this).removeAttr("data-courseid");
                        }
                    });
                }
            }

        });
    });
});