<?php
	// Page to create an internship for the employer.
	// This page has all the computational logic.
	// If you want to view the actual form that the employer will fill. Check postinternship.php

	session_start();

	require_once('./inc/checkinstall.php');
	require_once("./inc/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - Posting Internship
	</title>
	<?php include './fragments/head.html'; ?>
</head>
<body>
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>

		<div class="fixedContainer dashboard">
			<?php
				// First checking if the user is logged in and if yes, if they are an employer or not.

				if(!$_SESSION['int_loggedin'] || !$_SESSION['int_userid']){
					// User is not logged in and highly unauthorised to visit this page.

					header("refresh:0;url=./login.php");	// Redirect immediately to the login page.
					exit();
				}

				// Now checking if the user is an employer or not, and also getting all the details about them.

				$user = mysqli_query($db, "SELECT * FROM internshub_users WHERE userid = '".$_SESSION['int_userid']."'");

				$user = mysqli_fetch_assoc($user);

				if(!$user['isemployer']){
					// The user is not authorised to visit this page.

					?>
						<div class="alert alert-danger">
							You are unauthorised to view this page.
						</div>
					<?php

					header("refresh:1.5;url=./user.php");		// Redirect the user to the dashboard.
					exit();
				}

				// If the user is in fact an employer, then render a form for the employer.

				// Save some details to store in the database later.

				$userid = $user['userid'];
				$empname = $user['name'];

				// Checking if the user has entered all the fields required.

				if(	!$_POST['title'] 
					|| !$_POST['details']
					|| !$_POST['start_date']
					|| !$_POST['duration_1']
					|| !$_POST['duration_2']
					|| !$_POST['apply_by']
					|| !$_POST['ninternships']
					|| !$_POST['location']	// No need to check skills as its not a required column.
				){
					?>
						<div class="alert alert-danger">
							All required data not filled. Kindly fill again.
							<br/>
							Redirecting you to the previous page.
						</div>
					<?php

					header("refresh:1.5;url=./postinternship.php");
					exit();	// Stop execution right here.
				}

				// Sanitizing inputs.

				$title = mysqli_real_escape_string($db, $_POST['title']);

				$details = mysqli_real_escape_string($db, $_POST['details']);

				$start_date = mysqli_real_escape_string($db, $_POST['start_date']);

				$duration = mysqli_real_escape_string($db, $_POST['duration_1'])
							." ". mysqli_real_escape_string($db, $_POST['duration_2']);	// Total duration.

				$apply_by = mysqli_real_escape_string($db, $_POST['apply_by']);

				$stipend = mysqli_real_escape_string($db, $_POST['stipend']);

				$location = mysqli_real_escape_string($db, $_POST['location']);

				$ninternships = mysqli_real_escape_string($db, $_POST['ninternships']);

				$skills = mysqli_real_escape_string($db, $_POST['skills']);

				// Validating dates and other fields.

				$today = date("Y-m-d");

				if($start_date < $today 
					|| !preg_match("/^[0-9]{1,3}$/", $ninternships) 
					|| !preg_match("/^[0-9.,\s]{1,12}$/", $stipend)
					|| $apply_by < $today
					|| $apply_by > $start_date
					|| $stipend < 0
				){
					?>
						<div class="alert alert-info">
							Invalid Fields entered. Redirecting back to previous page.
						</div>
					<?php

					header("refresh:1.5;url=./postinternship.php");
					exit();
				}

				// Inserting data into the database. 

				$insertion = mysqli_query($db, 
					"INSERT INTO internshub_internships(
						userid,
						empname,
						title,
						details,
						start_date,
						duration,
						stipend,
						apply_by,
						ninternships,
						location,
						skills_required
					) VALUES (
						'".$userid."',
						'".$empname."',
						'".$title."',
						'".$details."',
						'".$start_date."',
						'".$duration."',
						'".$stipend."',
						'".$apply_by."',
						'".$ninternships."',
						'".$location."',
						'".$skills."'
					)");

				if($insertion){
					// If the internship details are successfully inserted into the database.
					?>
						<div class="alert alert-success">
							Internship created successfully.
							<br/>
							Redirecting you to dashboard.
						</div>
					<?php

					header("refresh:1.5;url=./user.php");
				}
				else{
					?>
						<div class="alert alert-danger">
							The internship details could not be inserted due to some internal server error. Kindly try again.
						</div>
					<?php

					header("refresh:2.5;url=./postinternship.php");
				}
			?>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>