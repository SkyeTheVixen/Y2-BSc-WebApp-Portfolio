<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
    file_put_contents("data.txt", "true");

?>