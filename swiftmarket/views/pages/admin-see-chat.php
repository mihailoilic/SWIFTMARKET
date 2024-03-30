<?php
    if(!($user_obj && $user_obj->role_name == "Administrator" && isset($_GET["id"]))){
        header("Location: index.php?page=home");
        die();
    }
    
    require_once "models/admin/functions.php";
    $offer_id = $_GET["id"];

    $chat = get_chat_by_offer($offer_id);

    if($chat[0]->offer_status == "0"){
        $status_html = "<span class='text-warning font-weight-bold'>pending</span>";
    }
    elseif($chat[0]->offer_status == "1") {
        $status_html = "<span class='text-success font-weight-bold'>accepted</span>";
    }
    else {
        $status_html = "<span class='text-danger font-weight-bold'>rejected</span>";
    }

?>
<section id="admin-see-chat" class="custom container px-3">
    <p class="alert alert-info col-12 mt-3 mx-auto">
        The status of this offer is <?=$status_html?>.
    </p>
    <h1 class="font-weight-light h4"><?=$chat[0]->product_title?></h1>
    <h2 class="font-weight-light h5"><span class="text-success"><?=$chat[0]->buyer?></span>'s offer: <span class="text-primary"><?=$chat[0]->offer_price?></span></h2>
    <h2 class="font-weight-light h5">Desired price: <span class="text-primary">$<?=$chat[0]->product_price?></span></h2>
    <div class="my-5">
        <a href="index.php?page=admin-see-offers&id=<?=$chat[0]->product_id?>"><span class="fas fa-chevron-left"></span> Back to offers for this product</a>
    </div>

    <div class="border container-fluid rounded" id="admin-see-chat-box">
        <?php
            if($chat[0]->message_id === null):
        ?>
            <div class="message clearfix p-2">
                No messages
            </div>
        <?php
            else:
                foreach($chat as $message):
                    if($message->username == $chat[0]->buyer):
        ?>
                        <div class="message clearfix p-2">
                        <div class="message-sender w-75 w-md-50 text-success text-right float-right"><?=$message->username?> (buyer):</div>
                        <div class="message-content w-75 w-md-50 text-right float-right"><?=$message->message_text?></div>
        <?php
                    else:
        ?>
                        <div class="message clearfix p-2">
                            <div class="message-sender w-75 w-md-50 text-primary text-left"><?=$message->username?> (seller):</div>
                            <div class="message-content w-75 w-md-50 text-left"><?=$message->message_text?></div>
                        </div>
        <?php
                    endif;
                endforeach;
            endif;
        ?>
    </div>
</section>