<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>

<?php include(PWD_TEMPLATES . '/incs/header.php'); ?>

<div class="container">
    <div class="row">  
        <?php if(empty($sites)){?>
            <div id="no-sites" class="col-md-12">
                <h4>No sites to display</h4>
            </div>
        <?php }else{ ?>
            <table class="table mt-2">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Url</th>
                        <th scope="col">Status</th>
                        <th scope="col">Historic</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($sites as $key => $site) { ?>
                        <tr>
                            <th scope="row"><?= $site['id'] ?></th>
                            <td><a href="<?= $site['url_site'] ?>" target="_blank"><?= $site['url_site'] ?></a></td>
                            <td>HTTP : <?= $site['status_site']?></td>
                            <td><a href="./show/<?= $site['id'] ?>">See the history</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div> 


<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>