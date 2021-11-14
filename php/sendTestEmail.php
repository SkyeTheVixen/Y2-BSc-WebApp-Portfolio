<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require '../vendor/autoload.php';


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
        $mail->addAddress("skylar.beacham@outlook.com", "Skylar");

        //Content
        $mail->isHTML(true);
        $mail->Subject = "Test Email";
        $mail->Body    = "Config correct";
        $mail->AltBody = "Config correct";

        $mail->send();
        echo 'Message has been sent';
        echo json_encode(array("statuscode" => 200));

    } catch (Exception $e) {
        file_put_contents("errorlog.txt", "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }


?>