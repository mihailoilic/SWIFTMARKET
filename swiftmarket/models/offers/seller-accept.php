<?php
    require_once "../../config/connection.php";

    if(!isset($_GET["id"])){
        header("Location: ../../index.php");
        die();
    }
    
    if(!$user_obj){
        header("Location: ../../index.php?page=login&messsage=You must log in first.");
        die();
    }

    $offer_id = $_GET["id"];
    $user_id = $user_obj->user_id;

    try {
        
        $update = $conn->prepare("UPDATE offers o JOIN products p ON p.product_id = o.product_id 
            SET o.offer_status = 2 
            WHERE o.product_id = (SELECT product_id FROM offers WHERE offer_id = ?) 
                AND p.seller_id = ?;
            
            UPDATE offers o JOIN products p ON p.product_id = o.product_id 
                SET o.offer_status = 1
                WHERE o.offer_id = ? AND p.seller_id = ?;

            UPDATE products 
                SET active = 0
                WHERE product_id = (SELECT product_id FROM offers WHERE offer_id = ?);
        
        ");
        $operation_result = $update->execute([$offer_id, $user_id, $offer_id, $user_id, $offer_id]);
        
        if($operation_result){
            
            $message = "You have successfully accepted the offer.";
            header("Location: ../../index.php?page=user-products&message=$message");
            die();
        }
        
        $error = "Failed to accept the offer, try again later.";
        
    }
    catch(PDOException $ex){
        $error = "Failed to accept the offer, database error.";
        create_log(ERROR_LOG_FILE, $ex->getMessage());
    }

    
    header("Location: ../../index.php?page=user-products&error=$error");
