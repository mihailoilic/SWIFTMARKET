<?php
    require_once "../../config/connection.php";
    require_once "functions.php";


    if(!($user_obj && $user_obj->role_name == "Administrator")){

        header("Location: ../../index.php");
        die();
    }

    if(!isset($_GET["id"])){
        header("Location: ../../index.php");
        die();
    }

    $id = $_GET["id"];
    $offers = get_offers_by_product($id);

    header("Content-Disposition: attachment; filename=offers_for_product_$id.xls"); 
    header("Content-Type: application/vnd.ms-excel"); 

    $excel_string = "<table border=\"1\">";
    if($offers[0]->offer_id != null){

        add_offer_line("ID", "Buyer", "Price", "Status", "Message count");
        foreach($offers as $offer){

            switch($offer->offer_status){
                case 0: $status = "pending"; break;
                case 1: $status = "accepted"; break;
                case 2: $status = "rejected"; break;
                default: $status = "unknown";
            }
            add_offer_line($offer->offer_id, $offer->buyer_username, "$".$offer->offer_price, $status, $offer->message_count);
        }
    }
    else {
        $excel_string .= "<tr><td>No offers.</td></tr>";
    }

    echo $excel_string."</table>";

    function add_offer_line($id, $buyer, $status, $price, $chat_count){
        global $excel_string;

        $excel_string.="<tr>
            <td>$id</td>
            <td>$buyer</td>
            <td>$status</td>
            <td>$price</td>
            <td>$chat_count</td>
        </tr>";
    }