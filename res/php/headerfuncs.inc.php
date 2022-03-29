<?php 
    //Function to get the final character of a string
    function endsWith( $inputstr, $checkstr ) {
        $length = strlen( $checkstr );
        if( !$length ) {
            return true;
        }
        return substr( $inputstr, -$length ) === $checkstr;
    }

    //Function to get the logged in user
    function getLoggedInUser($mysqli){
        $mysqli->autocommit(false);
        $sql="SELECT * FROM `tblUsers` WHERE `UUID`=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $_SESSION["UserID"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows < 0){
            $mysqli->rollback();
            return false;
        }
        $user = $result->fetch_object();
        $mysqli->commit();
        return $user;
    }
?>