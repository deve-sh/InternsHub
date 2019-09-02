<?php
	// Page for a user to signup.
	// This is a presentational page. I.E : It does not have any signup logic associated with it.
	// For that, check signup-conf.php

	session_start();

	require_once('./inc/config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config["appname"];
		?> - Signing Up
	</title>

	<?php include ('./fragments/head.html'); ?>
</head>
<body>
	
</body>
</html>