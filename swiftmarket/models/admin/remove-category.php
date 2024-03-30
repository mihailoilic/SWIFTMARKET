<?php

require_once "../../config/connection.php";

if(!($user_obj && $user_obj->role_name == "Administrator")){

    header("Location: ../../index.php");
    die();
}

if(!isset($_POST["btn-remove"])){
    header("Location: ../../index.php");
    die();
}

$id = $_POST["remove-category-id"];

try {

    $test= $conn->prepare("SELECT * FROM categories c WHERE c.category_id = ? AND (EXISTS(SELECT * FROM products WHERE category_id = c.category_id) OR EXISTS (SELECT * FROM categories WHERE parent_category_id = c.category_id))");
    $test->execute([$id]);
    $exists = $test->fetch();
    
    if(!$exists){   
        $delete= $conn->prepare("DELETE FROM categories WHERE category_id = ?");
        $operation_result = $delete->execute([$id]);

        if($operation_result){
            $message = "You have successfully removed the category.";
            header("Location: ../../index.php?page=admin&panel=products&message=$message");
            die();
        }
        
    }

    
    $error = "Failed to remove the category. Maybe it contains items or subcategories?";
    
}
catch(PDOException $ex){
    $error = "Failed to remove the category, database error.";
    create_log(ERROR_LOG_FILE, $ex->getMessage());
}


header("Location: ../../index.php?page=admin&panel=products&error=$error");
