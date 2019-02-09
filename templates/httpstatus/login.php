<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
<?php include(PWD_TEMPLATES . '/incs/header.php'); ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">
            <form id="form-login" method="POST" action="">
                <h3>Login</h3>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="icon-email"></span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>

                <div class="input-group-prepend">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="icon-password">@</span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                
                <button id="login-submit" type="submit" name="submit" class="btn btn-primary">Login</button>
                
                <div id="lost-password">
                    <a href="">lost your password ?</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>