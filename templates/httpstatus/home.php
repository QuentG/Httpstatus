<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>

<?php include(PWD_TEMPLATES . '/incs/header.php'); ?>

<?php foreach($sites as $key => $site) { ?>
        <div class="container">
            <p> <?= $site['url_site'] ?></p>
            <p> <?= $site['status_site'] ?></p>
        </div>
        <button class="bt btn-primary">Voir l'historique</button>
<?php } ?>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>