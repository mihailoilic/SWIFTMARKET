<?php
    require_once "../../config/connection.php";
    require_once "functions.php";

    if(!isset($_GET["product-id"])){
        header("Location: ../../index.php");
        die();
    }
    
    if(!$user_obj){
        header("Location: ../../index.php?page=login&messsage=You must log in first.");
        die();
    }

    $buyer_id = $user_obj->user_id;
    $product_id = $_GET["product-id"];

    try {
        
        $delete = $conn->prepare("DELETE FROM offers WHERE product_id = ? AND buyer_id = ? AND offer_status = 0");
        $operation_result = $delete->execute([$product_id, $buyer_id]);
        
        if($operation_result){

            $return_page = "product&id=$product_id";
            if(isset($_GET["return"])){
                $return_page = $_GET["return"];
            }
            
            $message = "You have successfully removed your offer.";
            header("Location: ../../index.php?page=$return_page&message=$message");
            die();
        }
        
        $error = "Failed to remove your offer, try again later.";
        
    }
    catch(PDOException $ex){
        $error = "Failed to remove your offer, database error.";
        create_log(ERROR_LOG_FILE, $ex->getMessage());
    }

    
    header("Location: ../../index.php?page=product&id=$product_id&error=$error");
