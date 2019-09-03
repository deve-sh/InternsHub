<?php
	// Page that serves as the user dashboard.
	// It serves different views depending on the fact that the current user is a student or an employer.
	session_start();
	require_once("./inc/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];
		?> - Dashboard
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
					// User is not logged in.

					header("refresh:0;url=./login.php");
					exit();
				}
				
				// This block of code will be reached only if the user is logged in.

				// Checking if the user is an employer or not.
				// If the user is an employer, they will only see the internships they have created and the option to create a new internship.
				// If the user is a student, they will only see the option to view the internships they have applied to and.


				$user = mysqli_query($db,
					"SELECT * FROM internshub_users WHERE userid = '".$_SESSION['int_userid']."'"
				);		// Getting the user from the database.

				$user = mysqli_fetch_assoc($user);	// Getting the user object as an iterable array of key value pairs.

				echo "<br/>Welcome ".$user['name'];

				if($user['isemployer'] == 1){
					// If the user is an employer.

					// Rendering the employer's view.

					?>
						<br/>
						<br/>

						<div class="user-options" align="center">
							<div class='user-option'>
								<a href="./postinternship.php">
									<i class="fas fa-plus fa-lg"></i> &nbsp;Create a new Internship
								</a>
							</div>
							
							<br/>
							<br/>

							<div class="user-option">
								<a href="./viewempinternships.php">
									<i class="fas fa-book fa-lg"></i> &nbsp;View all your created Internships
								</a>
							</div>

							<br/>
							<br/>

							<div class="user-option">
								<a href="./viewapplicants.php">
									<i class="fas fa-copy fa-lg"></i> &nbsp;View Applications
								</a>
							</div>
						</div>
					<?php
				}
				else{
					// If the user is a student.

					?>
						<br/>
						<br/>

						<div class="user-options" align="center">
							<div class="user-option">
								<a href="viewapplications.php">
									<i class="fas fa-book fa-lg"></i> &nbsp;View all your Applications.
								</a>
							</div>
						</div>

						<div class="user-options" align="center">
							<div class="user-option">
								<a href="addskills.php">
									<i class="fas fa-star fa-lg"></i> &nbsp;Add / Update your Skills.
								</a>
							</div>
						</div>
					<?php
				}
			?>

			<div align="center">
                <br/>

                <div class="bottomLine"></div>
                
                <br/>

                Nothing more here. ;)

                <?php 
                	if(!$user['isemployer']){
                		?>
                			Keep Searching!
                		<?php
                	}
                ?>
            </div>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>