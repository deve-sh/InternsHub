<?php
	session_start();
	require_once("./inc/config.php");		// Configuration File.
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];	// Change your appname in the config.php file.
		?>
	</title>
	<?php include ("./fragments/head.html"); ?>
</head>
<body>
	<main class="container-fluid">
		<!-- Bootstrap's container-fluid to keep the section responsive. -->

		<?php include './fragments/header.php'; ?>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>