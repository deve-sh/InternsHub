<?php
	// Page for a user to confirm their signup.

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
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>

		<div class="fixedContainer">
			<?php
				// First checking if the user is not logged in.

				if($_SESSION['int_loggedin'] && $_SESSION['int_userid']){
					?>
						<div class="alert alert-info">
							You need to be logged out in order to sign up.
							<br/>
							You are being redirected to logout page.
						</div>
					<?php

					header("refresh:1.5;url=./logout.php");
					exit();
				}

				// Checking if the data required to signup has been sent.

				if(!$_POST['name'] || !$_POST['email'] || !$_POST['password'] || !$_POST['phone'] || !$_POST['type']){
					// Some info is missing.

					?>
					<div class="alert alert-danger">
						All requested data not sent.
					</div>
					<?php

					header("refresh:1.5;url=./signup.php");
					exit();
				}
				else{

					// Performing some validations.

					// Checking if the email is valid.

					$emailValid = (
						!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_POST['email'])
					) ? false : true;

					// Checking if the password is valid.

					$passwordValid = (
						strlen($_POST['password'])>=6
					)?true : false;

					// Checking if the phone no is valid. Minimally, it should only check if the phone number contains a character or is of an invalid length.

					$phoneValid = (
						preg_match("/^[-+*#\d]{8,14}$/", $_POST['phone'])
						&& (
							strlen($_POST['phone']) >= 8 && 
							strlen($_POST['phone']) <= 14)
						) ? true:false;

					// Checking if the name is invalid. Name cannot contain numbers.

					$nameValid = (!preg_match("/[0-9]/", $_POST['name'])) ? true : false;

					if(!$emailValid || !$passwordValid || !$phoneValid || !$nameValid){
						// If even one of the inputs is invalid.
						?>
							<div class="alert alert-danger">
								Invalid Inputs Entered. Kindly re-enter.
							</div>
						<?php
						header("refresh:1.5;url=./signup.php");
						exit();
					}

					// Sanitizing all inputs in order to avoid SQL Injections.

					$email = mysql_real_escape_string($_POST['email']);

					$password = mysql_real_escape_string($_POST['password']);

					$name = mysql_real_escape_string($_POST['name']);

					$phone = mysql_real_escape_string($_POST['phone']);

					$type = mysql_real_escape_string($_POST['type']);

					// Now time to check if a user with the provided email already exists in the database.

					$userValidation = mysqli_query($db, "SELECT * FROM internshub_users WHERE email = '".$email."'");

					if(mysqli_num_rows($userValidation) > 0){
						?>
							<div class="alert alert-info">
								Another user with the given email already exists. Kindly try another email.
							</div>
						<?php
						header("refresh:1.5;url=./signup.php");
						exit();
					}

					// If the user doesn't exist in the db. Then insert the new details.

					// Hashing the password that is passed.

					$hashedpass = password_hash($password, PASSWORD_BCRYPT);	// Hash the password using the CRYPT_BLOWFISH algorithm.

					$today = date("Y-m-d");		// Getting today's date.

					$isEmployer = (strcmp(strtolower($type),"employer") == 0) ? 1 : 0;

					$insertion = mysqli_query($db,
						"INSERT INTO internshub_users(
							name,
							email,
							password,
							phone,
							joined,
							isemployer,
							skills
						) VALUES (
							'".$name."',
							'".$email."',
							'".$hashedpass."',
							'".$phone."',
							'".$today."',
							'".$isEmployer."',
							''
						)");

					if($insertion){
						// If the insertion was successful.
						?>
							<div class="alert alert-success">
								User Successfully Registered. You will be redirected to the login page.
							</div>
						<?php
						header("refresh:1.5;url=./login.php");
						exit();
					}
					else{
						// If there was a server error or some other problem.

						?>
							<div class="alert alert-danger">
								Sorry, some problem occurred during the registration. Kindly try again.
								You will be redirected to the registration page.
							</div>
						<?php
						header("refresh:1.5;url=./signup.php");
						exit();
					}
				}
			?>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>