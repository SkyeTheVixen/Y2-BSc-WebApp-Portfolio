$(document).ready(function () {
    $(".btn-enrol").click(function () {
        var courseID = $(this).attr("data-courseid");
        $.post("res/php/course/enrolCourse.php", { courseID: courseID }, function (result) {
                if (JSON.parse(result).statusCode === 200) {
                    var CurrentValue = String($("#participantCount-" + courseID).text()).split(" ").slice(1).join("").split("/");
                    var NewValue = [parseInt(CurrentValue[0])+1, CurrentValue[1]];
                    $("a[data-courseid='"+courseID+"']").removeClass("btn-primary").addClass("btn-success").addClass("disabled").addClass("me-1").attr("disabled", "disabled").text("\u2705 Enrolled!");
                    $("li#btns"+courseID).append("<a data-courseid=\"" + courseID + "\" class=\"btn btn-unenrol btn-danger\">Unenroll</a>")
                    $("#participantCount-" + courseID).text("Participants: " + NewValue[0] + "/" + NewValue[1]);
                    $("#progress-"+courseID).attr("Value", (parseInt($("#progress-"+courseID).attr("Value"))+1));
                    swal.fire({
                        icon: 'success',
                        title: 'Enrolled!',
                        text: 'You have successfully enrolled in this course.',
                    });
                }
            }
        );
    });

    $(".btn-unenrol").click(function (event) {
        var courseid = $(this).attr("data-courseid");
        $.post("res/php/course/unenrolCourse.php", {courseID: courseid} , function(res) {
            if(JSON.parse(res).statusCode === 200) {
                var CurrentValue = String($("#participantCount-" + courseid).text()).split(" ").slice(1).join("").split("/");
                var NewValue = [parseInt(CurrentValue[0])-1, CurrentValue[1]];
                $("a[data-courseid='"+courseid+"']").addClass("btn-primary").removeClass("btn-success").removeClass("disabled").removeClass("me-1").removeAttr("disabled").text("Register");
                $(".btn-unenrol[data-courseid=" + courseid + "]").remove();
                $("#participantCount-" + courseid).text("Participants: " + NewValue[0] + "/" + NewValue[1]);
                $("#progress-"+courseid).attr("Value", (parseInt($("#progress-"+courseid).attr("Value"))-1));
            }
        })
    });
});