<?php
    session_start();
    if(isset($_POST["txtUser"]) && isset($_POST["txtPassword"])){
        include_once("_connect.php");
        $email = mysqli_real_escape_string($connect, $_POST["txtUser"]);
        $password = mysqli_real_escape_string($connect, $_POST["txtPassword"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo json_encode(array("statusCode" => 201));
        }

        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`Email` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        $stmt -> execute();
        $result = $stmt->get_result();

        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
			if(password_verify($password, $User["Password"], ))
            {
                $_SESSION["userID"] = $User["UserID"];
                echo json_encode(array("statusCode" => 200));
            }
            else{
                echo json_encode(array("statusCode" => 201));
            }
        }
        else{
            echo json_encode(array("statusCode" => 201));
        }
        $stmt -> close();
    }
    else{
        echo json_encode(array("statusCode" => 201));
    }

?>