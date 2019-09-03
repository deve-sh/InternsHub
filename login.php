<?php
	// Page for a user to login.

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
						<div class="alert alert-info">
							Already logged in.
						</div>
					<?php

					header("refresh:1.5;url=./user.php");
					exit();
				}
				else{
					// If the user is not logged in, then render the login form.

					?>
						<div class="formContainer">

							<form action="login-conf.php" class='rlform' method="POST">
								<h3>Login</h3>
								<br/>

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
		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>