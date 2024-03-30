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
$description =  isset($_GET["description"]) ? $_GET["description"] : false;


if($description){

    try {
    
        $insert_query = $conn->prepare("INSERT INTO bans(user_id, ban_description) VALUES(?,?)");
        $operation_result = $insert_query->execute([$user_id, $description]);
        
        if($operation_result){
            $message = "You have successfully banned the user.";
            header("Location: ../../index.php?page=admin&panel=users&message=$message");
            die();
        }
        
        $error = "Failed to ban the user.";
        
    }
    catch(PDOException $ex){
        $error = "Failed to ban the user, database error.";
        create_log(ERROR_LOG_FILE, $ex->getMessage());
    }
}
else {

    try {
    
        $insert_query = $conn->prepare("DELETE FROM bans WHERE user_id = ?");
        $operation_result = $insert_query->execute([$user_id]);
        
        if($operation_result){
            $message = "You have successfully unbanned the user.";
            header("Location: ../../index.php?page=admin&panel=users&message=$message");
            die();
        }
        
        $error = "Failed to unban the user.";
        
    }
    catch(PDOException $ex){
        $error = "Failed to unban the user, database error.";
        create_log(ERROR_LOG_FILE, $ex->getMessage());
    }
}



header("Location: ../../index.php?page=admin&panel=users&error=$error");
