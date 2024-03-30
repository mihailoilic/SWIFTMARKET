<?php

    if(!isset($_GET["offer-id"])){
        header("Location: index.php");
        die();
    }

    $offer_id = $_GET["offer-id"];

    require_once "models/offers/functions.php";
    $offer_info = get_offer_info_for_chat($offer_id);

    if(!$offer_info){
        header("Location: index.php");
        die();
    }
    list($role, $offer) = $offer_info;

    if(!in_array($offer->offer_id, $_SESSION["allowed_chats"])){
        $_SESSION["allowed_chats"] []= $offer->offer_id;
    }
    $_SESSION["chat_role"][$offer->offer_id] = $role;


?>
    <div class="alert alert-info container my-4"><span class="fas fa-info-circle text-info"></span> Due to limited server capabilities, new messages are being checked every 3-5s. Sorry for the inconvenience.</div>

    <section id="chat-info" class="container mx-auto p-4 mt-4">
        <span class="h5 font-weight-light">Item:</span> <a class="h5 font-weight-normal" href="index.php?page=product&id=<?=$offer->product_id?>"><?=$offer->product_title?></a><br/>
        <span class="h5 font-weight-light">Buyer's offer:</span> <span id="chat-buyer-offer" data-amount="<?=$offer->offer_price?>"></span><br/>
        <span class="h5 font-weight-light">Desired price:</span> <span id="chat-desired-price" data-amount="<?=$offer->product_price?>"></span>
    </section>

    <section class="border container rounded" id="chat-box" data-offer-id="<?=$offer->offer_id?>">
    </section>
    <section class="container px-0 py-2 my-1 mx-auto d-flex" id="chat-box-send-wrapper">
        <div class="w-100">
            <input type="text" class="form-control" id="tb-send-message" placeholder="Enter your message"/>
        </div>
        <div>
            <button type="button" id="btn-send-message" class="btn btn-primary ml-2">Send</button>
        </div>
    </section>

    <section id="chat-rules" class="container mx-auto p-4 mt-4">
        
        <h3 class="h5 font-weight-light">Chat rules:</h3>
        <?=get_chat_rules_html()?>
        <div class="small"> - If you don't comply with these rules, the administrators have the right to ban your account.</div>

    </section>

    