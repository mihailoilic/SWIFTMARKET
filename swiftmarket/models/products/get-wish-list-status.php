<?php
    require_once "../../config/connection.php";

    header("Content-Type: application/json");

    if(!isset($_GET["product_id"]) || !$user_obj){
        echo json_encode(["message"=>"Bad request"]);
        http_response_code(400);
        die();
    }

    $user_id = $user_obj->user_id;
    $product_id = $_GET["product_id"];

    try {
        
        $select = $conn->prepare("SELECT * FROM wish_list WHERE user_id = ? AND product_id = ?");
        $select->execute([$user_id, $product_id]);
        $result = $select->fetch();

        
        $response_code = 200;

        if(!$result){
            $response = "false";
        }
        else {
            $response = "true";
        }
    }
    catch(PDOException $ex){
        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $response = "unknown";
        $response_code = 500;
    }

    echo json_encode($response);
    http_response_code($response_code);
    
    