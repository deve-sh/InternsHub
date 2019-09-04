<?php
	// Page to view all the internships created by an employer

	session_start();

	require_once('./inc/checkinstall.php');
	require_once('./inc/config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - Employer Internships
	</title>
	<?php include './fragments/head.html'; ?>
</head>
<body>
	<main class="container-fluid">
		<?php include './fragments/header.php'; ?>

		<div class="fixedContainer dashboard">
			<?php
				// Checking if the user is logged in.

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

				$allInternships = mysqli_query($db,
					"SELECT * FROM internshub_internships WHERE userid='".$_SESSION['int_userid']."';"
				);

				$totalInts = mysqli_num_rows($allInternships);		// Total number of internships in the database.

				$intsperpage = 10;		// The number of internships to display on one page.

				// Check if a page no has been passed to the page.

				if($_GET['page'])
					$pageno = $_GET['page'];

				if($pageno <= 0 || ($pageno-1)*$intsperpage >= $totalInts){	// Invalid page number.
					$pageno = 1;
				}

				if($totalInts <= 0){
					// If no internships have been posted yet.

					?>

					<div align="center" style="margin: 9.75rem 0;">
						<!-- Position this at almost the center of the screen. -->
						<div class="roundedIcon">
							<i class="far fa-folder-open fa-4x"></i>
						</div>
						<br/>
						<br/>
						No Internships found.
					</div>

			<?php
				}
				else{
					// If there are internships then render then all of them one by one.

					$currentPageInts = mysqli_query($db, "SELECT * FROM internshub_internships WHERE userid ='".$_SESSION['int_userid']."' ORDER BY created DESC LIMIT ".$intsperpage." OFFSET ". ($pageno-1) * $intsperpage .";");

					// Variables that decide whether there is a next or previous page.

					$prev = false;
					$next = false;

					echo "<br/>";

					while($internship = mysqli_fetch_assoc($currentPageInts)){
						// Render each internship one by one.

						echo "
						<div class='internship'>
							<div class='int-title'>
								<a href='./internship.php?intid=".$internship['intid']."'>".$internship['title']."</a>
							</div>
							<div class='empname'>
								".$internship['empname']."
							</div>
							<div class='location'>
								Location(s) : ".$internship['location']."
							</div>
							<br/>
							<div class='row int-details'>
								<div class='col-sm-4'>
									Duration : ".$internship['duration']."
								</div>
								<div class='col-sm-4'>
									Start Date : ".$internship['start_date']."
								</div>
								<div class='col-sm-4'>
									Stipend : ";

							if($internship['stipend'] <= 0)
								echo "Unpaid";
							else
								echo $internship['stipend'];

						echo "
								</div>
							</div>
						</div>
						<br/>";
					}

					// Now checking if there is a further page to display.

					if($pageno*$intsperpage > $intsperpage && $totalInts > $intsperpage)
	                    $prev = true;

	                if($pageno*$intsperpage < $totalInts)
	                    $next = true;

	                // Displaying the pagination buttons.

	                ?>

	                <div align="center">
		                <ul class="pager">
		                	<?php
		                		if($prev){
		                			?>
		                				<li class='previous'>
		                					<a href="./viewempinternships.php?page=<?php echo $pageno - 1; ?>">
		                						<i class="fas fa-arrow-circle-left fa-lg"></i>
		                					</a>
		                				</li>
		                			<?php
		                		}

		                		if($next){
		                			?>
		                				<li class="next">
		                					<a href="./viewempinternships.php?page=<?php echo $pageno + 1; ?>">
		                						<i class="fas fa-arrow-circle-right fa-lg"></i>
		                					</a>
		                				</li>
		                			<?php
		                		}
		                	?>
		                </ul>

		                <div class="bottomLine"></div>
		                <br/>
		            </div>
		    <?php
		       }

           ?>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>