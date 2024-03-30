<?php
    require_once "../../config/connection.php";
    require_once "functions.php";

    if(!isset($_POST["btn-submit"])){
        header("Location: ../../index.php");
        die();
    }
    
    if(!$user_obj){
        header("Location: ../../index.php?page=login&message=You must log in first.");
        die();
    }

    $buyer_id = $user_obj->user_id;
    $product_id = $_POST["product-id"];
    $amount = $_POST["amount"];

    try {
        $already = get_existing_offer($product_id, $buyer_id);

        if($already){

            $update_query = $conn->prepare("UPDATE offers SET offer_price = ? WHERE product_id = ? AND buyer_id = ?");
            $operation_result = $update_query->execute([$amount, $product_id, $buyer_id]);
        }
        else {
    
            $insert_query = $conn->prepare("INSERT INTO offers(product_id, buyer_id, offer_price) VALUES(?,?,?)");
            $operation_result = $insert_query->execute([$product_id, $buyer_id, $amount]);
        }

        if($operation_result){
            $message = "You have successfully submitted your offer, see more details by visiting My offers page.";
            header("Location: ../../index.php?page=product&id=$product_id&message=$message");
            die();
        }
        
        $error = "Failed to submit your offer, try again later.";
        
    }
    catch(PDOException $ex){
        $error = "Failed to submit your offer, database error.";
        create_log(ERROR_LOG_FILE, $ex->getMessage());
    }

    
    header("Location: ../../index.php?page=product&id=$product_id&error=$error");
