<?php
	###############
	# ENVIRONMENT #
	###############
	require_once(__DIR__ . '/descartes/load-environment.php');

	##############
	# INCLUDE #
	##############
    //Use autoload
	require_once(PWD . '/descartes/autoload.php');
	require_once(PWD . '/vendor/autoload.php');

	#########
	# MODEL #
	#########
    //Create new PDO instance
	$pdo = Model::connect(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);

	###########
	# ROUTING #
	###########
    require_once(PWD . '/routes.php'); //Include routes

    //Routing current query
    Console::execute_command($argv, $pdo);

