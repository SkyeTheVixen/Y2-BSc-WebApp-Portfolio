<?php
    //Imports
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $dotenv = require("autoload.php");
    $dotenv->load();


    //Function to generate a UUIDv4
    function GenerateID() {
        $IDData = $IDData ?? random_bytes(16);
        assert(strlen($IDData) == 16);
        $IDData[6] = chr(ord($IDData[6]) & 0x0f | 0x40);
        $IDData[8] = chr(ord($IDData[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($IDData), 4));
    }


    //Function to generate a greeting based on the time of day
    function getGreeting(){
        $hour = date("H");
        if($hour >= 0 && $hour < 12){
            return "Good Morning";
        }else if($hour >= 12 && $hour < 18){
            return "Good Afternoon";
        }else if($hour >= 18 && $hour < 24){
            return "Good Evening";
        }
    }


    //Function to send an email to a user
    function sendMail($email, $userName,  $subject, $message, $altMessage){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV["MAIL_HOST"];
            $mail->SMTPAuth   = $_ENV["MAIL_SMTP_AUTH"];
            $mail->Username   = $_ENV["MAIL_USERNAME"];
            $mail->Password   = $_ENV["MAIL_PASS"];
            $mail->Port       = $_ENV["MAIL_PORT"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            //Recipients
            $mail->setFrom($_ENV["MAIL_USERNAME"], $_ENV["MAIL_FRIENDLY_NAME"]);
            $mail->addAddress($email, $userName);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $altMessage;

            $mail->send();
        } catch (Exception $e) {
            file_put_contents("errorlog.txt", "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
?>