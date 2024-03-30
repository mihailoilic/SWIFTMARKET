<?php

    if(!isset($_POST["search"])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../../config/connection.php";
    header("Content-Type: application/json");
    
    if(!($user_obj && $user_obj->role_name == "Administrator")){

        echo json_encode([]);
        http_response_code(406);
        die();
    }

    $search = $_POST["search"];

    try {
        
        $select = $conn->prepare("SELECT u.*, b.ban_description FROM users u LEFT JOIN bans b ON u.user_id = b.user_id WHERE u.role_id <> 2 AND (username LIKE ? OR email LIKE ?) ORDER BY u.user_id");
        $select->execute(["%$search%","%$search%"]);
        $users = $select->fetchAll();

        
        if($users){
            $response_code = 200;
        }
        else {
            $users = [];
            $response_code = 204;
        }
        
        
        
    }
    catch(PDOException $ex){
        $users = [];
        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $response_code = 500;
    }

    echo json_encode($users);
    http_response_code($response_code);
