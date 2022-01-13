<?php

    session_start();
    
    //If the session isnt set, redirect to the login page
    if (!isset($_SESSION['UserID'])){
        if ($currentPage === "account") {
            header("Location: ../login");
        }
        else {
            header("Location: login");
        }
    }
    
?>