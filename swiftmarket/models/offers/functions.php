<?php
    function get_existing_offer($product_id, $buyer_id){
        
        try{
            global $conn;
            $select_query = $conn->prepare("SELECT * FROM offers WHERE product_id = ? AND buyer_id = ?");
            $select_query->execute([$product_id, $buyer_id]);
            return $select_query->fetch();
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }

    }

    function get_all_offers_by_user($id){

        try {
            global $conn;
            $select_query = $conn->prepare("SELECT *, (SELECT image_thumbnail_filename FROM images WHERE product_id = p.product_id LIMIT 1) AS product_thumbnail FROM offers o JOIN products p ON o.product_id = p.product_id  WHERE  buyer_id = ?");
            $select_query->execute([$id]);
            return $select_query->fetchAll();
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }
        
    }

    
    function get_offer_info_for_chat($offer_id){
        global $conn, $user_obj;

        $user_id = $user_obj->user_id;

        try{
            $select_query = $conn->prepare("SELECT * FROM  offers o JOIN products p ON p.product_id = o.product_id WHERE o.offer_id = ? AND (p.seller_id = ? OR o.buyer_id = ?) AND o.offer_status <> 2");
            $select_query->execute([$offer_id, $user_id, $user_id]);
            $result = $select_query->fetch();
            if(!$result){
                return false;
            }

            if($result->seller_id == $user_id){
                $role = "seller";
            }
            elseif($result->buyer_id == $user_id){
                $role = "buyer";
            }
            else {
                return false;
            }

            return [$role, $result];
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }
        

    }

    function get_chat_rules_html(){
        $lines = file(ABSOLUTE_PATH."/data/chat-rules.txt");
        $html = "";
        foreach($lines as $i=>$rule){
            $html .= "<div>".($i+1).". ".trim($rule)."</div>";
        }
        return $html;
    }

    function increment_new_messages($offer_id, $column){

        global $conn;

        try{
            $update = $conn->prepare("UPDATE offers SET `$column` = `$column` + 1 WHERE offer_id = ?");
            $update->execute([$offer_id]);

        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
        }
    }

    function reset_new_messages($offer_id, $column){
        global $conn;

        try{
            $update = $conn->prepare("UPDATE offers SET $column = 0 WHERE offer_id = ?");
            $update->execute([$offer_id]);
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
        }
    }

    function get_all_products_with_offers_by_seller(){
        
        global $conn, $user_obj;
        try {
            
            $select_query = $conn->prepare("SELECT *,(SELECT image_thumbnail_filename FROM images WHERE product_id = p.product_id LIMIT 1) AS product_thumbnail FROM offers o JOIN users u ON u.user_id = o.buyer_id RIGHT JOIN products p ON p.product_id = o.product_id WHERE p.seller_id = ? ORDER BY p.active DESC");
            $select_query->execute([$user_obj->user_id]);
            return $select_query->fetchAll();
        }
        catch(PDOException $ex){
            
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return false;
        }
    }

    function arrange_products_with_offers($array){
        $arranged_products = [];
        $existing_products = [];
        foreach($array as $offer){
            if(in_array($offer->product_id, $existing_products)){
                continue;
            }
            $arranged_products []= [
                "id"=>$offer->product_id,
                "title"=>$offer->product_title,
                "status"=>$offer->active,
                "price"=>$offer->product_price,
                "thumbnail"=>$offer->product_thumbnail,
                "offers"=>[]
            ];

            $existing_products []= $offer->product_id;
        }
        foreach($array as $offer){
            if($offer->offer_id == null){
                continue;
            }
            $index = array_search($offer->product_id, array_column($arranged_products, "id"));
            $arranged_products[$index]["offers"] []= $offer;
        }

        return $arranged_products;
    }