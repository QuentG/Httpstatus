<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
<?php include(PWD_TEMPLATES . '/incs/header_admin.php'); ?>

<div class="container mt-4">
        <form method="POST" action="">
            <h3>Ajouter un site</h3>
            <div class="form-group">
                <label for="inputUrl">Url du site</label> <br />
                <input type="url" name="url_site" placeholder="https://lucasconsejo.fr">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
        </form>
</div>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>