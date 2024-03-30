<section id="sell-promo" class="p-2 container mx-auto">
        <?php
            if(isset($_GET["message"])){
                echo "<p class='alert alert-info mt-3 mx-auto'>".$_GET["message"]."</p>";
            }
            if(isset($_GET["error"])){
                echo "<p class='alert alert-danger mt-3 mx-auto'>".$_GET["error"]."</p>";
            }
        ?>

    <div id="sell-promo-1" class="py-5 m-0 row container-fluid justify-content-center align-items-center">
        <img class="col-7 col-md-3" src="assets/img/sell-step-1.png"/>
        <div class="col-7 col-md-4 p-3">
            <h4 class="h5 font-weight-light">1. Put your item up for sale by using the form below and set desired price.</h4>
        </div>
    </div>

    <div id="sell-promo-2" class="py-5 m-0 row container-fluid justify-content-center align-items-center">
        <div class="col-7 col-md-4 p-3">
            <h4 class="h5 font-weight-light text-right">2. Wait for buyers to make offers. You can also chat with them after their price proposal.</h4>
        </div>
        <img class="col-7 col-md-3" src="assets/img/sell-step-2.png"/>
    </div>

    <div id="sell-promo-3" class="py-5 m-0 row container-fluid justify-content-center align-items-center">
        <img class="col-7 col-md-3" src="assets/img/sell-step-3.png"/>
        <div class="col-7 col-md-4 p-3">
            <h4 class="h5 font-weight-light">3. Accept the best offer and contact the buyer about delivery or picking up terms.</h4>
        </div>
    </div>
    
</section>

<?php
    if(!$user_obj):
?>
    <p class="p-5 text-center">To add new item, you must <a href="index.php?page=login" class="font-weight-bold">log in</a> first.</p>
<?php
    else:

        require_once "models/products/functions.php";
        $categories = get_categories();
        $arranged_categories = arrange_categories($categories);
        $conditions = get_conditions();
        $genders = get_genders();
?>
<section id="add-product-wrapper" class="slim row mx-auto mt-5 py-4">
    <h3 class="h4 font-weight-light my-5">Add new item</h3>
    <form id="sell-item-form" action="models/products/user-submit-new-product.php" method="post" enctype="multipart/form-data" class="w-100">
        <div class="form-group">
                <label for="product-title">Title:</label>
                <input type="text" name="product-title" id="product-title" data-title="Title" class="form-control"/>
        </div>
        <div class="form-group">
                <label for="product-description">Description:</label>
                <textarea name="product-description" id="product-description" data-title="Description" class="form-control"rows="10"></textarea>
        </div>
        <div class="form-group">
                <label for="product-category">Category:</label>
                <select name="product-category" id="product-category" data-title="category" class="form-control">
                    <option value="0">Select...</option>
                    <?php
                        foreach($arranged_categories as $cat):
                    ?>
                        <optgroup label="<?=$cat["name"]?>">
                        <?php
                            foreach($cat["subcategories"] as $subcat):
                        ?>
                                <option value="<?=$subcat["id"]?>"><?=$subcat["name"]?></option>
                        <?php
                            endforeach;
                        ?>
                        </optgroup>
                    <?php
                        endforeach;
                    ?>
                </select>
        </div>
        <div class="form-group">
                <label for="product-price">Price ($):</label>
                <input type="number" name="product-price" id="product-price" data-title="Price" min="0.1" value="10" step="0.1" class="form-control"/>
        </div>
        <div class="form-group">
                <label for="product-condition">Condition:</label>
                <select name="product-condition" id="product-condition" data-title="condition" class="form-control">
                    <option value="0" selected="selected">Select...</option>
                    <?php
                        foreach($conditions as $cond):
                    ?>
                        <option value="<?=$cond->condition_id?>"><?=$cond->condition_name?></option>
                    <?php
                        endforeach;
                    ?>
                </select>
        </div>
        <div class="form-group mb-0 pt-3">
                <input type="checkbox" name="genders-apply" id="genders-apply"/>
                <label for="genders-apply">Gender applies to this item:</label>
        </div>
        <div class="form-group">
                <label for="gender" class="text-black-50">Select gender:</label>
                <select name="gender" disabled="disabled" id="gender" class="form-control">
                    <option value="0" selected="selected">Select...</option>
                    <?php
                        foreach($genders as $gend):
                    ?>
                        <option value="<?=$gend->gender_id?>"><?=$gend->gender_name?></option>
                    <?php
                        endforeach;
                    ?>
                </select>
        </div>
        <p class="pt-3">Photos (min 1):</p>
        <div id="product-photos" class="my-2">
            <div class="my-2">
                <input type="file" class="overflow-hidden" name="photo-1"/>
            </div>
        </div>
        <a href="#!" id="add-new-photo"><span class="fas fa-plus-circle text-success"></span> Add another photo</a>
        

        <input type="submit" name="btn-add-product" value="Submit item" class="d-block mt-5 btn btn-primary"/>
    </form>
</section>
<?php
    endif;
?>