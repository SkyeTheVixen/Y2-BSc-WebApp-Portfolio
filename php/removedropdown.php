<?php
    if($currentPage != "login"){
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            if($User["AccessLevel"] === "user"){
                echo "<script type='text/javascript'>$(document).ready(function () { $('#mgtDrop').remove(); })</script>";
            }
        }
    
    }
?>