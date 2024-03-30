<?php
    require_once "../../config/connection.php";

    if(!isset($_POST["offer-id"])){
        header("Location: ../../index.php");
        die();
    }
    
    if(!$user_obj){
        header("Location: ../../index.php?page=login&messsage=You must log in first.");
        die();
    }

    $offer_id = $_POST["offer-id"];
    $buyer_id = $user_obj->user_id;
    $rating = $_POST["rating"];

    try {
        
        $update = $conn->prepare("UPDATE offers SET buyer_rating = ? WHERE offer_id = ? AND buyer_id = ?");
        $operation_result = $update->execute([$rating, $offer_id, $buyer_id]);
        
        if($operation_result){
            
            $message = "You have successfully rated the seller.";
            header("Location: ../../index.php?page=user-offers&message=$message");
            die();
        }
        
        $error = "Failed to rate the seller, try again later.";
        
    }
    catch(PDOException $ex){
        $error = "Failed to rate the seller, database error.";
        create_log(ERROR_LOG_FILE, $ex->getMessage());
    }

    
    header("Location: ../../index.php?page=user-offers&error=$error");
