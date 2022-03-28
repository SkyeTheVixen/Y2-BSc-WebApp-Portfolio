<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
include_once("_connect.php");
$sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 's', $_SESSION["UserID"]);
$stmt -> execute();
$result = $stmt->get_result();
if($result -> num_rows === 1){
    $User = $result->fetch_array(MYSQLI_ASSOC);
    if($User["AccessLevel"] === "user"){
        header("Location: index");
    }
}
    $sql = "DELETE FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_POST["uuid"]);
    if($stmt -> execute()){
        echo json_encode(array("statusCode" => 200));
    }
    else{
        echo json_encode(array("statusCode" => 201));

    }
    
?>