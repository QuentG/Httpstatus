<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
<?php include(PWD_TEMPLATES . '/incs/header.php'); ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <form id="form-login" method="POST" action="">
                <h3>Admin</h3>
                <div class="input-group mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="icon-email"><img src="./static/img/login/icon-user.png" alt="icon user"/></span>
                    </div>
                    <input id="login-email" type="email" name="email" class="form-control" placeholder="Email">
                </div>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="icon-password"><img src="./static/img/login/icon-password.png" alt="icon password"/></span>
                    </div>
                    <input id="login-password" type="password" name="password" class="form-control" placeholder="Password">
                </div>

                <div id="login-submit" class="mt-4 mb-2">
                    <button type="submit" name="submit" class="btn">Login</button>
                </div>

                <?php
                    if(!$success){
                ?>
                    <div id="login-error" class="mt-2">
                        <p>Email ou mot de passe incorrect</p>
                    </div>
                <?php }?>
                        
                <div id="lost-password">
                    <a href="">lost your password ?</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>