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

$product_id = $_GET["id"];


try {

    $update= $conn->prepare("UPDATE products SET active = 0 WHERE product_id = ?;
        UPDATE offers SET offer_status = 2 WHERE product_id = ?");
    $operation_result = $update->execute([$product_id, $product_id]);
    
    if($operation_result){
        $message = "You have successfully made the product inactive.";
        header("Location: ../../index.php?page=product&id=$product_id&message=$message");
        die();
    }
    
    $error = "Failed to make the product inactive.";
    
}
catch(PDOException $ex){
    $error = "Failed to make the product inactive, database error.";
    create_log(ERROR_LOG_FILE, $ex->getMessage());
}


header("Location: ../../index.php?page=product&id=$product_id&error=$error");
