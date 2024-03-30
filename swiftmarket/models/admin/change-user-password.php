<?php

require_once "../../config/connection.php";

if(!($user_obj && $user_obj->role_name == "Administrator")){

    header("Location: ../../index.php");
    die();
}

if(!isset($_POST["id"])){
    header("Location: ../../index.php");
    die();
}

$user_id = $_POST["id"];
$pw = md5($_POST["password"]);


try {

    $update= $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $operation_result = $update->execute([$pw, $user_id]);
    
    if($operation_result){
        $message = "You have successfully changed the user's password.";
        header("Location: ../../index.php?page=admin&panel=users&message=$message");
        die();
    }
    
    $error = "Failed to change the user's password.";
    
}
catch(PDOException $ex){
    $error = "Failed to change the user's password, database error.";
    create_log(ERROR_LOG_FILE, $ex->getMessage());
}




header("Location: ../../index.php?page=admin&panel=users&error=$error");
