<?php
    function GenerateID() {
        $IDData = $IDData ?? random_bytes(16);
        assert(strlen($IDData) == 16);
        $IDData[6] = chr(ord($IDData[6]) & 0x0f | 0x40);
        $IDData[8] = chr(ord($IDData[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($IDData), 4));
    }

    function PermCheck() {
        include_once("_connect.php");
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            if($User["AccessLevel"] === "user"){
                header("Location: index.php");
            }
            return "true";
        }
    }
?>