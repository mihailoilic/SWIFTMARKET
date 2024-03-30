<?php
    function get_stats($today=false){

        $page_stats = [];
        $users = [];
        $count = 0;

        $log_file = fopen(LOG_FILE, "r");        
        if($log_file) {

            $size = filesize(LOG_FILE);
            while (!feof($log_file)) {

                $line = stream_get_line($log_file, $size, "\n\n");
                if(!trim($line)){
                    continue;
                }

                list($timestamp, $username, $ip, $url, $target) = explode("\n", $line);

                if($target == "(no target page)"){
                    continue;
                }
                if($today){
                    $min = strtotime("today 00:00:01");
                    if(strtotime($timestamp) < $min){
                        continue;
                    }
                    
                    if($username != "(guest)" && !in_array($username, $users)){
                        $users []= $username;
                    }
                }
                $count++;

                if(isset($page_stats[$target])){
                    $page_stats[$target]++;

                }
                else {
                    $page_stats[$target] = 1;
                }
            }
            fclose($log_file);
            arsort($page_stats);
        }
        
        return ["page_percentages"=>get_page_view_percentages($page_stats, $count), "users"=>$users];
    }

    function get_page_view_percentages($page_stats, $total){
        if($total == 0){
            return $page_stats;
        }
        foreach($page_stats as $i=>$value){
            $page_stats[$i] = number_format($value / $total * 100, 1);
        }

        return $page_stats;
    }

    function pending_offers(){
        try {
            $result = select_query("SELECT COUNT(*) AS offer_count FROM offers WHERE offer_status = 0", true);
            if(!$result){
                return 0;
            }
            else {
                return $result[0]->offer_count;
            }
        }
        catch(PDOException $ex){
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return 0;
        }
    }

    function products_created_today(){
        try {
            $result = select_query("SELECT COUNT(*) AS product_count FROM products WHERE product_date_created > CURDATE()", true);
            if(!$result){
                return 0;
            }
            else {
                return $result[0]->product_count;
            }
        }
        catch(PDOException $ex){
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            return 0;
        }
    }

    function get_offers_by_product($product_id){
        
        global $conn;
        try {
            $select = $conn->prepare("SELECT o.*, p.product_title, p.active, p.product_price, u.username AS buyer_username, (SELECT COUNT(*) FROM messages WHERE offer_id = o.offer_id) AS message_count FROM  products p LEFT JOIN offers o ON o.product_id = p.product_id LEFT JOIN users u ON u.user_id = o.buyer_id WHERE p.product_id = ?");
            $select->execute([$product_id]);
            $result = $select->fetchAll();
            if(!$result){
                $result = [];
            }
        }
        catch(PDOException $ex){
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            $result = [];
        }

        return $result;

    }

    function get_chat_by_offer($offer_id){

        global $conn;
        try {
            $select = $conn->prepare("SELECT *, (SELECT username FROM users WHERE user_id = o.buyer_id) AS buyer FROM  offers o JOIN products p ON o.product_id = p.product_id LEFT JOIN messages m ON m.offer_id = o.offer_id LEFT JOIN users u ON u.user_id = m.sender_id WHERE o.offer_id = ? ORDER BY m.message_timestamp ASC");
            $select->execute([$offer_id]);
            $result = $select->fetchAll();
            if(!$result){
                $result = [];
            }
        }
        catch(PDOException $ex){
            create_log(ERROR_LOG_FILE, $ex->getMessage());
            $result = [];
        }

        return $result;
    }