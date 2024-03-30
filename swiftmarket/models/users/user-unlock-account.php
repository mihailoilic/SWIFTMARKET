<?php
    if(!isset($_GET["user_id"])){
        header("Location: ../../index.php?page=home");
        die();
    }
    
    require_once "../../config/connection.php";

    $id = $_GET["user_id"];
    $code = $_GET["unlock_code"];

    try {
        $update = $conn->prepare("UPDATE users SET unlock_code = NULL WHERE unlock_code = ? AND user_id = ? ");
        $result = $update->execute([$code, $id]);

        if($result){
            header("Location: ../../index.php?page=login&message=Unlock attempt successful, please log in now.");
            die();
        }
    }
    catch(PDOException $ex){
        
        create_log(ERROR_LOG_FILE, $ex->getMessage());
    }

    
    header("Location: ../../index.php?page=login&error=Error unlocking your account. Contact the administrators for help.");