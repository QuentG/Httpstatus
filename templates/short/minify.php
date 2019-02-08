<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>

<div class="container">
    <?php if (!$success) { ?>
        <h1 style="margin-top: 35vh;" class="mb-3">Impossible de minifier cette URL !</h1>
    <?php } else { ?>
            <h1 style="margin-top: 35vh;" class="mb-3">L'url a bien été minifiée !</h1>
            <h3>
                <a href="<?php $this->s(Router::url('Short', 'develop', ['uid' => $uid])); ?>">
                    <?php $this->s(Router::url('Short', 'develop', ['uid' => $uid])); ?>
                </a>
            </h3>
        </div>
    <?php } ?>
</div>

<?php include(PWD_TEMPLATES . '/incs/footer.php'); ?>