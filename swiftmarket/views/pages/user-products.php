<section id="all-product-offers-grid" class="container py-3 mx-auto">
<?php

    require_once "models/offers/functions.php";
    $arranged_products = (arrange_products_with_offers(get_all_products_with_offers_by_seller()));

    if(isset($_GET["message"])){
        echo "<p class='alert alert-info container mt-3 mx-auto'>".$_GET["message"]."</p>";
    }
    if(isset($_GET["error"])){
        echo "<p class='alert alert-danger container mt-3 mx-auto'>".$_GET["error"]."</p>";
    }


    if(count($arranged_products) <= 0){
        echo "<p class='alert alert-secondary container py-3 my-5 mx-auto'>You haven't created any items yet.</p>";
        die();
    }

    foreach($arranged_products as $product):

        if($product["status"]=="0"){
            $status = "Inactive";
            $class = "danger";
        }
        else {
            $status = "Active";
            $class ="success";
        }

?>


    <div id="product-wrapper" class="p-0 mx-0 my-3 container-fluid row border rounded"> 
        <img class="product-image col-12 col-sm-5 col-md-4 p-0 rounded" src="assets/images/<?=$product["thumbnail"]?>"  alt="<?=$product["title"]?>"/>

        <div class="product-info col-12 col-sm-4 col-md-4 p-3">
              <h3 class="h5 font-weight-light mb-3"><?=$product["title"]?></h3>
              <div class="mb-2">
                Status: <span class="text-<?=$class?>"><?=$status?></span>
              </div>
              <div>
                <a href="index.php?page=product&id=<?=$product["id"]?>">View product</a>
              </div>
        </div>

        <div class="product-price col-12 col-sm-3 col-md-4 text-sm-center p-3">
            <h4 class="h5 font-weight-light">Desired price:</h4>
            <div class="text-primary mb-3">$<?=$product["price"]?></div>
            <p class="text-muted small mt-1">When you approve a buyer's offer, contact them for delivery agreement.</p>
        </div>

        <div class="product-offers-wrapper mt-3 col-12">
            <div class="product-offer p-2 row  h5 font-weight-light border-bottom">
                <div class="col-6 col-md-3">Offer</div>
                <div class="col-6 col-md-3">Buyer</div>
                <div class="d-none d-md-block col-sm-6"></div>
            </div>

            <?php
                if(count($product["offers"])<=0):

                    echo "<p class='p-3 font-weight-light'>No offers.</p>";

                elseif($status == "Active"):
                    foreach($product["offers"] as $offer):

            ?>


            <div class="product-offer p-2 row ">
                <div class="col-6 col-md-3 py-2">$<?=$offer->offer_price?></div>
                <div class="col-6 col-md-3 py-2"><?=$offer->username?></div>
                <div class="col-12 col-md-6 py-2">
                    <a href="models/offers/seller-accept.php?id=<?=$offer->offer_id?>" class="btn btn-success m-1">Accept this offer</a>
                    <a href="index.php?page=c-h-a-t&offer-id=<?=$offer->offer_id?>" class="btn btn-primary m-1">Chat with buyer
                    <?php
                        if($offer->seller_new_messages > 0):
                    ?>
                            <div class="badge badge-danger"><?=$offer->seller_new_messages?></div>
                    <?php
                        endif;
                    ?>
                    </a>
                </div>
            </div>

            <?php
                    endforeach;
                else:
                    $accepted_offer = (object)["offer_price"=>"Unknown", "username"=>"unknown", "offer_id"=>"-1"];

                    foreach($product["offers"] as $offer){
                        if($offer->offer_status == "1"){
                            $accepted_offer = $offer;
                            break;
                        }
                    }
            ?>

            <div class="product-offer p-2 row ">
                <div class="col-6 col-md-3 py-2">$<?=$accepted_offer->offer_price?></div>
                <div class="col-6 col-md-3 py-2"><?=$accepted_offer->username?></div>
                <div class="col-12 col-md-6 py-2">
                    <span class="px-2 text-success">Accepted offer</span>
                    <a href="index.php?page=c-h-a-t&offer-id=<?=$accepted_offer->offer_id?>" class="btn btn-primary m-1">Chat with buyer
                    <?php
                        if($offer->seller_new_messages > 0):
                    ?>
                            <div class="badge badge-danger"><?=$offer->seller_new_messages?></div>
                    <?php
                        endif;
                    ?>
                    </a>
                </div>
            </div>

            <?php
                endif;
            ?>
        </div> 
        
    </div>
    <?php
        endforeach;
    ?>
</section>