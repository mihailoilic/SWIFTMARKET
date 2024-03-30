<?php

    function get_category_info($id){
        global $conn;
        try {
            $select_query = $conn->prepare("SELECT * FROM categories c JOIN images i ON i.image_id = c.category_image_id WHERE c.category_id = ?");
            $select_query->execute([$id]);
            return $select_query->fetch();
    
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }
    }

    function get_subcategories($id){
        global $conn;
        try {
            $select_query = $conn->prepare("SELECT * FROM categories c WHERE parent_category_id = ?");
            $select_query->execute([$id]);
            $result = $select_query->fetchAll();
    
            if(!$result){
                $result = [];
            }

            return $result;
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return [];
        }
    }

    function get_categories($main = false){
        $where = "";
        if($main){
            $where = " WHERE parent_category_id IS NULL";
        }
        try {
            $result = select_query("categories$where");
            if(!$result){
                $result = [];
            }
            return $result;
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return [];
        }
    }

    function arrange_categories($categories){
        $arranged = [];
        foreach($categories as $cat){
            if($cat->parent_category_id == null){
                $arranged []=  ["id"=>$cat->category_id, "name" => $cat->category_name, "subcategories"=>[]];
            }
        }
        foreach($categories as $cat){
            if($cat->parent_category_id != null){
                $index = array_search($cat->parent_category_id, array_column($arranged, "id"));
                if($index !== false){
                    $arranged[$index]["subcategories"] []= ["id"=>$cat->category_id, "name" => $cat->category_name];
                }
            }
        }

        return $arranged;
    }

    function get_genders(){
        try {
            $result = select_query("genders");
            if(!$result){
                $result = [];
            }
            return $result;
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return [];
        }
    }

    function get_conditions(){
        
        try {
            $result = select_query("conditions");
            if(!$result){
                $result = [];
            }
            return $result;
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return [];
        }
    }


    function get_product_info($id){
        
        global $conn;
        try {
            $select_query = $conn->prepare("SELECT *, (SELECT COUNT(*) FROM offers WHERE product_id = p.product_id) AS product_offers, IFNULL((SELECT AVG(buyer_rating) FROM offers WHERE product_id IN (SELECT product_id FROM products p2 WHERE p2.seller_id = p.seller_id)), 'No ratings yet') AS rating FROM products p JOIN images i ON i.product_id = p.product_id JOIN categories c ON c.category_id = p.category_id JOIN conditions cond ON cond.condition_id = p.condition_id JOIN users u ON u.user_id = p.seller_id WHERE p.product_id = ?");
            $select_query->execute([$id]);
            return $select_query->fetchAll();
    
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }
    }

    function increment_product_views($id){
        
        
        global $conn;
        try {
            $update_query = $conn->prepare("UPDATE products SET product_views = product_views + 1 WHERE product_id = ?");
            return $update_query->execute([$id]);
    
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }
    }

    function get_products_from_wish_list(){
        global $conn, $user_obj;
        try {
            $select_query = $conn->prepare("SELECT *, (SELECT image_thumbnail_filename FROM images WHERE product_id = p.product_id LIMIT 1) AS product_thumbnail FROM wish_list wl JOIN products p ON p.product_id = wl.product_id WHERE wl.user_id = ?");
            $select_query->execute([$user_obj->user_id]);
            return $select_query->fetchAll();
    
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }
    }

    

   

  