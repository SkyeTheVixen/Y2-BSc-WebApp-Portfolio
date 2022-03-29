$(document).ready(function(){

    $("#resetForm").submit(function(e){
        e.preventDefault();
        $.post("res/php/user/newPass.php", $(this).serialize(),
            function(data, status, xhr){
                if(xhr.status == 200){
                    Swal.fire("Success", "Password changed successfully", "success").then(function(){
                        window.location.href = "login";
                    });
                }
            }
        );
    });

});