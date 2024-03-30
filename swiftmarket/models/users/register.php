<?php

    if(!isset($_POST["btn-register"])){
        header("Location: ../../index.php");
        die();
    }

    session_start();
    require_once "../../config/connection.php";

    
    $reg_user = "/^\w{3,30}$/";
    if(!preg_match($reg_user, $_POST["username"])){
        header("Location: ../../index.php?page=register&error=Invalid%20username.");
        die();
    }
    $reg_pw = "/^(?=.*\p{Lu})(?=.*\p{Ll})(?=.*\d)(?=.{6,})/u";
    if(!preg_match($reg_pw, $_POST["password"])){
        header("Location: ../../index.php?page=register&error=Invalid%20password.");
        die();
    }
    $reg_email = "/^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i";
    if(!preg_match($reg_email, $_POST["email"])){
        header("Location: ../../index.php?page=register&error=Invalid%20e-mail.");
        die();
    }
    $reg_full_name = "/^\p{Lu}\p{L}{1,14}(\s\p{Lu}\p{L}{1,14}){1,3}$/u";
    if(!preg_match($reg_full_name, $_POST["full-name"])){
        header("Location: ../../index.php?page=register&error=Invalid%20full%20name.");
        die();
    }
    $reg_city = "/^[\p{L}\w\.\-\s]{2,50}$/u";
    if(!preg_match($reg_city, $_POST["city"])){
        header("Location: ../../index.php?page=register&error=Invalid%20city.");
        die();
    }
    $reg_country = "/^[\p{L}\w\.\-\s]{2,50}$/u";
    if(!preg_match($reg_country, $_POST["country"])){
        header("Location: ../../index.php?page=register&error=Invalid%20country.");
        die();
    }

    $user = addslashes($_POST["username"]);
    $pw = md5(addslashes($_POST["password"]));
    $email = addslashes($_POST["email"]);
    $full_name = addslashes($_POST["full-name"]);
    $city = addslashes($_POST["city"]);
    $country = addslashes($_POST["country"]);

    try{

        $user_query = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email= ?");
        $user_query->execute([$user, $email]);
        $user_obj = $user_query->fetch();
    }
    catch(PDOException $ex){

        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $error = "Database error, registration has failed. Please try again later.";
        header("Location: ../../index.php?page=register&error=".$error);
        die();
    }
    
    
    if($user_obj){

        if($user_obj->email == $email){
            $error = "This e-mail address has already been used by another person.";
        }
        else {
            $error = "This username has already been taken.";
        }

        header("Location: ../../index.php?page=register&error=".$error);

    }
    else {

        try {

            $register_query = $conn->prepare("INSERT INTO users(username, password, email, full_name, city, country) VALUES(?,?,?,?,?,?)");
            $rez = $register_query->execute([$user, $pw, $email, $full_name, $city, $country]);
            if($rez){
                $message = "Registration successful. You can login now.";
                header("Location: ../../index.php?page=login&message=".$message);
            }
            else {
                $error = "Database error, registration has failed. Please try again later.";
                header("Location: ../../index.php?page=register&error=".$error);
            }

        }
        catch(PDOException $ex){

            create_log(ERROR_LOG_FILE, $ex->getMessage());
            $error = "Database error, registration has failed. Please try again later.";
            header("Location: ../../index.php?page=register&error=".$error);
        }
    }
        
   
?>