<?php

    function send_mail($email, $subject, $html, $reply_info = false){
        
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = env("PHPMAILER_SMTP");
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = env("PHPMAILER_MAIL");
        $mail->Password = env("PHPMAILER_PASSWORD");
        
        $mail->Subject = $subject;
        $mail->setFrom(env("PHPMAILER_MAIL"));
        $mail->isHTML(true);
        $mail->Body = $html;
        $mail->addAddress($email);

        if($reply_info){
            $mail->AddReplyTo($reply_info["email"], "Reply to ".$reply_info["name"]);
        }
        
        $result = $mail->send();
        $mail->smtpClose();

        return [$result, $mail];
    }