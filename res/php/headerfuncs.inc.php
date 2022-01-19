<?php 
    //Function to get the final character of a string
    function endsWith( $inputstr, $checkstr ) {
        $length = strlen( $checkstr );
        if( !$length ) {
            return true;
        }
        return substr( $inputstr, -$length ) === $checkstr;
    }

    //function to remove the dropdown if the user is not an admin
    function removeDropdown($mysqli, $currentPage){
        if($currentPage != "login"){
            $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt -> bind_param('s', $_SESSION["UserID"]);
            $stmt -> execute();
            $result = $stmt->get_result();
            if($result -> num_rows === 1){
                $User = $result->fetch_array(MYSQLI_ASSOC);
                if($User["AccessLevel"] === "user"){
                    return "<script type='text/javascript'>$(document).ready(function () { $('#mgtDrop').remove(); })</script>";
                }
                else{
                    return "";
                }
            }
        }
    }

?>