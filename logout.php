<?php
	// Page to logout the user if they are logged in.

	session_start();
	require_once('./inc/config.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - Logout
	</title>
	<?php include './fragments/head.html'; ?>
</head>
<body onload='optionsREmover()'>
	<main class="container-fluid">
	<?php
		include './fragments/header.php';
	?>
	<div class='fixedContainer'>
		<?php
			if($_SESSION['int_loggedin']){
				// If the user is in fact logged in.

				$_SESSION['int_loggedin'] = false;
				$_SESSION['int_userid'] = null;

				session_destroy();		// Destroy the current session of the user.

				?>
					<div class="alert alert-success">Successfully Logged Out.</div>
				<?php
				header("refresh:1.5;url=./");	// Redirect home after logging out, after 1.5 seconds.
				exit();
			}
			else{
				// Else show an error message and go back home.
				?>
					<div class="alert alert-danger">Login to logout.</div>
				<?php
					header("refresh:1.5;url=./");
					exit();
			}
		?>
	</div>
	</main>
</body>
</html>