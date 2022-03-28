<?php
    //Check the session is active
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
    
    //Simple logic to toggle password reset
    if(file_get_contents("data.txt") == "true"){
        file_put_contents("data.txt", "false");
    } else {
        file_put_contents("data.txt", "true");
    }
?>