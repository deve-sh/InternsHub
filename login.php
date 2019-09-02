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
		?> - Login
	</title>

	<?php include ('./fragments/head.html'); ?>
</head>
<body>
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>

		<div class="fixedContainer">
			<?php
				// First checking if the user is logged in.
				// If yes, they are not allowed to login.

				if($_SESSION['int_loggedin'] && $_SESSION['int_userid']){
					?>
						<div class="alert alert-danger">
							Already logged in.
						</div>
					<?php

					header("refresh:1.5;url=./dashboard.php");
					exit();
				}
				else{
					// If the user is not logged in, then render the login form.

					?>
						<div class="formContainer">

							<form action="login-conf.php" id='rlform' method="POST">
								<label for="email">Email : </label>
								<input type="email" name="email" class="form-control" placeholder="abcd@xyz.com"  required/>
								
								<br/>

								<label for="password">Password : </label>
								<input type="password" name="password" class="form-control" placeholder=""  required/>

								<br/>

								<button class="btn btn-primary" type="submit">Login</button>
								 &nbsp;&nbsp;

								<a href="./"><span class="btn btn-info">Home</span></a>
							</form>

						</div>
					<?php
				}
			?>
		</div>
	</main>
</body>
</html>