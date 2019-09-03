<?php
	// Internship displaying page.
	session_start();

	require_once('./inc/config.php');

	$intid = $_GET["intid"];

	if(!$intid){
		// If no internship is asked for.
		// Then redirect the user to the internships page.

		header("refresh:0;url=internships.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - Internship
	</title>
	<?php include './fragments/head.html'; ?>
</head>
<body>
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>
		
		<div class="fixedContainer internshipPage">
			<?php
				$internship = mysqli_query($db, "SELECT * FROM internshub_internships WHERE intid = '".$intid."'");

				if(mysqli_num_rows($internship) == 0){
					// No internship with the specified itnernship id found.
					// In that case, redirect the user to the internships page after displaying the error message.

					?>
						<div class="alert alert-danger">
							No Such Internship Found.
						</div>
					<?php

					header("refresh:1.5;url=./internships.php");
					exit();
				}
				else{
					// Rendering the internship.

					$internship = mysqli_fetch_assoc($internship);

					echo "<div class='int-title'>".$internship['title']."</div>";
					echo "<div class='int-empname'>".$internship['empname']."</div><br/>";
					echo "<div class='int-location'>Location(s) : ".$internship['location']."</div><br/>";

					echo "<strong><u>Details</u></strong> : <br/><br/>";
					echo "<pre class='int-description'>".$internship['details']."</pre><br/><br/>";

					echo "<div class='row int-details'>";

					echo "
					<div class='col-3'>
						<span class='fieldname'>
							Start Date
						</span>
						<br/>
						<span>
							".$internship['start_date']."
						</span>
					</div>

					<div class='col-3'>
						<span class='fieldname'>
							Duration
						</span>
						<br/>
						<span>
							".$internship['duration']."
						</span>
					</div>

					<div class='col-3'>
						<span class='fieldname'>
							Stipend
						</span>
						<br/>
						<span>";

					if($internship['stipend'] <= 0)
						echo "Unpaid";
					else
						echo $internship['stipend'];

					echo "</span>
					</div>

					<div class='col-3'>
						<span class='fieldname'>
							Apply By
						</span>
						<br/>
						<span>
							".$internship['apply_by']."
						</span>
					</div>";

					echo "</div><br/>";

					echo "<strong>No. Of Internships </strong>: ".$internship['ninternships']."<br/><br/>";

					if(strlen($internship['skills_required']) != 0)
						echo "<strong>Skill(s) Required </strong>: ".$internship['skills_required']."";

					// Now checking if the one viewing the page can apply or not.

					if($_SESSION['int_loggedin'] && $_SESSION['int_userid']){
						// If the user is logged in.

						// First checking if the user is an employer.

						$user = mysqli_query($db, 
							"SELECT * FROM internshub_users WHERE userid = '".$_SESSION['int_userid']."'");

						if(mysqli_num_rows($user) == 0){
							// Invalid User.
							// Session's been tampered with.

							header("refresh:0;url=./logout.php");
							exit();
						}
						else{
							$user = mysqli_fetch_assoc($user);

							if($user['isemployer'] == 0){
								// If the user is not an employer.

								// Now checking if the user has already applied for the internship.

								$validation = mysqli_query($db, 
									"SELECT * FROM internshub_applications
										WHERE applicantid = '".$_SESSION['int_userid']."'
										AND intid = '".$intid."'");
								
								if($_SESSION['int_userid'] != $internship['userid']){
									
									if(mysqli_num_rows($validation) == 0){

										// If the user hasn't applied to the internship. Then show the apply button.

										echo "<br/>
										<div align='center'>
											<a href='./apply.php?intid=".$intid."'>
												<button class='btn btn-primary'>Apply</button>
											</a>
										</div>";
									}
									else{
										echo "
										<div align='center'>
											<button class='btn btn-info' disabled>Already Applied</button>
										</div>";
									}
								}

							}

						}
					}
					else{
						// If the user is not logged in. Then show a login to apply button.

						echo "<br/><br/>
						<div align='center'>
							<a href='./login.php'><button class='btn btn-info'>Login to Apply</button></a>
						</div>
						<br/>";
					}
				}
			?>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>