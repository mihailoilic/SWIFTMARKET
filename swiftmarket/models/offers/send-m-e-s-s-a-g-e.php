<?php
    header("Content-type: application/json");

    if(!isset($_POST["offer-id"])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../../config/connection.php";
    require_once "../functions.php";
    require_once "functions.php";

    $offer_id = $_POST["offer-id"];
    $text = $_POST["text"];

    if(!($user_obj && in_array($offer_id, $_SESSION["allowed_chats"]))){
        echo json_encode(["success"=>false]);
        http_response_code(406);
        die();
    }

    $user_id = $user_obj->user_id;

    try {
        $insert = $conn->prepare("INSERT INTO messages(sender_id, message_text, offer_id) VALUES(?,?,?)");
        $success = $insert->execute([$user_id, $text, $offer_id]);

        if($success){
            $response_code = 201;

            
            $isSeller = $_SESSION["chat_role"][$offer_id] == "seller";
            $isBuyer = $_SESSION["chat_role"][$offer_id] == "buyer";
            if($isSeller){
                increment_new_messages($offer_id, "buyer_new_messages");
            }
            elseif($isBuyer) {
                increment_new_messages($offer_id, "seller_new_messages");
            }
        }
        else {
            $response_code = 406;
        }
    }
    catch(PDOException $ex){
        
        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $success = false;
        $response_code = 500;
    }

    echo json_encode(["success"=>$success]);
    http_response_code($response_code);