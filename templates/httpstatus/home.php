<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>

<?php include(PWD_TEMPLATES . '/incs/header.php'); ?>

<div class="container">
    <div class="row">  
        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">url</th>
                    <th scope="col">status</th>
                    <th scope="col">historic</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($sites as $key => $site) { ?>
                    <tr>
                        <th scope="row"><?= $site['id'] ?></th>
                        <td><a href="<?= $site['url_site'] ?>"><?= $site['url_site'] ?></a></td>
                        <td>HTTP : <?= $site['status_site']?></td>
                        <td><a href="./show/<?= $site['id'] ?>">See the history</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div> 


<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>