<?php
	// File to check if the web application is installed or not.

	// If the app is not installed then send the user to the installation route.

	$configFile = fopen("./inc/config.php", "r");	// Opening the configuration file.

	$configuration = fread($configFile, filesize("./inc/config.php"));

	fclose($configFile);

	if($configuration[0] == '0'){
		// Script is installed.

		header("refresh:0;url=./install/");		// Redirect to the installation route immediately.
		exit();
	}

?>