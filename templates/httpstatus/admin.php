<?php \controllers\internals\Incs::head('Show value'); ?>

    <?php if ($second_value === null) { ?>
		<h1>Must show only one value : </h1>
		<ul>
			<li>Value : <?php $this->s($first_value); ?></li>
		</ul>
	<?php } else { ?>
		<h1>Must show multiple values : </h1>
		<ul>
			<li>First value : <?php $this->s($first_value); ?></li>
			<li>Second value : <?php $this->s($second_value); ?></li>
		</ul>
	<?php } ?>

<?php \controllers\internals\Incs::footer(); ?>
