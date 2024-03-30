<?php
    if(!isset($_POST["btn-send"])){
        header("Location: ../../index.php?page=home");
        die();
    }
    require_once "../../config/connection.php";
    require_once "functions.php";

    require_once "../../PHPMailer/includes/PHPMailer.php";
    require_once "../../PHPMailer/includes/SMTP.php";
    require_once "../../PHPMailer/includes/Exception.php";
    

    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $html = "
        <h1>Message by $name</h1>
        <h2>Email address: $email</h2>
        <br/>
        <p>$message</p>";

    $response = send_mail("swiftmarket.infinityapp@gmail.com", "New message from $name", $html, ["email"=>$email, "name"=>$name]);
    
	if ($response[0]) {
        header("Location: ../../index.php?page=contact&message=Message successfully sent. We will reply to you.");
    }
    else{
        header("Location: ../../index.php?page=contact&error=Error sending message. Try again later.");
		create_log(ERROR_LOG_FILE, "Mailer Error: ".$response[1]->ErrorInfo);
    }
    
