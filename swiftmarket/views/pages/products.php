<?php
    if(!isset($_GET["category"])){
        header("Location: index.php?page=buy");
        die();
    }

    require_once "models/products/functions.php";

    $category_id = $_GET["category"];
    $category = get_category_info($category_id);

    if(!$category){
        header("Location: index.php?page=buy");
        die();
    }

?>
<!-- Prenos iz PHP-a u JS -->
<script>
    window.category_info = JSON.parse(`<?=json_encode($category)?>`);
</script>

<main id="products">
    <section class="page-image w-100 d-flex flex-column justify-content-center align-items-center">
            <img id="page-bg-image" class="w-100 h-100" 
                src="assets/images/<?=$category->image_filename?>" 
                alt="<?=$category->image_title?>" />
            <h1 class="d-inline">
                <?=$category->category_name?>
            </h1>
            <h2 class="d-inline mt-1 h5">
                <a href="index.php?page=buy" class="text-white"><span class="fas fa-chevron-left"></span> Choose another category</a>
            </h2>
    </section>

    <section id="products-wrapper" class="row mx-auto mt-5 py-4">
            <div id="products-filters" class="col-12 col-sm-5 col-md-4 col-lg-4 col-xl-2 m-0">              
                <div>
                    <a href="#!" id="clear-filters"><span class="fas fa-times"></span> Clear all filters</a>&nbsp;
                </div>
                <?php
                    $admin_class="d-none";
                    if($user_obj && $user_obj->role_name == "Administrator"){
                        $admin_class = "";
                    }
                ?>
                <div class="mt-3 mb-5 form-check <?=$admin_class?>">
                    <input class="form-check-input" type="checkbox" id="inactive" value="true"/>
                    <label class="form-check-label" for="inactive"> 
                    Inactive products
                    </label>
                </div>
                <div class="mt-3 mb-5">
                    <!-- <h3 class="h5 font-weight-light">Subcategories: </h3> -->
                    <ul id="subcategories">
                        <?php
                            foreach(get_subcategories($category->category_id) as $cat):
                        ?>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" id="subcategory-<?=$cat->category_id?>" value="<?=$cat->category_id?>"/>
                                <label class="form-check-label" for="subcategory-<?=$cat->category_id?>">
                                <?=$cat->category_name?>
                                </label>
                            </li>
                        <?php
                            endforeach;
                        ?>
                    </ul>
                </div>
                <?php
                    if($category->genders_apply == "1"):
                ?>
                <div class="my-5">
                    <h3 class="h5 font-weight-light">Genders: </h3>
                    <ul id="genders">
                        <?php
                            foreach(get_genders() as $gender):
                        ?>

                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" id="gender-<?=$gender->gender_id?>" value="<?=$gender->gender_id?>"/>
                                <label class="form-check-label" for="gender-<?=$gender->gender_id?>">
                                <?=$gender->gender_name?>
                                </label>
                            </li>

                        <?php
                            endforeach;
                        ?>
                    </ul>
                </div>
                <?php
                    endif;
                ?>
                <div class="my-5">
                    <h3 class="h5 font-weight-light">Conditions: </h3>
                    <ul id="conditions">
                        <?php
                            foreach(get_conditions() as $cond):
                        ?>

                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" id="condition-<?=$cond->condition_id?>" value="<?=$cond->condition_id?>"/>
                                <label class="form-check-label" for="condition-<?=$cond->condition_id?>">
                                <?=$cond->condition_name?>
                                </label>
                            </li>

                        <?php
                            endforeach;
                        ?>
                    </ul>
                </div>
                
                <div class="form-group">
                    <label for="min-price" class="font-weight-light h5">Min price ($):</label>
                    <input type="text" id="min-price" class="form-control" placeholder="For example: 15"/>
                </div>  
                <div class="form-group">
                    <label for="max-price" class="font-weight-light h5">Max price ($):</label>
                    <input type="text" id="max-price" class="form-control" placeholder="For example: 45"/>
                </div> 
                
                <div class="form-group pt-3">
                    <label for="min-price" class="font-weight-light h5">Location:</label><br/>
                    <?php
                        $d_class = $user_obj ? "" : "d-none";
                    ?>
                    <div class="form-check <?=$d_class?>">
                        <input class="form-check-input" type="checkbox" id="user-location" value="true"/>
                        <label class="form-check-label" for="user-location"> 
                        Only my location
                        </label>
                    </div>
                    <input type="text" id="location" class="form-control" placeholder="Enter city and/or country"/>
                    <small class="text-muted">Example 1: Belgrade, Serbia</small><br/>
                    <small class="text-muted">Example 2: London</small>
                </div>  
            </div>
            <div id="products-panel" class="col-12 col-sm-7 col-md-8 col-lg-8 col-xl-10 m-0">
                <div id="products-grid-options" class="row justify-content-between">
                    <div class="col-12 col-sm-12 col-xl-5 my-2 m-md-none">
                        <span><span class="fas fa-search"></span> Search products:</span>
                        <div class="row m-0">
                            <input type="text" class="form-control col-12" value="" id="search-products" placeholder="Enter keywords here"/>
                            <!-- <a href="#!" id="search-products-btn" class="col-2 btn btn-primary"><span class="fas fa-search"></span></a> -->
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-4 my-2 m-md-none">
                        <span><span class="fas fa-sort"></span> Sort by:</span>
                        <select class="form-control" id="sort-products">
                            <option value="product_views desc">Popularity</option>
                            <option value="product_date_created desc">Most recently added</option>
                            <option value="product_price asc">Price ascending</option>
                            <option value="product_price desc">Price descending</option>
                            <option value="product_title asc">Name ascending</option>
                            <option value="product_title desc">Name descending</option>
                          </select>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 my-2 m-md-none">
                        <span><span class="fas fa-layer-group"></span> Pagination:</span>
                        <select class="form-control" id="paginate-products">
                            <option value="0">None</option>
                            <option value="8" selected="selected">8 products per page</option>
                            <option value="16">16 products per page</option>
                          </select>
                    </div>
                </div>
                <div id="products-grid" class="row m-0 mt-4">
                    
                    
                    <!-- <div class="product-wrapper col-12 col-md-6 col-xl-3 p-4">
                        <a class="product" href="index.php?page=product&id=1">
                            <div class="border rounded shadow row">
                                <img class="col-12 p-0 rounded" src="assets/images/test.jpg" alt="ddf"/>
                                <h5 class="col-12 h4 pt-3 font-weight-light text-dark">Naslov proizvodaa Naslov proizvodaa Naslov proizvodaa Naslov proizvodaa Naslov proizvodaa </h5>
                                <div class="col-12 d-flex flex-column justify-content-center text-right p-3 text-primary">
                                    <div class="h5 font-weight-light">$1.300,00</div>
                                    <div class="font-weight-light"><span class="far fa-eye"></span> 451</div>
                                </div>
                            </div>
                        </a> 
                    </div> -->

                </div>
                <div id="pagination" class="mt-5 text-center">
                </div>
            </div>
            
        </section>


</main>