<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    } else if(file_get_contents("data.txt") == "true"){
        file_put_contents("data.txt", "false");
    } else {
        file_put_contents("data.txt", "true");
    }

?>