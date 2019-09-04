<?php
	// Page for a user to apply to an internship.
	// This page is dual-functioning. I. E: It acts as the view and the computer.

	session_start();

	require_once('./inc/checkinstall.php');
	require_once("./inc/config.php");

	$intid = $_GET['intid'];

	if(!$intid){
		// If no internship id has been passed for the page.

		header("refresh:0;url=./");		// Redirect home without any delay.
		exit();			// Stop executing.
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - Apply
	</title>

	<?php
		include './fragments/head.html';
	?>
</head>
<body>
	<main class="container-fluid">

		<?php
			include './fragments/header.php';
		?>

		<div class="fixedContainer dashboard">
			<?php
				// First checking if the user is logged in.

				if(!$_SESSION['int_loggedin'] || !$_SESSION['int_userid']){
					?>
						<div class="alert alert-info">
							Kindly login in order to apply for an internship.
						</div>
					<?php

					header("refresh:1.5;url=./login.php");
					exit();
				}

				// Getting the details of the user and the internship.

				$user = mysqli_query(
					$db,
					"SELECT * FROM internshub_users WHERE userid = '".$_SESSION['int_userid']."'"
				);

				$internship = mysqli_query(
					$db,
					"SELECT * FROM internshub_internships WHERE intid = '".$intid."'"
				);

				if(!$user
					|| !$internship 
					|| mysqli_num_rows($internship) <= 0
					|| mysqli_num_rows($user) <= 0
				){
					?>
						<div class="alert alert-danger">
							Some error occured fetching details. (OR) Invalid UserId or Internship.
						</div>
					<?php

					exit();
				}

				$user = mysqli_fetch_assoc($user);
				$internship = mysqli_fetch_assoc($internship);

				// Checking if the user is an employer.

				if($user['isemployer']){
					?>
						<div class="alert alert-info">
							An employer cannot apply to an internship.
						</div>
					<?php
					header("refresh:1.5;url=./user.php");
					exit();
				}

				// Now checking if the user has already not applied to the internship.

				$validator = mysqli_query(
					$db,
					"SELECT * FROM internshub_applications WHERE applicantid = '".$user['userid']."' AND intid = '".$internship['intid']."';"
				);

				if(!$validator){
					?>
						<div class="alert alert-danger">
							Some error occured fetching details.
						</div>
					<?php

					exit();
				}

				if(mysqli_num_rows($validator) > 0){
					?>
						<div class="alert alert-info">
							You have already applied to this internship. Redirecting to dashboard.
						</div>
					<?php

					header("refresh:1.5;url=./user.php");
					exit();
				}

				// Now checking if the user is posting data or submitting a form.

				if($_POST['details']){
					// If the user has submitted the form.

					// Sanitizing input.

					$details = mysqli_real_escape_string($db, $_POST['details']);

					$employerid = $internship['userid'];

					$applicantid = $user['userid'];

					$insertion = mysqli_query(
						$db,
						"INSERT INTO internshub_applications(
							intid,
							employerid,
							applicantid,
							details
						)
						VALUES(
							'".$intid."',
							'".$employerid."',
							'".$applicantid."',
							'".$details."'
						);"
					);

					if($insertion){
						?>
							<div class="alert alert-success">
								Congrats! Successfully Applied to the Internship!
								<br/>
								Redirecting you to your dashboard.
							</div>
						<?php

						header("refresh:1.5;url=./user.php");
						exit();
					}
					else{
						?>
							<div class="alert alert-success">
								Some error occured while applying for the internship. Kindly try again.
							</div>
						<?php
					}
				}
				else{
					// Render the form to submit the applicant details.

					?>
						<form action="" method="POST">
							<br/>
							<h3>
								Apply to Internship
							</h3>

							<br/>

							Applying to : <?php echo $internship['title']; ?>

							<br/>
							<br/>

							<label for="details">
								Details about you : 
							</label>

							<textarea
								name="details" 
								placeholder="Tell all the reasons you should be hired for this internship." 
								class="form-control" 
								required></textarea>

							<br/>

							<button 
								class="btn btn-primary" 
								type="submit">
								Apply
							</button>

							&nbsp;

							<a href="./internships.php">
								<span class="btn btn-info">
									Cancel
								</span></a>
							<br/>
						</form>
					<?php
				}
			?>
		</div>

		<?php
			include './fragments/footer.html';
		?>
	</main>
</body>
</html>