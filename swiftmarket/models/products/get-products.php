<?php
    header("Content-type: application/json");

    if(!isset($_GET["cat_id"])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../../config/connection.php";
    require_once "../functions.php";

    $status = 1;
    if($user_obj && $user_obj->role_name == "Administrator" && isset($_GET["inactive"]) && $_GET["inactive"]=="true"){
        $status =   0;
    }

    $cat_id = $_GET["cat_id"];
    $subcats = isset($_GET["subcategories"]) ? $_GET["subcategories"] : false;
    $genders = isset($_GET["genders"]) ? $_GET["genders"] : false;
    $conditions = isset($_GET["conditions"]) ? $_GET["conditions"] : false;
    $min_price = isset($_GET["min_price"]) ? trim($_GET["min_price"]) : false;
    $max_price = isset($_GET["max_price"]) ? trim($_GET["max_price"]) : false;
    $user_location = isset($_GET["user_location"]) ? $_GET["user_location"] : false;
    $location = isset($_GET["location"]) ? trim($_GET["location"]) : false;
    $search = isset($_GET["search"]) ? trim($_GET["search"]) : false;
    $sort = isset($_GET["sort"]) ? $_GET["sort"] : "product_views desc";
    $pagination = isset($_GET["pagination"]) ? $_GET["pagination"] : 8;
    $page = isset($_GET["page_no"]) ? $_GET["page_no"] : 1;

    $filter_string = "";
    $params_array = [$cat_id];
    
    prepare_multi_value_filter($subcats, "category_id");
    prepare_multi_value_filter($genders, "gender_id");
    prepare_multi_value_filter($conditions, "condition_id");

    function convert_to_int($el){
        return (int)$el;
    }
    function prepare_multi_value_filter($input, $column){
        global $filter_string, $params_array;
        if($input){
            
            $array = array_map("convert_to_int", explode(",",$input));
            $q_marks = implode(",", array_fill(0, count($array), "?"));
            $filter_string .= " AND $column IN (".$q_marks.")";
            $params_array = array_merge($params_array, $array);
        }
    }

    if($min_price){

        $filter_string .= " AND product_price > ?";
        $params_array []= $min_price;
    }
    if($max_price){

        $filter_string .= " AND product_price < ?";
        $params_array []= $max_price;
    }
    if($user_location == "true" && $user_obj){

        $filter_string .= " AND seller_id IN (SELECT user_id FROM users WHERE ? = LOWER(CONCAT(city, ', ', country)))";
        $params_array []= $user_obj->city.", ".$user_obj->country;
    }
    elseif($location){

        $filter_string .= " AND seller_id IN (SELECT user_id FROM users WHERE  LOWER(CONCAT(city, ', ', country)) LIKE ?)";
        $params_array []= "%$location%";
    }
    if($search){

        $filter_string .= " AND LOWER(product_title) LIKE ?";
        $params_array []= "%$search%";
    }
    if($sort){

        $col = explode(" ", $sort)[0];
        $dir = explode(" ", $sort)[1];

        if(in_array($col, ["product_views", "product_title", "product_price", "product_date_created"]) && in_array($dir, ["asc", "desc"])){

            $filter_string .= " ORDER BY $col $dir";
        }
    }

    if($pagination != 0){
        $limit_start = ((int)$page - 1) * (int)$pagination;
        $filter_string .= " LIMIT $limit_start, $pagination";
    }
    
    $count = 0;

    try {
        $select_query = $conn->prepare("SELECT *, (SELECT image_thumbnail_filename FROM images i WHERE i.product_id = p.product_id LIMIT 1) AS thumbnail
            FROM products p 
            WHERE p.category_id IN 
                    (SELECT category_id FROM categories WHERE parent_category_id = ?)
            AND p.active = $status $filter_string");
        $select_query->execute($params_array);
        $products = $select_query->fetchAll();

        if(isset($_GET["count_products"])){
            $count_query = $conn->prepare("SELECT COUNT(*) AS p_count
            FROM products p 
            WHERE p.category_id IN 
                    (SELECT category_id FROM categories WHERE parent_category_id = ?)
            AND p.active = $status $filter_string");
            $count_query->execute($params_array);
            $result = $count_query->fetch();

            if($result){
                $count = $result->p_count;
            }
        }

        if(!$products){
            $products = [];
        }

        $response_code = 200;
    }
    catch(PDOException $ex){
        
        create_log(ERROR_LOG_FILE, $ex->getMessage());
        $products = [];
        $response_code = 500;
    }

    echo json_encode(["product_count"=>$count,"products"=>$products]);
    http_response_code($response_code);