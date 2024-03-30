<?php
    require_once "../../config/connection.php";
    require_once "functions.php";

    if(!isset($_POST["btn-add-product"])){
        header("Location: ../../index.php?page=home");
        die();
    }
    
    if(!$user_obj){
        header("Location: ../../index.php?page=login&error=Session%20expired.");
        die();
    }

    $title = $_POST["product-title"];
    $reg_title = "/^.{10,70}$/";
    if(!preg_match($reg_title, $title)){

        header("Location: ../../index.php?page=sell&error=Invalid title.");
        die();
    }

    $desc = $_POST["product-description"];
    $reg_desc = "/^.{20,1000}$/s";
    if(!preg_match($reg_desc, $desc)){
        header("Location: ../../index.php?page=sell&error=Invalid description.");
        die();
    }

    $cat_id = $_POST["product-category"];
    if($cat_id == "0"){
        header("Location: ../../index.php?page=sell&error=Invalid category.");
        die();
    }

    $price = $_POST["product-price"];
    $reg_price = "/^\d+(\.\d+)?$/";
    if(!preg_match($reg_price, $price)){
        header("Location: ../../index.php?page=sell&error=Invalid price.");
        die();
    }

    $condition_id = $_POST["product-condition"];
    if($condition_id == "0"){
        header("Location: ../../index.php?page=sell&error=Invalid condition.");
        die();
    }

    if(isset($_POST["genders-apply"])){
        $gender_id = $_POST["gender"];
        if($gender_id == "0"){
            header("Location: ../../index.php?page=sell&error=Invalid gender.");
            die();
        }
    }
    else {
        $gender_id = null;
    }

    $seller_id = $user_obj->user_id;


    $insert_parameters = [$title, $desc, $price, $condition_id, $gender_id, $seller_id, $cat_id];

    $conn->beginTransaction();

    try{

        $insert_query = $conn->prepare("INSERT INTO products(product_title, product_description, product_price, condition_id, gender_id, seller_id, category_id) VALUES (?,?,?,?,?,?,?)");
        $insert_query->execute($insert_parameters);


        $product_id = $conn->lastInsertId();



        $insert_images_string = "INSERT INTO images(image_filename, image_thumbnail_filename, image_title, product_id) VALUES";
        $insert_images_params = [];

        foreach($_FILES as $photo){

            
            if($photo["name"] == ""){

                $conn->rollBack();
                header("Location: ../../index.php?page=sell&error=You must provide images in all fields");
                die();
            }

            if($photo["size"] > 3 * 1024 * 1024){
                
                $conn->rollBack();
                header("Location: ../../index.php?page=sell&error=Max. filesize for one image is 3MB");
                die();
            }

            $ext = pathinfo($photo["name"], PATHINFO_EXTENSION);
            $allowed_ext = ["jpg", "jpeg", "png", "gif"];
            if(!in_array($ext, $allowed_ext)){
                
                $conn->rollBack();            
                header("Location: ../../index.php?page=sell&error=Allowed extenstions jpg, jpeg, png, gif");
                die();
            }
            
            $image_filename = create_image($photo["tmp_name"], $ext);
            $thumbnail_filename = create_thumbnail($photo["tmp_name"], $ext);

            $insert_images_string .= "(?,?,?,?),";
            array_push($insert_images_params, $image_filename, $thumbnail_filename, $title, $product_id);

        }

        $insert_images_string = substr($insert_images_string, 0, -1);


        $insert_query = $conn->prepare($insert_images_string);
        $insert_query->execute($insert_images_params);

        
        $conn->commit();

    }
    catch(PDOException $ex){

        create_log(ERROR_LOG_FILE, $ex->getMessage());

        $conn->rollBack();            
        header("Location: ../../index.php?page=sell&error=Database error.Try again later.");
        die();
        
    }


    header("Location: ../../index.php?page=product&id=$product_id&message=Product successfully created.");
    