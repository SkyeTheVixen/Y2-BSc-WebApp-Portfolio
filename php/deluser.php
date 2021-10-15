<?php
include_once("_connect.php");
    $sql = "DELETE FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_POST["uuid"]);
    if($stmt -> execute()){
        echo json_encode(array("statuscode" => 200));
    }
    else{
        echo json_encode(array("statuscode" => 201));

    }
    
?>