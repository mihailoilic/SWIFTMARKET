<?php

require_once "../../config/connection.php";

if(!($user_obj && $user_obj->role_name == "Administrator")){

    header("Location: ../../index.php");
    die();
}

if(!isset($_POST["btn-add"])){
    header("Location: ../../index.php");
    die();
}

$params = [];

$main_cat = "";
$q_mark = "";
$image_id = 0;

$is_main = isset($_POST["is-main"]);
if(!$is_main){
    $main_cat = "parent_category_id, ";
    $q_mark = "?,";
    $image_id = "NULL";
    $params []= $_POST["main"];
}

$params []= $_POST["name"];
$params []= isset($_POST["gender-applies"]) ? "1" : "0";



try {

    $insert= $conn->prepare("INSERT INTO categories($main_cat category_name, category_image_id, genders_apply) VALUES($q_mark?,$image_id,?)");
    $operation_result = $insert->execute($params);
    
    if($operation_result){
        $message = "You have successfully added the category. Change the cover image by visiting Cover images in Admin panel.";
        header("Location: ../../index.php?page=admin&panel=products&message=$message");
        die();
    }
    
    $error = "Failed to add the category.";
    
}
catch(PDOException $ex){
    $error = "Failed to add the category, database error.";
    create_log(ERROR_LOG_FILE, $ex->getMessage());
}


header("Location: ../../index.php?page=admin&panel=products&error=$error");
