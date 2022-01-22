$(document).ready(function () {
    $(".enrol-btn").click(function (event) {
        event.preventDefault();
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
                    }).then(function () {
                        $("a[data-courseid='"+courseID+"']").removeClass("btn-primary").removeClass("enrol-btn").addClass("btn-success").text("\u2705 Enrolled!");
                        $("a[data-courseid='"+courseID+"']").removeAttr("data-courseid");
                        $("#progress-"+courseID).attr("Value", ($("#progress-"+courseID).attr("Value")+1));
                        var CurrentValue = $("#participantCount-" + courseID).text().split(" ").split("/").slice(1);
                        console.log(CurrentValue);
                    });
                }
            }

        });
    });
});