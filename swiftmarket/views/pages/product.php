<?php
    if(!isset($_GET["id"])){
        header("Location: index.php?page=buy");
        die();
    }

    require_once "models/products/functions.php";
    $product_id = $_GET["id"];
    $product_info = get_product_info($product_id);

    if(!$product_info){
        header("Location: index.php?page=buy");
    }
    $category_info = get_category_info($product_info[0]->parent_category_id);
    increment_product_views($product_id);

?>

<main id="product-view" class="container-fluid position-relative p-0">
    <section class="page-image w-100 d-flex flex-column justify-content-center align-items-center">
            <img id="page-bg-image" class="w-100 h-100" 
                src="assets/images/<?=$category_info->image_filename?>" 
                alt="<?=$category_info->image_title?>" />
            <h1 class="d-inline">
                <?=$category_info->category_name?>
            </h1>
    </section>
    <section class="mt-5 container row mx-auto mb-5">
    <?php
            if(isset($_GET["message"])){
                echo "<p class='alert alert-info mt-3 col-12 mx-auto'>".$_GET["message"]."</p>";
            }
            if(isset($_GET["error"])){
                echo "<p class='alert alert-danger col-12 mt-3 mx-auto'>".$_GET["error"]."</p>";
            }
            if($user_obj && $user_obj->role_name == "Administrator"):
    ?>
                <div id="admin-tools" class="alert alert-secondary col-12 text-right p-2"><span class="text-muted px-2 font-weight-light">Admin tools</span>
                    <?php
                        if($product_info[0]->active == "1"):
                    ?>
                        <a id="admin-make-inactive" href="models/admin/make-product-inactive.php?id=<?=$product_id?>" class="btn btn-danger">Make inactive</a>
                    <?php
                        endif;
                    ?>
                    <a href="index.php?page=admin-see-offers&id=<?=$product_id?>" class="btn btn-primary">See offers</a>
                </div>
    <?php
            endif;
    ?>
    <div class="p-4 col-12">
        <a href="index.php?page=products&category=<?=$category_info->category_id?>"><span class="fas fa-chevron-left"></span> Shop by this category</a>
        <?php
            if($user_obj):
        ?>
            <a href="#!" id="wish-list-toggle" class="float-right" data-id="<?=$product_id?>">
            <span class="wish-list-toggle-text">Add to wish list</span> <span class="h5"><span class="wish-list-toggle-icon far fa-heart"></span></span></a>
        <?php
            endif;
        ?>
    </div>
    <div id="product-images" class="col-12 col-md-6">
        <img src="assets/images/<?=$product_info[0]->image_filename?>" id="product-image" alt="<?=$product_info[0]->image_title?>" class="img-fluid rounded"/>
        <div id="product-all-images" class="row mx-0">
            <?php
                foreach($product_info as $image):
            ?>
                <div class="col-2 mr-2 mt-2 p-0"> 
                    <a href="#!" class="product-image-link" data-href="assets/images/<?=$image->image_filename?>">
                        <img src="assets/images/<?=$image->image_thumbnail_filename?>" alt="<?=$image->image_title?>" class="rounded img-fluid"/></a>
                </div>
            <?php
                endforeach;
            ?>
        </div>
    </div>
    <div id="product-info" class="col-12 col-md-6">
        <h2 class="h4 font-weight-light"><?=$product_info[0]->product_title?></h2>
        <h3 class="h6 font-weight-light"><?=$category_info->category_name." / ".$product_info[0]->category_name?></h3>
        <p id="product-date" class="mt-3 mb-0 small">
            <span class="far fa-calendar-alt"></span> 
            <?=date("Y-m-d", strtotime($product_info[0]->product_date_created))?>
        </p>
        <p id="product-date" class="mt-1 mb-0 small">
            <span class="fas fa-map-marker-alt"></span> 
            <?=$product_info[0]->city.", ".$product_info[0]->country?>
        </p>
        <p id="product-price" class="h4 font-weight-light mt-3" data-amount="<?=$product_info[0]->product_price?>">
        </p>
        <p id="product-condition" class="mt-2 small"><span class="fas fa-tag"></span> <?=$product_info[0]->condition_name?></p>
        
        <p id="product-description" class="my-4"><?=$product_info[0]->product_description?></p>
    </div>
    <div id="product-stats" class="mt-4 col-12 container-fluid row">
        <div id="product-views" class="col-12 col-sm-4 d-flex flex-column justify-content-center align-items-center font-weight-light border-right pt-4">
            <div class="h5 font-weight-light">Views</div>
            <div><span class="far fa-eye text-primary"></span> <?=$product_info[0]->product_views?></div>
        </div>
        <div id="product-offers" class="col-12 col-sm-4 d-flex flex-column justify-content-center align-items-center font-weight-light border-right pt-4">
            <div class="h5 font-weight-light">Offers</div>
            <div><span class="fas fa-users text-primary"></span> <?=$product_info[0]->product_offers?></div>
        </div>
        <div id="product-seller" class="col-12 col-sm-4 d-flex flex-column justify-content-center align-items-center font-weight-light pt-4">
            <div class="h5 font-weight-light">Seller</div>
            <div class="text-primary"><?=$product_info[0]->username?></div>
            <?php
                $rating = $product_info[0]->rating;
                if($rating != "No ratings yet"){
                    $rating = number_format($rating, 1);
                }
            ?>
            <div><span class="fas fa-star text-warning"></span><?=$rating?></div>
        </div>
    </div>
    <div id="product-buyer-offer" class="mt-5 p-4 col-12 rounded">
        <?php
        if($product_info[0]->active == "1"):
            if(!$user_obj || ($user_obj && $user_obj->user_id != $product_info[0]->seller_id)):

                require_once "models/offers/functions.php";
                $existing_offer = false;
                if($user_obj){
                    $existing_offer = get_existing_offer($product_id, $user_obj->user_id);
                }
                $text = "Your offer ($):";
                $amount = "";
                if($existing_offer){
                    $text = "Update offer ($):";
                    $amount = $existing_offer->offer_price;
                }
        ?>
            <form action="models/offers/user-submit-offer.php" method="post" id="product-buyer-offer-form">
                <input type="hidden" name="product-id" value="<?=$product_info[0]->product_id?>"/>
                <div class="row container-fluid p-0 m-0">
                    <span class="font-weight-light h5 col-12 col-sm-5 col-md-4 col-lg-3 text-sm-right mt-3"><?=$text?></span>
                    <input type="number" id="amount" name="amount" min="0.1" value="<?=$amount?>" placeholder="Enter your offer" step="0.1" class="form-control m-2 col-12 col-sm-3"/>
                    <div class="d-md-inline">
                        <input type="submit" name="btn-submit" value="Submit" class="m-2 py-1 px-2 btn btn-primary text-sm-left"/>
                        <?php
                            if($existing_offer):
                        ?>
                            <a href="models/offers/user-remove-offer.php?product-id=<?=$product_id?>" class="m-2 px-2 btn btn-danger text-sm-left"> Remove</a>
                        <?php
                            endif;
                        ?>
                    </div>
                </div>
            </form> 
        <?php
                else:
        ?>
                <p class="m-0">This item was created by you.</p>
        <?php
                endif;
            else:
        ?>
            <p class="m-0">This item is no longer active.</p>
        <?php
            endif;
        ?>
    </div>
</section>
</main>