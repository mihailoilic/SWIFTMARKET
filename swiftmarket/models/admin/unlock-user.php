<?php

require_once "../../config/connection.php";

if(!($user_obj && $user_obj->role_name == "Administrator")){

    header("Location: ../../index.php");
    die();
}

if(!isset($_GET["id"])){
    header("Location: ../../index.php");
    die();
}

$user_id = $_GET["id"];


try {

    $update= $conn->prepare("UPDATE users SET unlock_code = NULL WHERE user_id = ?");
    $operation_result = $update->execute([$user_id]);
    
    if($operation_result){
        $message = "You have successfully unlocked the user.";
        header("Location: ../../index.php?page=admin&panel=users&message=$message");
        die();
    }
    
    $error = "Failed to unlock the user.";
    
}
catch(PDOException $ex){
    $error = "Failed to unlock the user, database error.";
    create_log(ERROR_LOG_FILE, $ex->getMessage());
}


header("Location: ../../index.php?page=admin&panel=users&error=$error");
