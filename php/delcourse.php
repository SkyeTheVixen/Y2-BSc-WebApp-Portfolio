<?php
    session_start();
    if (!isset($_SESSION['userID'])){
        header("Location: ../login");
    }
include_once("_connect.php");
$sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
$stmt -> execute();
$result = $stmt->get_result();
if($result -> num_rows === 1){
    $User = $result->fetch_array(MYSQLI_ASSOC);
    if($User["AccessLevel"] === "user"){
        header("Location: index");
    }
}
    $sql = "DELETE FROM `tblCourses` WHERE `tblCourses`.`CUID` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_POST["cuid"]);
    if($stmt -> execute()){
        echo json_encode(array("statuscode" => 200));
    }
    else{
        echo json_encode(array("statuscode" => 201));

    }
    
?>