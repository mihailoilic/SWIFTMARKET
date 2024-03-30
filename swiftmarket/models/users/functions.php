<?php
    function failed_attempt($user_obj){
        
        $time_now = time();
        $username = $user_obj->username;

        if(isset($_SESSION["failed_attempts"])){

            if(isset($_SESSION["failed_attempts"][$username])){

                $_SESSION["failed_attempts"][$username] []= $time_now;

                $last_3_failed = array_slice($_SESSION["failed_attempts"][$username], -3);

                if(count($last_3_failed) >= 3){
                    
                    $before_5_mins = false;
                    foreach($last_3_failed as $attempt){
                        if($time_now - $attempt > 300){
                            $before_5_mins = true;
                        }
                    }

                    if(!$before_5_mins){
                    
                        return lock_account($user_obj);
                    }
                }
            }
            else {
                $_SESSION["failed_attempts"][$username] = [$time_now];
            }
        }
        else {
            $_SESSION["failed_attempts"] = [$username=>[$time_now]];
        }

        return false;
    }

    function lock_account($user_obj){

        global $conn;
        
        require_once "../mail/functions.php";

        $unlock_code = md5(rand());

        try{
            $update = $conn->prepare("UPDATE users SET unlock_code = ? WHERE user_id = ?");
            $result = $update->execute([$unlock_code, $user_obj->user_id]);

            if($result){

                $email = $user_obj->email;
                $name = $user_obj->full_name;
                $id = $user_obj->user_id;
                $link_href = ABSOLUTE_PATH."/models/users/user-unlock-account.php?user_id=$id&unlock_code=$unlock_code";
                $html = "
                <h2>Dear $name,</h2>
                <h3>Your account has been locked due to security measured, sorry for the inconvenience.</h3>
                <a href=\"$link_href\">Click here</a> to unlock your account.<br/>If the link doesn't work you can copy it here: <br/><small>$link_href</small>";

                $response = send_mail($email, "Your acccount has been locked", $html);

                if (!$response[0]) {

                    create_log(ERROR_LOG_FILE, "Mailer Error: ".$response[1]->ErrorInfo);
                }
                
                return true;
            }
            
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
        }

        return false;
    }