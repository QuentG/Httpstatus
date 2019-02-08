<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>

<div class="container">
    <div class="row" style="margin-top: 35vh">
        <h1>Make it Short !</h1>
    </div>
    <div class="row mt-2">
        <form action="<?= Router::url('Short', 'minify'); ?>" method="POST" class="col-12">
            <div class="form-group row">
                <input type="url" class="form-control form-control-lg col-10 mr-2" id="url" name="url" placeholder="L'URL que vous voulez réduire." />
                <button class="btn btn-info btn-lg">Réduire l'URL</button>
            </div>
        </form>
    </div>
</div>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>