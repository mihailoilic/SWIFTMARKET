<?php
    require_once "../../config/connection.php";

    require_once "../../PHPMailer/includes/PHPMailer.php";
    require_once "../../PHPMailer/includes/SMTP.php";
    require_once "../../PHPMailer/includes/Exception.php";
    

    if(!isset($_POST["btn-login"])){

        header("Location: ../../index.php");
        die();
    }

    $reg_user = "/^\w{3,30}$/";
    if(!preg_match($reg_user, $_POST["username"])){
        header("Location: ../../index.php?page=login&error=Invalid%20username.");
        die();
    }
    $reg_pw = "/^.{3,50}$/";
    if(!preg_match($reg_pw, $_POST["password"])){
        header("Location: ../../index.php?page=login&error=Invalid%20password.");
        die();
    }

    $user = $_POST["username"];
    $pw = md5($_POST["password"]);

    try{
        $login_query = $conn->prepare("SELECT u.*, r.*, b.ban_id, b.ban_description FROM users u JOIN roles r ON u.role_id = r.role_id LEFT JOIN bans b ON b.user_id = u.user_id WHERE username = ?");
        $login_query->execute([$user]);
        $user_obj = $login_query->fetch();
    }
    catch(PDOException $ex){

        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $error = "Database error. Please try again later.";
        header("Location: ../../index.php?page=login&error=".$error);
    }
    
    if($user_obj && $user_obj->password == $pw){
        if($user_obj->ban_id != null){

            $error = "You have been banned. Reason: ".$user_obj->ban_description;
            header("Location: ../../index.php?page=login&error=$error");
            die();
        }
        
        if($user_obj->unlock_code != null){

            $error = "Your account has been locked due to security measures. Please check your inbox for further instructions.";
            header("Location: ../../index.php?page=login&error=$error");
            die();
        }

        $_SESSION["allowed_chats"]=[];
        $_SESSION["user"] = $user_obj;
        unset($_SESSION["failed_attempts"][$user]);
        header("Location: ../../index.php");
    }
    else {
        $error = "Invalid username and/or password.";

        if($user_obj && $user_obj->unlock_code != null){

            $error = "Account $user has been locked due to security measures. Please check your e-mail.";
        }
        elseif($user_obj){
            require_once "functions.php";

            $is_locked = failed_attempt($user_obj);

            if($is_locked){
                $error = "Account $user has been locked due to security measures. Please check your e-mail.";
            }
        }
        header("Location: ../../index.php?page=login&error=$error");
    }
        
    
?>