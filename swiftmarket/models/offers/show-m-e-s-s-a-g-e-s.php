<?php
    header("Content-type: application/json");

    if(!isset($_GET["offer-id"])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../../config/connection.php";
    require_once "../functions.php";
    require_once "functions.php";

    $offer_id = $_GET["offer-id"];

    if(!($user_obj && in_array($offer_id, $_SESSION["allowed_chats"]))){
        echo json_encode(["messages"=>[]]);
        http_response_code(406);
        die();
    }

    $user_id = $user_obj->user_id;

    try {
        $select_query = $conn->prepare("SELECT *, (SELECT username FROM users WHERE user_id = m.sender_id) AS sender_username FROM messages m JOIN offers o ON o.offer_id = m.offer_id JOIN products p ON p.product_id = o.product_id WHERE o.offer_id = ? ORDER BY message_timestamp ASC");
        $select_query->execute([$offer_id]);
        $messages = $select_query->fetchAll();

        if($messages){
            $response_code = 200;

            $isSeller = $messages[0]->seller_id == $user_id;
            $isBuyer = $messages[0]->buyer_id == $user_id;
            if($isSeller && $messages[0]->seller_new_messages != 0){
                reset_new_messages($offer_id, "seller_new_messages");
            }
            elseif ($isBuyer && $messages[0]->buyer_new_messages != 0){
                reset_new_messages($offer_id, "buyer_new_messages");
            }
        }
        else {
            $response_code = 204;
        }
    }
    catch(PDOException $ex){
        
        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $messages = [];
        $response_code = 500;
    }

    echo json_encode(["user_id"=>$user_id, "messages"=>$messages]);
    http_response_code($response_code);