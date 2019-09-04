<?php
	// Script to check if the app is already installed.
	// If the script is installed then send the user back to the root.

	$configFile = fopen("../inc/config.php", "r");	// Opening the configuration file.

	$configuration = fread($configFile, filesize("../inc/config.php"));

	fclose($configFile);

	if($configuration[0] != '0'){
		// Script is installed.

		header("refresh:0;url=../");		// Redirect to the root immediately.
		exit();
	}

	// Prepare the queries to install the script otherwise.

	$queriesFile = fopen("../Queries.sql","r");

	$queries = fread($queriesFile, filesize("../Queries.sql"));

	fclose($queriesFile);
?>