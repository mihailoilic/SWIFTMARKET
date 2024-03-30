<section id="all-offers-wrapper" class="container py-3 mx-auto">
    <?php
            if(isset($_GET["message"])){
                echo "<p class='alert alert-info mt-3 mx-auto'>".$_GET["message"]."</p>";
            }
            if(isset($_GET["error"])){
                echo "<p class='alert alert-danger mt-3 mx-auto'>".$_GET["error"]."</p>";
            }

            require_once "models/offers/functions.php";
            $offers = get_all_offers_by_user($user_obj->user_id);

            if($offers):
                foreach($offers as $offer):
                    
                    switch($offer->offer_status){
                        case "0":
                            $class="warning";
                            $status = "pending";
                            break;
                        case "1":
                            $class="success";
                            $status = "accepted";
                            break;
                        case "2":
                            $class="danger";
                            $status="rejected";
                            break;
                        default:
                            $class="muted";
                            $status ="unknown";
                        
                    }
    ?>
    <div id="offer-wrapper" class="p-0 mx-0 my-3 container-fluid row border rounded"> 
        <img class="offer-product-image col-12 col-sm-5 col-md-4 p-0 rounded" src="assets/images/<?=$offer->product_thumbnail?>"  alt="<?=$offer->product_title?>"/>
        <div class="offer-info col-12 col-sm-4 col-md-4 p-3">
              <h3 class="h5 font-weight-light mb-3"><?=$offer->product_title?></h3>
              <div class="mb-2">
                Status: <span class="text-<?=$class?>"><?=$status?></span>
              </div>
              <div>
                <a href="index.php?page=product&id=<?=$offer->product_id?>">View product
                <?php
                    if($offer->active == "1"):
                ?>
                / change offer
                <?php
                    endif;
                ?></a>
              </div>
              <?php
                if($status == "pending"):
              ?>
              <div>
                <a href="models/offers/user-remove-offer.php?product-id=<?=$offer->product_id?>&return=user-offers" class="text-danger">Remove offer</a>
              </div>
              <?php
                endif;

                if($status=="accepted" && $offer->buyer_rating == null):
              ?>
                    <form id="rate-seller" action="models/offers/rate-seller.php" method="POST" class="pt-3 d-flex align-items-start">
                        <input type="hidden" name="offer-id" value="<?=$offer->offer_id?>"/>
                        <input type="number" min="1" max="5" value="5" name="rating" class="form-control"/>
                        <input type="submit" value="Rate seller" class="btn btn-primary ml-2" name="btn-rate"/>
                    </form>
            <?php
                endif;
            ?>
        </div>
        <div class="offer-amount-chat col-12 col-sm-3 col-md-4 text-sm-center p-3">
            <h4 class="h5 font-weight-light">Your offer:</h4>
            <div class="text-primary mb-3">$<?=$offer->offer_price?></div>
            <?php
                if($offer->offer_status != "2"):
            ?>
                <div><a href="index.php?page=c-h-a-t&offer-id=<?=$offer->offer_id?>" class="btn btn-primary">Chat with the seller
                <?php
                    if($offer->buyer_new_messages > 0):
                ?>
                        <div class="badge badge-danger"><?=$offer->buyer_new_messages?></div>
                <?php
                    endif;
                ?>
                </a>
                </div>
                <p class="text-muted small mt-1">When the seller approves your offer, they will contact you for delivery agreement.</p>
            <?php
                endif;
            ?>
        </div>
        
    </div>
    <?php
            endforeach;
        else:
    ?>
        <p class="alert alert-secondary my-5 mx-auto">You haven't made any offers yet.</p>
    <?php
        endif;
    ?>
</section>