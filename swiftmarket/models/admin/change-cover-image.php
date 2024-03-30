<?php

require_once "../../config/connection.php";

if(!($user_obj && $user_obj->role_name == "Administrator")){

    header("Location: ../../index.php");
    die();
}

if(!isset($_POST["btn-change"])){
    header("Location: ../../index.php");
    die();
}

$tmp_name = $_FILES["cover-image"]["tmp_name"];
$filename = $_FILES["cover-image"]["name"];
$size = $_FILES["cover-image"]["size"];

if($filename == ""){
    header("Location: ../../index.php?page=admin&panel=covers&error=No file provided.");
    die();
}
if($size > 3 * 1024 * 1024){
    header("Location: ../../index.php?page=admin&panel=covers&error=Max. size is 3MB");
    die();
}

$ext = pathinfo($filename, PATHINFO_EXTENSION);

$allowed_ext = ["jpg", "jpeg", "png", "gif"];
if(!in_array($ext, $allowed_ext)){
    header("Location: ../../index.php?page=admin&panel=covers&error=Allowed extenstions jpg, jpeg, png, gif");
    die();
}

$new_filename = create_image($tmp_name, $ext);
$new_thumbnail_filename = create_thumbnail($tmp_name, $ext);

if($new_filename && $new_thumbnail_filename){

    try {
        $insert = $conn->prepare("INSERT INTO images(image_filename, image_thumbnail_filename, image_title) VALUES(?,?,?)");
        $result = $insert->execute([$new_filename, $new_thumbnail_filename, "Cover image"]);

        if($_POST["type"]=="category"){
            $query_string = "UPDATE categories SET category_image_id = ? WHERE category_id = ?";
            $query_params = [$conn->lastInsertId(), $_POST["category-id"]];
        }
        elseif($_POST["type"]=="page") {
            $query_string = "UPDATE page_info SET page_image_id = ? WHERE page_id = ?";
            $query_params = [$conn->lastInsertId(), $_POST["page-id"]];
        }

        $update= $conn->prepare($query_string);
        $operation_result = $update->execute($query_params);
        
        if($operation_result){
            $message = "You have successfully changed the cover image.";
            header("Location: ../../index.php?page=admin&panel=covers&message=$message");
            die();
        }
        
        $error = "Failed to change the cover.";
        
    }
    catch(PDOException $ex){
        $error = "Failed to change the cover.";
        create_log(ERROR_LOG_FILE, $ex->getMessage());
    }
}
else {
    $error = "fail";
}







header("Location: ../../index.php?page=admin&panel=covers&error=$error");
