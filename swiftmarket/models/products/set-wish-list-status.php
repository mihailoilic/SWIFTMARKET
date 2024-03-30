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
    $current_status = $_GET["current_status"];



    try {
        
        if($current_status == "true"){
                
            $delete = $conn->prepare("DELETE FROM wish_list WHERE user_id = ? AND product_id = ?");
            $result = $delete->execute([$user_id, $product_id]);
            
        }
        else {

            $insert = $conn->prepare("INSERT INTO wish_list(user_id, product_id) VALUES(?,?)");
            $result = $insert->execute([$user_id, $product_id]);
        }

        
        $response_code = 201;

        if(!$result){
            $response = $current_status;
        }
        else {
            $response = $current_status == "true" ? "false" : "true";
        }
    }
    catch(PDOException $ex){
        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $response = $current_status;
        $response_code = 500;
    }

    echo json_encode($response);
    http_response_code($response_code);
    
    