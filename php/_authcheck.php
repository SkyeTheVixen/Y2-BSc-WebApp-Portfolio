<?php
    session_start();
	include("php\_authcheck.php");
    if (!isset($_SESSION['userID'])){
        header("Location: ./login");
    }
?>