<?php
    if(!($user_obj && $user_obj->role_name == "Administrator" && isset($_GET["id"]))){
        header("Location: index.php?page=home");
        die();
    }
    
    require_once "models/admin/functions.php";
    $product_id = $_GET["id"];

    $offers = get_offers_by_product($product_id);

    if($offers[0]->active == "1"){
        $status_html = "<span class='text-success font-weight-bold'>active</span>";
    }
    else {
        $status_html = "<span class='text-danger font-weight-bold'>inactive</span>";
    }

?>
<section id="admin-see-offers" class="custom container px-3">
    <p class="alert alert-info col-12 mt-3 mx-auto">
        This product is <?=$status_html?>.<br/>
        When a seller accepts an offer, the product becomes inactive and all the other pending offers automatically change their status to rejected. 
    </p>
    <h1 class="font-weight-light h4 mt-5"><?=$offers[0]->product_title?></h1>
    <h2 class="font-weight-light h5">Desired price: <span class="text-primary">$<?=$offers[0]->product_price?></span></h2>
    <div class="my-5">
        <a href="index.php?page=product&id=<?=$product_id?>"><span class="fas fa-chevron-left"></span> Back to product</a>

        <a href="models/admin/export-offers-to-excel.php?id=<?=$product_id?>" class="btn btn-success float-right">Export to excel</a>
    </div>
    <div id="admin-offers-wrapper" class="containter-fluid pt-5 mt-5">
        <div class="admin-offers-info row m-0 border-bottom px-4">
            <div class="col-2 h5 font-weight-light">ID</div>
            <div class="col-3 h5 font-weight-light">Buyer</div>
            <div class="col-2 h5 font-weight-light">Status</div>
            <div class="col-2 h5 font-weight-light">Price</div>
            <div class="col-3 h5 font-weight-light">Chat history</div>
        </div>
        <div id="admin-offers" class="container-fluid">
            <?php
                if($offers[0]->offer_id === null):
            ?>
                    <div class="col-12 h5 font-weight-light p-3">No offers to show</div>
            <?php
                else:
                    foreach($offers as $offer):
                        switch($offer->offer_status){
                            case "0":
                                $class = "text-warning";
                                $text = "pending";
                                break;
                            case "1":
                                $class = "text-success";
                                $text = "accepted";
                                break;
                            case "2":
                                $class = "text-danger";
                                $text = "rejected";
                                break;
                            default: 
                                $class = "";
                                $text = "unknown";
                        }
            ?>
                <div class="admin-offer-row row m-0 p-2">
                    <div class="col-2"><?=$offer->offer_id?></div>
                    <div class="col-3"><?=$offer->buyer_username?></div>
                    <div class="col-2 <?=$class?>"><?=$text?></div>
                    <div class="col-2 text-primary">$<?=$offer->offer_price?></div>
                    <div class="col-3">
                        <a href="index.php?page=admin-see-chat&id=<?=$offer->offer_id?>" class="btn btn-primary">See chat (<?=$offer->message_count?>)</a>
                    </div>
                </div>
            <?php
                    endforeach;
                endif;
            ?>
        </div>
    </div>
</section>