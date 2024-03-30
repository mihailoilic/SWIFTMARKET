<?php
    ob_start();
    require_once "config/connection.php";

    $this_page = isset($_GET["page"]) ? $_GET["page"] : "home";
    if(!file_exists("views/pages/$this_page.php")){
        header("Location: index.php");
        die();
    }
    

    
    $pages = get_pages();
    
    require_once "views/fixed/head.php";
    require_once "views/fixed/nav.php";

    $file = "views/pages/$this_page.php";
    $info = get_page_info($this_page);
    if($info):
        if(!$user_obj && $info->requires_auth == "1"){
            header("Location: index.php");
            die();
        }
?>
    <main id="<?=$this_page?>">
        <section class="page-image w-100 d-flex flex-column justify-content-center align-items-center">
                <img id="page-bg-image" class="w-100 h-100" 
                    src="assets/images/<?=$info->image_filename?>" 
                    alt="<?=$info->image_title?>" />
                <h1 class="d-inline">
                    <?=$info->page_title?>
                </h1>
                <h2 class="d-inline mt-1 h5">
                    <?=$info->page_description?>
                </h2>
        </section>
        
        <?php 
            require_once $file;
        ?>
    </main>

<?php
    else:

        require_once $file;
        
    endif;


    ob_end_flush();
    require_once "views/fixed/footer.php";

?>







