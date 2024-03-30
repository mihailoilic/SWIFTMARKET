<?php
    require_once "models/products/functions.php";
    $products = get_products_from_wish_list();

?>
    <section id="wish-list-products" class="container py-3 mx-auto">

    <?php
        if(count($products) > 0):
            foreach($products as $product):

    ?>

            <div id="wish-list-product" class="p-0 mx-0 my-3 container-fluid row border rounded"> 
                <img class="wish-list-product-image col-12 col-sm-5 col-md-4 p-0 rounded" src="assets/images/<?=$product->product_thumbnail?>"  alt="<?=$product->product_title?>"/>

                <div class="wish-list-product-info col-12 col-sm-4 col-md-4 p-3">
                    <h3 class="h5 font-weight-light mb-3"><?=$product->product_title?></h3>
                    <div class="mb-2">
                        Status: <?=$product->active == "1" ? "<span class='text-success'>active" : "<span class='text-danger'>inactive"?></span>
                    </div>
                    <a href="index.php?page=product&id=<?=$product->product_id?>">View product</a>
                    
                </div> 
                    
                <div class="wish-list-product-price col-12 col-sm-3 col-md-4 text-sm-center p-3">
                    <h4 class="h5 font-weight-light">Price:</h4>
                    <div class="text-primary mb-3">$<?=$product->product_price?></div>
                </div>
            </div>
            
    <?php
            endforeach;
        else:
    ?>
        <div class="alert alert-secondary my-5">Your wish list is empty.</div>
    <?php
        endif;
    ?>


    </section>