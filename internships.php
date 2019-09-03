<?php
	session_start();
	// Portal to view all the internships on the portal.

	require_once("./inc/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - All Internships
	</title>
	<?php include ("./fragments/head.html"); ?>
</head>
<body>
	<main class="continer-fluid">
		<?php include ("./fragments/header.php"); ?>

		<div class='fixedContainer internships'>
			<?php
				// Getting all the internships, with pagination, with apply_by dates less than today.

				$today = date("Y-m-d");

				$pageno = 1;		// Start with 1.

				$allInternships = mysqli_query($db,
					"SELECT * FROM internshub_internships WHERE apply_by >= '".$today."';"
				);

				$totalInts = mysqli_num_rows($allInternships);		// Total number of internships in the database.

				$intsperpage = 2;		// The number of internships to display on one page.

				// Check if a page no has been passed to the page.

				if($_GET['page'])
					$pageno = $_GET['page'];

				if($pageno <= 0){	// Invalid page number.
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

					$currentPageInts = mysqli_query($db, "SELECT * FROM internshub_internships ORDER BY created DESC LIMIT ".$intsperpage." OFFSET ". ($pageno-1) * $intsperpage .";");

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
		                					<a href="./internships.php?page=<?php echo $pageno - 1; ?>">
		                						<i class="fas fa-arrow-circle-left fa-lg"></i>
		                					</a>
		                				</li>
		                			<?php
		                		}

		                		if($next){
		                			?>
		                				<li class="next">
		                					<a href="./internships.php?page=<?php echo $pageno + 1; ?>">
		                						<i class="fas fa-arrow-circle-right fa-lg"></i>
		                					</a>
		                				</li>
		                			<?php
		                		}
		                	?>
		                </ul>

		                <br/>

		                <div class="bottomLine"></div>
		                
		                <br/>

		                That's all folks!
		            </div>

	                <?php 
				}
			?>
		</div>

		<?php
			include("./fragments/footer.html"); // Footer
		?>
	</main>
</body>
</html>