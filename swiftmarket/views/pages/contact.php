<?php
    $name = "";
    $email = "";
    if($user_obj){
        $name = $user_obj->full_name;
        $email = $user_obj->email;
    }
?>
<form id="contact-form" class="slim mx-auto my-5" name="contact-form" method="post" action="models/mail/send-mail.php">

        <?php
            if(isset($_GET["error"])){
                echo "<p class='alert alert-danger mt-3 mx-auto'>".$_GET["error"]."</p>";
            }
            if(isset($_GET["message"])){
                echo "<p class='alert alert-info mt-3 mx-auto'>".$_GET["message"]."</p>";
            }
        ?>

        <div class="form-group">
            <label for="name">Your name:</label>
            <input type="text" name="name" id="name" data-title="Name" class="form-control" value="<?=$name?>"/>
        </div>
        <div class="form-group">
            <label for="username">E-mail:</label>
            <input type="text" name="email" id="email" data-title="E-mail" class="form-control" value="<?=$email?>"/>
        </div>
        <div class="form-group">
            <label for="username">Your message:</label>
            <textarea class="form-control" id="message" name="message" data-title="Message"></textarea>
        </div>
        <input type="submit" value="Send" name="btn-send" id="btn-send" class="btn btn-primary"/>
</form>
        
