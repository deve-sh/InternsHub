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
		?> - Signup
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
							Kindly logout in order to register.
						</div>
					<?php
				}
				else{
					// If the user is not logged in, then render the register form.
					?>
						<div class="formContainer">

							<form action="signup-conf.php" id='rlform' method="POST">
								<label for="name">Name : </label>
								<input type="text" name="name" class="form-control" placeholder="Your Name"  required/>
								
								<br/>

								<label for="email">Email : </label>
								<input type="email" name="email" class="form-control" placeholder="abcd@xyz.com"  required/>

								<br/>

								<label for="password">Password : </label>
								<input type="password" name="password" class="form-control" placeholder="Minimum 6 characters."  required/>

								<br/>

								<label for="phone">Phone No : </label>
								<input type="tel" name="phone" class="form-control" required />

								<br/>

								<label for="type">Are you a/an ________ ?</label>
								<br/>
								<input type="radio" name="type" value="student" required /> <label>Student</label>
								<br/>
								<input type="radio" name="type" value="employer" required /> <label>Employer</label>

								<br/>
								<br/>
								<button type="submit" class="btn btn-primary">Signup</button>
							</form>
						</div>
					<?php
				}
			?>
		</div>
	</main>
</body>
</html>