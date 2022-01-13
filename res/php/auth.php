<?php
    //Set up PHP File
    session_start();
    include_once("_connect.php");
    $mysqli -> autocommit(false);



    //Create ID string based off IP And remote Address
    $id = "{$_SERVER['SERVER_NAME']}~login:{$_SERVER['REMOTE_ADDR']}";



    //SQL Query
    $sql = "SELECT * FROM `tblBFA` WHERE `ID` = ?";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('s', $id);
    $stmt -> execute();
    $result = $stmt->get_result();
    $mysqli -> commit();

    if($result -> num_rows === 1){
        $row = $result -> fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        if($row["Tries"] >= 3){
            $sql = "UPDATE `tblBFA` SET `Tries` = 0, `Blocked` = 1, `BlockedUntil` = (now() + INTERVAL 5 MINUTE) WHERE `ID` = ?";
            $stmt = $mysqli -> prepare($sql);
            $stmt -> bind_param('s', $id);
            $stmt -> execute();
            $mysqli -> commit();
            $stmt -> close();
            $mysqli -> close();
            echo json_encode(array("statusCode" => 205));
            return;
        }
        //If user IP has been blocked but the ban has been lifted
        if ($row["Blocked"] == 1 && $row["BlockedUntil"] < date("Y-m-d H:i:s")){
            $sql = "DELETE FROM `tblBFA` WHERE `tblBFA`.`ID` = ?";
            $stmt = $mysqli -> prepare($sql);
            $stmt -> bind_param('s', $id);
            $stmt -> execute();
            $mysqli -> commit();
            $stmt -> close();
        }
        //If user IP has been blocked
        else if ($row["Blocked"] == 1 && !($row["BlockedUntil"] < date("Y-m-d H:i:s"))) {
            $mysqli -> close();
            echo json_encode(array("statusCode" => 205));
            return;
        }
    }

    //Check the inputs are filled out
    if(isset($_POST["txtUser"]) && isset($_POST["txtPassword"])){
        //Get data POSTED
        $email = $_POST["txtUser"];
        $password = $_POST["txtPassword"];
        
        //Check email matches format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo json_encode(array("statusCode" => 206));
            return;
        }
        
        //SQL Query
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`Email` = ?";
        $stmt = $mysqli ->prepare($sql);
        $stmt -> bind_param('s', $email);
        $stmt -> execute();
        $result = $stmt->get_result();
        $mysqli->commit();
        
        //If the email exists in the db, then proceed as normal
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            $stmt -> close();
            //If password matches
            if(password_verify($password, $User["Password"], ))
            {
                //Check if user account is locked
                if($User["IsLocked"] == 1){
                    //Return locked
                    echo json_encode(array("statusCode" => 204));
                    return;
                }
                else{
                    //Return success
                    $_SESSION["UserID"] = $User["UserID"];
                    $sql = "DELETE FROM `tblBFA` WHERE `tblBFA`.`ID` = ?";
                    $stmt = $mysqli -> prepare($sql);
                    $stmt -> bind_param('s', $id);
                    $stmt -> execute();
                    $mysqli -> commit();
                    $stmt -> close();
                    echo json_encode(array("statusCode" => 200));
                    return;
                }
            }
            else{
                //Return invalid credentials
                $sql = "INSERT INTO `tblBFA` (`ID`, `Tries`) VALUES(?, 1) ON DUPLICATE KEY UPDATE `Tries` = `Tries` + 1";
                $stmt = $mysqli -> prepare($sql);
                $stmt -> bind_param('s', $id);
                $stmt -> execute();
                $mysqli -> commit();
                $stmt -> close();
                echo json_encode(array("statusCode" => 201));
                return;
            }
        }
        else{
            //Return invalid credentials
            echo json_encode(array("statusCode" => 202));
            return;
        }
    }
    else{
        echo json_encode(array("statusCode" => 203));
        return;

    }


    $mysqli -> close();

?>