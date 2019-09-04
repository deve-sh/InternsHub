<?php
	// Page to display all the details of an application.
	// Only the user that has applied to the internship and the employer who created the internship can view this page.

	session_start();
	require_once('./inc/checkinstall.php');
	require_once("./inc/config.php");

	$appid = $_GET['appid'];

	if(!$appid){
		// If no appid has been passed. Redirect to applications page.

		header("refresh:0;url=user.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - Application
	</title>

	<?php include './fragments/head.html'; ?>
</head>
<body>
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>

		<div class="fixedContainer dashboard">
			<?php
				// First checking if the user is logged in.

				if(!$_SESSION['int_loggedin'] || !$_SESSION['int_userid']){
					?>
						<div class="alert alert-info">
							Kindly login first.
						</div>
					<?php
					header("refresh:1.5;url=./login.php");
					exit();		// Stop execution.
				}

				// Now checking if the user is an employer.

				$user = mysqli_query($db,
					"SELECT * FROM internshub_users WHERE userid='".$_SESSION['int_userid']."'"
				);

				if(!$user){
					// Unsuccessful Query.

					?>
						<div class="alert alert-info">
							An error occured during fetching data.
						</div>
					<?php
					exit();
				}

				$user = mysqli_fetch_assoc($user);

				// ------------------------------------------
				// Now checking if the employer is the creator of the internship.
				// ------------------------------------------

				// First, getting the details of the application from the appid passed to the page.

				$application = mysqli_query($db,
					"SELECT * FROM internshub_applications WHERE appid = '".$appid."'"
				);

				if(!$application || mysqli_num_rows($application) <= 0){
					?>
						<div class="alert alert-info">
							An error occured during fetching data ( OR) Invalid Application.
						</div>
					<?php

					exit();
				}

				$application = mysqli_fetch_assoc($application);

				if($_SESSION['int_userid'] != $application['employerid'] 
					&& $_SESSION['int_userid'] != $application['applicantid']
				){

					// Current User ID and application's employerid do not match.

					?>
						<div class="alert alert-danger">
							You are not authorised to view this page.
						</div>
					<?php

					header("refresh:1.5;url=./user.php");
					exit();
				}

				// Now all validations done. Getting the applicant's details as well.

				$applicant = mysqli_query(
					$db,
					"SELECT * FROM internshub_users WHERE userid = '".$application['applicantid']."'"
				);

				if(!$applicant || mysqli_num_rows($applicant) <= 0){
					?>
						<div class="alert alert-info">
							Invalid UserID. (Or) An Error Occured during fetching data.
						</div>
					<?php

					exit();
				}

				$applicant = mysqli_fetch_assoc($applicant);

				// Now getting the data of the internship.

				$internship = mysqli_query(
					$db,
					"SELECT * FROM internshub_internships WHERE intid = '".$application['intid']."'"
				);

				if(!$internship || mysqli_num_rows($internship) <= 0){
					?>
						<div class="alert alert-info">
							Invalid Internship. (Or) An Error Occured during fetching data.
						</div>
					<?php

					exit();
				}

				$internship = mysqli_fetch_assoc($internship);

				// Now we have both the application's data, the internship's data and the user's data.

				echo "
					<div class='applicationPage'>
						<br/>
						<h3>
							<a href='./internship.php?intid=".$application['intid']."'>
								".$internship['title']."
							</a>
						</h3>

						<p>
							<span class='created'>
								".$application['created']."
							</span>
						</p>

						<p>
							<strong>Applicant Name </strong>: ".$applicant['name']."
						</p>

						<div class='row'>
							<div class='col-sm-6 contactdetails'>
								<i class=\"fas fa-envelope\"></i>
								 &nbsp;
								<a href='mailto:".$applicant['email']."'>
								".$applicant['email']."
								</a>
							</div>
							<div class='col-sm-6 contactdetails'>
								<i class=\"fas fa-phone\"></i>
								 &nbsp;
								<a href='tel:".$applicant['phone']."'>
								".$applicant['phone']."
								</a>
							</div>
						</div>

						<br/><br/>

						<strong>Details</strong> : 

						<pre class='int-description'>".$application['details']."</pre>

						<br/>

						";


						if(strlen($applicant['skills']) > 0){
							echo "
							<strong>
								Applicant Skillset
							</strong> : ".$applicant['skills']."";
						}

					echo "	
					</div>
				";
			?>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>