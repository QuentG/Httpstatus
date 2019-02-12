<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
<?php include(PWD_TEMPLATES . '/incs/header_admin.php'); ?>

<div class="container mt-4">
        <form method="POST" action="">
            <h3>Modify a site</h3>
            <div class="form-group">
                <label for="inputUrl">Url du site</label> <br />
                <input type="url" name="url_site" placeholder="https://lucasconsejo.fr" value="<?= $url_site; ?>">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Modify</button>
        </form>
</div>

<?php $this->s($id); ?>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>