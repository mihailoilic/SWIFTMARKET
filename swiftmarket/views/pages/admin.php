<section id="admin-panel-wrapper" class="container py-3 mx-auto">
    <?php
        if(!($user_obj && $user_obj->role_name == "Administrator")){
            header("Location: index.php?page=home");
            die();
        }

        require_once "models/admin/functions.php";
        if(isset($_GET["message"])){
            echo "<p class='alert alert-info mt-3 mx-auto'>".$_GET["message"]."</p>";
        }
        if(isset($_GET["error"])){
            echo "<p class='alert alert-danger mt-3 mx-auto'>".$_GET["error"]."</p>";
        }

        $classes = [
            "stats"=> ["nav"=>"", "content"=>"d-none"],
            "users"=> ["nav"=>"", "content"=>"d-none"],
            "covers" => ["nav"=>"", "content"=>"d-none"],
            "products" => ["nav"=>"", "content"=>"d-none"]
        ];
        $panel = "stats";
        if(isset($_GET["panel"])){
            $panel = $_GET["panel"];
        }
        $classes[$panel] = ["nav"=>"active", "content"=>""];

    ?>
    <ul id="admin-nav" class="h5 font-weight-light d-flex flex-column flex-md-row my-5 pb-4">
        <li class="p-2">
            <a href="#!" class="p-2 admin-panel-link <?=$classes["stats"]["nav"]?>" data-target="#admin-panel-stats">Stats</a>
        </li>
        <li class="p-2">
            <a href="#!" class="p-2 admin-panel-link <?=$classes["users"]["nav"]?>" data-target="#admin-panel-users">Users</a>
        </li>
        <li class="p-2">
            <a href="#!" class="p-2 admin-panel-link <?=$classes["products"]["nav"]?>" data-target="#admin-panel-products">Items/Categories</a>
        </li>
        <li class="p-2">
            <a href="#!" class="p-2 admin-panel-link <?=$classes["covers"]["nav"]?>" data-target="#admin-panel-covers">Cover images</a>
        </li>
    </ul>
    <div class="p-2 admin-panel <?=$classes["stats"]["content"]?> row" id="admin-panel-stats">
        <?php 
            $stats = get_stats();
            $stats_today = get_stats(true);

        ?>
                <div class="col-12 col-md-6 my-3">
                    <h3 class="font-weight-light h5">Page view stats (all time):</h3>
                

        <?php
                foreach($stats["page_percentages"] as $key=>$value):
        ?>
                    <span class="text-muted small"> <?=$key?></span><span class="progress">
                        <div class="progress-bar px-2" role="progressbar" aria-valuenow="<?=(int)$value?>"
                        aria-valuemin="0" aria-valuemax="100"><?=$value?>%</div>
                    </span>
                
        <?php
                endforeach;
        ?>
                </div>

                <div class="col-12 col-md-6 my-3">
                    <h3 class="font-weight-light h5">Page view stats (today):</h3>
                

        <?php
                foreach($stats_today["page_percentages"] as $key=>$value):
        ?>
                    <span class="text-muted small"> <?=$key?></span><span class="progress">
                        <div class="progress-bar px-2" role="progressbar" aria-valuenow="<?=(int)$value?>"
                        aria-valuemin="0" aria-valuemax="100"><?=$value?>%</div>
                    </span>
                
        <?php
                endforeach;
        ?>
                </div>

                <div class="col-12 col-md-6 my-3">
                    <h3 class="font-weight-light h5">Users that visited today (<?=count($stats_today["users"])?>):</h3>
                    <ul class="">
                        <?php
                            foreach($stats_today["users"] as $user):
                        ?>
                        <li class="text-primary">
                            <?=$user?>
                        </li>
                        <?php
                            endforeach;
                        ?>
                    </ul>
                </div>

                <div class="col-12 col-md-6 my-3">
                    <h3 class="font-weight-light h5">Total pending offers: <span class="text-primary"><?=pending_offers()?></span></h3>
                    <h3 class="font-weight-light h5">Items created today: <span class="text-primary"><?=products_created_today()?></span></h3>
                </div>    

    </div>


    <div class="admin-panel <?=$classes["users"]["content"]?> py-2" id="admin-panel-users">
        <span class="fas fa-search text-muted"></span>
        <input type="text" id="search-users" class="form-control d-inline" placeholder="Search by username or e-mail" />
        <div id="users-wrapper" class="containter-fluid pt-5">
            <div class="user-info row m-0 border-bottom">
                <div class="col-1 user-id h5 font-weight-light">ID</div>
                <div class="col-2 username h5 font-weight-light">Username</div>
                <div class="col-3 user-email h5 font-weight-light">E-mail</div>
                <div class="col-2 user-full-name h5 font-weight-light">Full Name</div>
                <div class="col-2 user-date-created h5 font-weight-light">Date created</div>
                <div class="col-2 h5 font-weight-light text-right pr-4">Options</div>
            </div>
            <div id="users">
            </div>
        </div>
    </div>

    
    <div class="admin-panel <?=$classes["covers"]["content"]?> py-2 row" id="admin-panel-covers">
        <div class="col-12 col-md-6 my-3">
            <h3 class="font-weight-light h5 mb-4">Change main category cover image</h3>
            <form action="models/admin/change-cover-image.php" method="post" enctype="multipart/form-data" id="admin-change-category-cover-form">
                <input type="hidden" name="type" value="category"/>
                <select name="category-id" class="admin-panel-covers-select form-control">
            <?php
                require_once "models/products/functions.php";
                $main_cats = get_categories(true);
                
                foreach($main_cats as $cat):
            ?>
                    <option value="<?=$cat->category_id?>"><?=$cat->category_name?></option>
            <?php
                endforeach;
            ?>
                </select><br/>
                <span class="font-weight-light mr-3">Select image:</span>
                <input type="file" name="cover-image" /><br/>
                <small class="text-muted">Recommended resolution: 1920 x 1080</small><br/>
                <button type="submit" name="btn-change" class="mt-3 btn btn-primary">Change</button>
            </form>
        </div>
        
        <div class="col-12 col-md-6 my-3">
            <h3 class="font-weight-light h5 mb-4">Change page cover image</h3>
            <form action="models/admin/change-cover-image.php" method="post" enctype="multipart/form-data" id="admin-change-page-cover-form">
                <input type="hidden" name="type" value="page"/>
                <select name="page-id" class="admin-panel-covers-select form-control">
            <?php
                require_once "models/functions.php";
                $pages = get_pages();
                
                foreach($pages as $page):
            ?>
                    <option value="<?=$page->page_id?>"><?=$page->page_name?></option>
            <?php
                endforeach;
            ?>
                </select><br/>
                <span class="font-weight-light mr-3">Select image:</span>
                <input type="file" name="cover-image" /><br/>
                <small class="text-muted">Recommended resolution: 1920 x 1080</small><br/>
                <button type="submit" name="btn-change" class="mt-3 btn btn-primary">Change</button>
            </form>
        </div>
    </div>


    <div class="admin-panel <?=$classes["products"]["content"]?> py-2 row" id="admin-panel-products">
        <div class="alert alert-info col-12"><span class="fas fa-info-circle text-info"></span> To make items inactive or to see all offers & chat history - visit their dedicated pages in the <a href="index.php?page=buy">store</a>.<br/>
        It looks like this: <img class="mt-2" src="assets/img/admin-demo.png" alt="admin demo"/>
        </div>
        
        <form action="models/admin/add-category.php" method="post" id="admin-add-category" class="col-12 col-md-6 p-4">
            <h3 class="h5 font-weight-light my-3">Add new category</h3>
            <input type="text" name="name" id="category-name" class="form-control" placeholder="Category name"/>
            <select name="main" id="main-cat" class="form-control mt-2">
                <option value="0">Select main category...</option>
                <?php
                    $main_cats = get_categories(true);
                    foreach($main_cats as $cat):
                ?>
                        <option value="<?=$cat->category_id?>"><?=$cat->category_name?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <div class="form-check pl-0  mt-1">
                <input type="checkbox" name="is-main" id="is-main-cat" value="true" />
                <label class="form-check-label" for="is-main-cat"> 
                This is a main category
                </label>
            </div>
            <div class="form-check pl-0  mt-1">
                <input type="checkbox" name="gender-applies" id="gender-applies" value="true" />
                <label class="form-check-label" for="gender-applies"> 
                Gender applies to this category
                </label>
            </div>
            <button type="submit" name="btn-add" class="btn btn-primary mt-2">Add</button>
        </form>

        <form action="models/admin/remove-category.php" method="post" id="admin-remove-category" class="col-12 col-md-6 p-4">
            <h3 class="h5 font-weight-light my-3">Remove category</h3>
            <small class="text-muted">Only categories without existing items and subcategories can be removed</small>
            <select name="remove-category-id" id="remove-category-id" class="form-control mt-2">
                <option value="0">Select...</option>
                    <?php
                        $arranged_categories = arrange_categories(get_categories());
                        foreach($arranged_categories as $cat):
                    ?>
                        <optgroup label="<?=$cat["name"]?>">
                        <option value="<?=$cat["id"]?>">Main category: <?=$cat["name"]?></option>
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
            <button type="submit" name="btn-remove" class="btn btn-danger mt-2">Remove</button>
        </form>
        
    </div>
</section>