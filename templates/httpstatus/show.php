<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
<?php include(PWD_TEMPLATES . '/incs/header_admin.php'); ?>

<div class="container">
    <div class="row">
        <h3>Historic of : <a href="<?= $site_name['url_site']; ?>" target="_blank"><?= $site_name['url_site']; ?></a></h3>
    </div>

    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">Updated at</th>
                <th scope="col">Status</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($historic as $key => $list_historic) { ?>
                <tr>
                    <td><?= $list_historic['update_site'] ?></td>
                    <td>HTTP : <?= $list_historic['status_site']?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>