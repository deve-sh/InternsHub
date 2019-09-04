<?php
	// Page for the student to view all their applications to various internships.

	session_start();

	require_once('./inc/config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
		    echo $config['appname'];
		?> - View Applications 
	</title>

	<?php include './fragments/head.html'; ?>
</head>
<body>
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>

		<div class="fixedContainer dashboard">
			<?php
				// Checking if the user is logged in and is not an employer.

				if(!$_SESSION['int_loggedin'] || !$_SESSION['int_userid']){
					// User is not logged in and highly unauthorised to visit this page.

					header("refresh:0;url=./login.php");	// Redirect immediately to the login page.
					exit();
				}

				// Now checking if the user is an employer or not, and also getting all the details about them.

				$user = mysqli_query($db, "SELECT * FROM internshub_users WHERE userid = '".$_SESSION['int_userid']."'");

				$user = mysqli_fetch_assoc($user);

				if($user['isemployer']){
					// The user is not authorised to visit this page.

					?>
						<div class="alert alert-danger">
							Only a student can view this page.
						</div>
					<?php

					header("refresh:1.5;url=./user.php");		// Redirect the user to the dashboard.
					exit();
				}

				// If the user is not an employer, then render their list of applications to internships.

				// Pagination included.

				$allApplications = mysqli_query($db,
					"SELECT * FROM internshub_applications WHERE applicantid='".$_SESSION['int_userid']."';"
				);

				$totalApps = mysqli_num_rows($allApplications);		// Total number of applications in the database.

				$appsperpage = 10;		// The number of applications to display on one page.

				// Check if a page no has been passed to the page.

				if($_GET['page'])
					$pageno = $_GET['page'];

				if($pageno <= 0 || $appsperpage*($pageno-1) >= $totalApps){	// Invalid page number.
					$pageno = 1;
				}

				// Requesting the database for the applications on the current page.

				$pageApplications = mysqli_query($db, 
					"SELECT * FROM internshub_applications 
						WHERE applicantid ='".$_SESSION['int_userid']."'
						ORDER BY created DESC LIMIT ".$appsperpage." OFFSET "
						.($pageno-1)*$appsperpage.";"
				);

				$prev = false;
				$next = false;

				// Rendering each application one by one.

				while($application = mysqli_fetch_assoc($pageApplications)){

					// Getting the details of applicant and the internship.

					$internship = mysqli_query($db,
						"SELECT * FROM internshub_internships WHERE intid = '".$application['intid']."';"
					);

					if($internship){
						$internship = mysqli_fetch_assoc($internship);
					}
					else{
						?>
							<div class="alert alert-danger">
								An error occured. Kindly try again.
							</div>
						<?php

						exit();		// Stop execution here itself.
					}

					// Also getting the number of applications on this internship in order to let the student gauge their competition.

					$nApplications = mysqli_query(
						$db,
						"SELECT * FROM internshub_applications WHERE intid = '".$internship['intid']."'"
					);

					if($nApplications){
						$nApplications = mysqli_num_rows($nApplications);
					}
					else{
						?>
							<div class="alert alert-danger">
								An error occured. Kindly try again.
							</div>
						<?php

						exit();		// Stop execution here itself.
					}

					// Now getting the details of the employer.

					$user = mysqli_query($db,
						"SELECT * FROM internshub_users WHERE userid = '".$application['employerid']."';"
					);

					if($user){
						$user = mysqli_fetch_assoc($user);
					}
					else{
						?>
							<div class="alert alert-danger">
								An error occured. Kindly try again.
							</div>
						<?php

						exit();		// Stop execution here itself.
					}

					echo "
						<div class='application'>
							<span>
								For : <a href='./internship.php?intid=".$internship['intid']."'>
										<span class='int-title'>".$internship['title']."</span>
									  </a>
							</span>
							
							<br/>

							<span>
								<span class='int-username'>".$user['name']."</span>
							</span>

							<br/>
							
							<span class='created'>
								".$application['created']."
							</span>

							No Of Applicants : ".$nApplications."

							<br/>
							<br/>

							<a href='./application.php?appid=".$application['appid']."'>
								<button class='btn btn-info'>
									View All Details
								</button>
							</a>
						</div><br/>
					";
				}
			?>

			<?php

				// Now checking if there is a further page to display.

				if($pageno*$appsperpage > $appsperpage && $totalApps > $appsperpage)
                    $prev = true;

                if($pageno*$appsperpage < $totalApps)
                    $next = true;

                // Displaying the pagination buttons.

                ?>

                <div align="center">
	                <ul class="pager">
	                	<?php
	                		if($prev){
	                			?>
	                				<li class='previous'>
	                					<a href="./viewapplications.php?page=<?php echo $pageno - 1; ?>">
	                						<i class="fas fa-arrow-circle-left fa-lg"></i>
	                					</a>
	                				</li>
	                			<?php
	                		}

	                		if($next){
	                			?>
	                				<li class="next">
	                					<a href="./viewapplications.php?page=<?php echo $pageno + 1; ?>">
	                						<i class="fas fa-arrow-circle-right fa-lg"></i>
	                					</a>
	                				</li>
	                			<?php
	                		}
	                	?>
	                </ul>
	                <br/>
	            </div>
		    <?php
		    ?>

			<div align="center">
				<div class="bottomLine"></div>
			</div>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>