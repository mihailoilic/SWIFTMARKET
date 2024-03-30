<section id="account-panel" class="slim row p-4 h6 font-weight-light">
    <div id="account-info" class="col-12 col-md-6">
        <h2 class="text-muted my-3 font-weight-light h4">Info</h2>
        <div class="my-2">
            <span class="fas fa-user color-primary"></span> <?=$user_obj->username?>
        </div>
        <div class="my-2">
            <span class="fas fa-signature color-primary"></span> <?=$user_obj->full_name?>
        </div>
        <div class="my-2">
            <span class="fas fa-envelope color-primary"></span> <?=$user_obj->email?>
        </div>
        <div class="my-2">
            <span class="fas fa-map-marker-alt color-primary"></span> <?=$user_obj->city?>, <?=$user_obj->country?>
        </div>
        <div class="my-2">
            <span class="fas fa-calendar-alt color-primary"></span> Date created: <?=$user_obj->user_date_created?>
        </div>
        <div class="my-2">
            <span class="fas fa-laptop-house color-primary"></span> Role: <?=$user_obj->role_name?>
        </div>
    </div>
    <div id="change-pw-wrapper" class="col-12 col-md-6">
        <h2 class="text-muted my-3 font-weight-light h4">Change password</h2>
        <form name="change-pw" id="change-pw" action="models/users/user-change-pw.php" method="post">
            <input type="password" name="old-pw" id="old-pw" class="form-control my-2" placeholder="Old password" data-title="old password"/>
            <input type="password" name="new-pw" id="new-pw" class="form-control my-2" placeholder="New password" data-title="new password"/>
            <input type="password" name="confirm-pw" id="confirm-pw" class="form-control my-2" placeholder="Confirm new password" data-title="password confirmation"/>
            <button type="submit" id="btn-change-pw" name="btn-change-pw" class="btn btn-primary">Change</button>
        </form>
        <?php
            if(isset($_GET["error"])){
                echo "<p class='alert alert-danger mt-3'>".$_GET["error"]."</p>";
            }
            if(isset($_GET["message"])){
            echo "<p class='alert alert-info mt-3'>".$_GET["message"]."</p>";
            }
        ?>
    </div>
</section>
        
