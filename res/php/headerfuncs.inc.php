<?php 
    //Function to get the final character of a string
    function endsWith( $inputstr, $checkstr ) {
        $length = strlen( $checkstr );
        if( !$length ) {
            return true;
        }
        return substr( $inputstr, -$length ) === $checkstr;
    }
?>