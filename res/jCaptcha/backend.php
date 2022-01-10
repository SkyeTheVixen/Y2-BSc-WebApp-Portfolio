<?php

if (isset($_POST['txtCaptcha']))
{
    session_start();

    //Compares the user's CAPTCHA answer to the one stored in the user's session.
    if ($_SESSION['captchaKey'] == strtoupper($_POST['txtCaptcha']))
    {
        echo "true";
    }
    else
    {
        echo "false";
    }
}
else
    echo "Missing values!";
?>