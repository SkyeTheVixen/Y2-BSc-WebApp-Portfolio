<?php
    session_start();
    if(isset($_POST["txtEmail"]) && isset($_POST["txtPassword"])){
        include_once("_connect.php");
        $email = mysqli_real_escape_string($connect, $_POST["txtEmail"]);
        $password = mysqli_real_escape_string($connect, $_POST["txtPassword"]);
        $encPass = password_hash($password, 1, array('cost' => 9));

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo json_encode(array("statusCode" => 201));
        }

        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`Email` = ? AND `tblUsers`.`Password` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $email, $encPass);
        $stmt -> execute();
        $result = $stmt->get_result();


        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            $_SESSION["userID"] = $User["UserID"];
            echo json_encode(array("statusCode" => 200));
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