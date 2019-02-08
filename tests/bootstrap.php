<?php
	###############
	# ENVIRONMENT #
	###############
	define('ENV', 'test');
	require_once(__DIR__ . '/descartes/load-environment.php');


    ###########
	# ROUTING #
	###########
    require_once(PWD . '/routes.php'); //Include routes
    
    
    ##############
	# INCLUDE    #
	##############
    //Use autoload
	require_once(PWD . '/descartes/autoload.php');
	require_once(PWD . '/vendor/autoload.php');


