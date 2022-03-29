<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
    
    //This file will delete the register when complete
    unlink('../../'.$_POST['URL']);
    return;

?>