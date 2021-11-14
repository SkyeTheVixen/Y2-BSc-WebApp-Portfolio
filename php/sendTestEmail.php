<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

    $to = "skylar.beacham@outlook.com";
$subject = "Test Email";
$userName = "Skylar Beacham";
$txt = "Test Email";


    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.vixendev.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'no-reply@vixendev.com';
        $mail->Password   = 'Orange@72';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        //Recipients
        $mail->setFrom('no-reply@vixendev.com', 'Vixendev');
        $mail->addAddress($to, $userName);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $txt;
        $mail->AltBody = $txt;

        $mail->send();
        echo 'Message has been sent';
echo json_encode(array("statuscode" => 200));

    } catch (Exception $e) {
        file_put_contents("errorlog.txt", "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }


?>