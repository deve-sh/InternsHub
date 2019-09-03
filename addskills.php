<?php
	// Page to add skills to a user's profile.
	// This is a page that has both the display and computational logic in the same page.
	
	session_start();

	include './inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - Add Skills
	</title>

	<?php include './fragments/head.html'; ?>
</head>
<body>
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>
		<div class="fixedContainer dashboard">
			<?php
				// First checking if the user is logged in.

				if($_SESSION['int_loggedin'] && $_SESSION['int_userid']){
					if($_POST['skills']){
						// If the page is being used to submit data.

						// Sanitizing the input.

						$skills = mysql_real_escape_string($_POST['skills']);

						$updation = mysqli_query($db, "UPDATE internshub_users SET skills = '".$skills."' WHERE userid = '".$_SESSION['int_userid']."'");

						if($updation){
							// If the updation was successful.

							?>
								<div class="alert alert-success">
									Skills Updated Successfully. Redirecting you to Dashboard.
								</div>
							<?php

							header("refresh:1.5;url=./user.php");
							exit();
						}
						else{
							?>
								<div class="alert alert-danger">
									Skills could not be updated due to some server error. Kindly try again.
								</div>
							<?php

							header("refresh:1.5;url=./user.php");
							exit();
						}

					}
					else{
						// If not, then show the form to submit the skills.

						// First getting the skills of the user that they have already filled in and filling it in the textarea upcoming.

						$user = mysqli_query($db, "SELECT * FROM internshub_users WHERE userid = '".$_SESSION['int_userid']."'");

						$user = mysqli_fetch_assoc($user);

						$skills = $user['skills'];

						?>
						<br/>
						<form action="addskills.php" method="POST">
							<h3>Add Skills</h3>

							<p>
								Enter your skills comma seperated.	
							</p>
							
							<textarea placeholder="Enter your skills (Comma Seperated)" class="form-control skillsform" name="skills" required><?php echo $skills; ?></textarea>
							<br/>

							<button type="submit" class="btn btn-primary">Update</button>
						</form>
						<?php
					}
				}
				else{
					?>
						<div class="alert alert-danger">
							Kindly Login first.
						</div>
					<?php
					header("refresh:1.5;url=./login.php");
				}
			?>
		</div>
		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>