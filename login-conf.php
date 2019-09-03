<?php
	// Page for a user to confirm their login.

	session_start();

	require_once('./inc/config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config["appname"];
		?> - Logging In
	</title>

	<?php include ('./fragments/head.html'); ?>
</head>
<body>
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>

		<div class="fixedContainer">
			<?php
				// Checking if the user is not already logged in.

				if($_SESSION['int_loggedin'] && $_SESSION['int_userid']){
					?>
						<div class="alert alert-info">
							Already logged in.
						</div>
					<?php

					header("refresh:1.5;url=./user.php");	// Redirect to user dashboard.
					exit();
				}

				// Now checking if the required parameters (email and password) have been passed.

				if(!$_POST['email'] || !$_POST['password']){
					?>
						<div class="alert alert-danger">
							Kindly submit all required parameters.
						</div>
					<?php

					header("refresh:1.5;url=./login.php");
					exit();
				}

				// Sanitizing all the inputs to avoid SQL Injection.

				$email = mysql_real_escape_string($_POST['email']);
				$password = mysql_real_escape_string($_POST['password']);

				// No need to validate the inputs. 
				// If they are wrong, they will automatically not match any entry in the DB,
				// as the data inserted in the DB is validated before enty.

				// Checking if a user with the email exists.

				$userOb = mysqli_query($db, "SELECT * FROM internshub_users WHERE email = '".$email."'");

				if(mysqli_num_rows($userOb) == 1){
					// User with the email exists.
					// Now getting its hashed password and comparing it with the password the user has entered.

					$user = mysqli_fetch_assoc($userOb);

					$hashedPass = $user['password'];

					if(password_verify($password, $hashedPass)){
						// If the hashes match.

						// Set the session variables required to keep the user signed in.

						$_SESSION['int_loggedin'] = true;
						$_SESSION['int_userid'] = $user['userid'];


						?>
							<div class="alert alert-success">
								Successfully signed in.
								<br/>
								Redirecting you to your dashboard in a second.
							</div>
						<?php

						header("refresh:1.5;url=./user.php");
						exit();
						
					}
					else{
						// If the password doesn't match.

						?>
							<div class="alert alert-info">
								Invalid Credentials. Kindly retry.
							</div>
						<?php

						header("refresh:1.5;url=./login.php");
						exit();
					}
				}
				else{
					?>
						<div class="alert alert-danger">
							No user with the given email found in the database.
							<br/>
							Redirecting you back to login page.
						</div>
					<?php

					header("refresh:1.5;url=./login.php");
					exit();
				}
			?>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>