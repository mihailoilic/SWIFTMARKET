<?php
    require_once "../../config/connection.php";

    if($user_obj && isset($_POST["btn-change-pw"])){

        $reg_pw = "/^(?=.*\p{Lu})(?=.*\p{Ll})(?=.*\d)(?=.{6,50})/";
        if(!preg_match($reg_pw, $_POST["new-pw"])){
            $error = "Password too weak, or invalid password format.";
            header("Location: ../../index.php?page=profile&error=$error");
            die();
        }
        
        $old_pw = md5(addslashes($_POST["old-pw"]));
        $new_pw = md5(addslashes($_POST["new-pw"]));
        $confirm_pw = md5(addslashes($_POST["confirm-pw"]));
        $id = $user_obj->user_id;

        if($old_pw != $user_obj->password){
            $error = "Incorrect old password.";
            header("Location: ../../index.php?page=profile&error=$error");
            die();
        }

        if($new_pw != $confirm_pw){
            $error = "Passwords do not match.";
            header("Location: ../../index.php?page=profile&error=$error");
            die();
        }

        try {
            
            $update_query = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $rez = $update_query->execute([$new_pw, $id]);
            if($rez){
                $message =  "Password successfully changed.";
                header("Location: ../../index.php?page=profile&message=$message");
            }
            else {
                $error = "Error changing password. Try again later.";
                header("Location: ../../index.php?page=profile&error=$error");
            }

        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            $error = "Error changing password. Try again later.";
            header("Location: ../../index.php?page=profile&error=$error");
        }
    }
    else {
        header("Location: ../../index.php");
    }
?>