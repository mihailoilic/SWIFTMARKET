<?php
    header("Content-type: application/json");

    if(!isset($_GET["ajax"])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../../config/connection.php";
    require_once "../functions.php";

    try {
        $select_query = $conn->query("SELECT * FROM categories c JOIN images i ON i.image_id = c.category_image_id");
        $categories = $select_query->fetchAll();

        if(!$categories){
            $categories = [];
        }

        $response_code = 200;
    }
    catch(PDOException $ex){
        
        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $categories = [];
        $response_code = 500;
    }

    echo json_encode($categories);
    http_response_code($response_code);