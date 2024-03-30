<?php


    function check_session(){

        session_start();
        global $user_obj;
        if(isset($_SESSION["user"])){
            $user_obj = $_SESSION["user"];
        }

    }


    function create_log($filename, $message){

        global $user_obj;
        $user = "(guest)";
        if($user_obj){
            $user = $user_obj->username;
        }

        $ip_address = $_SERVER["REMOTE_ADDR"];
        $timestamp = date("Y-m-d H:i:s");
        $url = $_SERVER["PHP_SELF"];
        $target_page = isset($_GET["page"]) ? $_GET["page"] : "(no target page)";

        $new_log_line = "$timestamp\n$user\n$ip_address\n$url\n$target_page\n$message\n-------\n\n";

        file_put_contents($filename, $new_log_line, FILE_APPEND);
    }

    function get_pages(){

        global $conn;

        try {
            return select_query("page_info p LEFT JOIN images i ON p.page_image_id = i.image_id");
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }
        
    }

    function get_page_info($this_page){
        
        global $pages;

        foreach($pages as $page){
            if($page->page_name == $this_page){
                return $page;
            }
        }    
        
        return false;

    }

    function get_image_resource($path, $ext){

        switch($ext){
            case "jpg":
            case "jpeg":
                $image = imagecreatefromjpeg($path);
                break;
            case "png":
                $image = imagecreatefrompng($path);
                break;
            case "gif":
                $image = imagecreatefromgif($path);
                break;
            default:
                $image = false;
        }

        return $image;
    }

    function create_image_from_resource($image, $new_filename, $ext){

        
        $new_path = ABSOLUTE_PATH."/assets/images/$new_filename";
        switch($ext){
            case "jpg":
            case "jpeg":
                return imagejpeg($image, $new_path);
            case "png":
                return imagepng($image, $new_path);
            case "gif":
                return imagegif($image, $new_path);
        }
    }

    function create_image($tmp_filename, $ext){

        $image = get_image_resource($tmp_filename, $ext);

        $width = imagesx($image);
        $height = imagesy($image);

        if($width > 1920){
            $new_height = 1920 * $height / $width;
            $new_image = imagecreatetruecolor(1920, $new_height);
            imagecopyresampled($new_image, $image, 0,0,0,0, 1920, $new_height, $width, $height);
            imagedestroy($image);
            $image = $new_image;
        }
        elseif($height > 1080){
            $new_width = 1080 * $width / $height;
            $new_image = imagecreatetruecolor($new_width, 1080);
            imagecopyresampled($new_image, $image, 0,0,0,0, $new_width, 1080, $width, $height);
            
            imagedestroy($image);
            $image = $new_image;
        }

        $new_filename = str_replace(" ","", microtime()).".$ext";
        create_image_from_resource($image, $new_filename, $ext);
        imagedestroy($image);

        return $new_filename;

    }

    function create_thumbnail($tmp_filename, $ext){

        
        $image = get_image_resource($tmp_filename, $ext);

        
        $width = imagesx($image);
        $height = imagesy($image);

        if($width > 400){
            
            $new_height = 400 * $height / $width;
            $new_image = imagecreatetruecolor(400, $new_height);
            imagecopyresampled($new_image, $image, 0,0,0,0, 400, $new_height, $width, $height);

            imagedestroy($image);
            $image = $new_image;
        }

        $new_filename = str_replace(" ","", microtime())."-thumbnail.$ext";
        create_image_from_resource($image, $new_filename, $ext);
        imagedestroy($image);

        return $new_filename;
    }