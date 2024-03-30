<?php

            
            $nav_string = "";
            foreach($pages as $link){
                if($link->show_on_nav == "0"){
                    continue;
                }
                $active = $this_page==$link->page_name ? "active" : "";
                $link_title = ucfirst($link->page_name);
                $nav_string .= "<li class='m-2'>
                <a class='$active' href='index.php?page=$link->page_name'>$link_title</a>
                </li>";
            }
        
?>

<header id="header" class="position-fixed w-100 m-0 row align-items-center shadow">
        <div class="col-3 col-sm-6 col-md-4 col-lg-3">
            <!-- logo -->
            <a class="font-weight-bold" href="index.php?page=home">
                <img src="assets/img/logo.png" alt="swiftmarket" id="logo-img"/>
                <span id="logo-title" class="d-none d-sm-inline font-weight-light"> SWIFTMARKET</span>
            </a>
        </div>
        <!-- glavni meni -->
        <nav class="col-6 col-md-5 col-lg-6 d-none d-md-block">
            <ul id="menu" class="w-100 m-0 d-flex justify-content-start">
                <?=$nav_string?>
            </ul>
        </nav>
        <!-- opcije vezane za nalog, responsive meni toggle -->
        <div id="side-togglers" class="col-9 col-sm-6 col-md-3 text-right">
            <?php
                if($user_obj):
            ?>

            <a class="position-relative d-inline mx-2 color-primary" href="index.php?page=profile">
                <span class="fas fa-user-cog"></span>
            </a>
            <a class="position-relative d-inline mx-2 color-primary" href="index.php?page=wish-list">
                <span class="fas fa-heart"></span>
            </a> 
            <a class="position-relative d-inline mx-2 color-primary" href="models/users/logout.php">
                <span class="fas fa-sign-out-alt"></span>
            </a>

            <?php
                else:
            ?>

            <a class="position-relative d-inline mx-2 color-primary" href="index.php?page=login">
                Login
            </a>
            <a class="position-relative d-inline mx-2 color-primary" href="index.php?page=register">
                Register
            </a>

            <?php
                endif;
            ?>

            <a id="menu-button" class="position-relative d-inline d-md-none ml-3 mr-2 color-primary" href="#!">
                <span class="fas fa-bars"></span>
            </a>
        </div>
        <!-- user meni -->
        <?php

            if($user_obj):
        ?>
        <nav id="user-menu-wrapper" class="position-absolute w-100 px-2">
           
            <ul id="user-menu" class="w-100 m-0 d-flex align-items-center">
                    <li class="m-2 mx-sm-3">
                        <a  href="index.php?page=user-offers">My offers</a>
                    </li>
                    <li class="m-2 mx-sm-3">
                        <a  href="index.php?page=user-products">My items</a>
                    </li>
                    <?php
                        if($user_obj->role_name == "Administrator"):
                    ?>
                        <li class="m-2 mx-sm-3">
                            <a  href="index.php?page=admin">Admin</a>
                        </li>
                    <?php
                        endif;
                    ?>
                </ul>
        </nav>
        <?php
            endif;
        ?>
        <!-- responsive meni -->
        <nav id="responsive-menu-wrapper" class="position-absolute w-100 py-3 d-md-none">
            <ul id="responsive-menu" class="w-100 m-0 d-flex flex-column align-items-center">
                <?=$nav_string?>
            </ul>
        </nav>
</header>