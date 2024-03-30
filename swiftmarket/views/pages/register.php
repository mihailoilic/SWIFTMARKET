    <main id="register" class="custom slim container position-relative mx-auto mb-5">
        <?php
            if(isset($_GET["message"])){
                echo "<p class='alert alert-info mt-3 mx-auto'>".$_GET["message"]."</p>";
            }
            if(isset($_GET["error"])){
                echo "<p class='alert alert-danger mt-3 mx-auto'>".$_GET["error"]."</p>";
            }
        ?>
        <h1 class="text-muted my-5 font-weight-light h2 mx-auto">
            Registration
        </h1>
        <form id="register-form" class="mx-auto my-5" name="registerForm" method="post" action="models/users/register.php">
            <div class="form-group">
                <label for="full-name">Full Name:</label>
                <input type="text" name="full-name" id="full-name" data-title="Full name" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" data-title="E-mail" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" data-title="Username" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="username">City/area:</label>
                <input type="text" name="city" id="city" data-title="City" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="username">Country:</label>
                <input type="text" name="country" id="country" data-title="Country" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" data-title="Password" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="password-repeat">Confirm password:</label>
                <input type="password" name="password-repeat" id="password-repeat" data-title="Password repeat" class="form-control"/>
            </div>
            <input type="submit" value="Register" name="btn-register" class="btn btn-primary"/>
        </form>
        
        
        
    </main>
