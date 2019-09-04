<?php
	// Page for the employer to post an internship.

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
		?> - Post Internship
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

				?>
					<br/>
					<form action="pi-conf.php" method="POST">

						<h3>Post Internship</h3>
						
						<br/>

						<p>
							Enter all the details required below and your internship will be created in no time, and will be ready for students to apply to.
						</p>

						<label for='title'>
							Internship Title :
						</label>
						<input 
							type="text"
							name="title"
							class="form-control"
							placeholder="Give a suitable name."
							required/>

						<br/>

						<label for='details'>
							Details :
						</label>
						<textarea 
							class="form-control" 
							required 
							placeholder="Give a detailed description of the Internship." 
							name='details'></textarea>

						<br/>

						<div class="row">
							<div class="col-sm-6 nopadding">
								<br/>
								<label for="start_date">
									Start Date : 
								</label>
								<input 
									type="date" 
									class="form-control" 
									required 
									name="start_date" 
									min = <?php echo date("Y-m-d"); ?>>
							</div>
							<div class="col-sm-6 nopadding">
								<br/>
								<label for="duration">
									Duration :
								</label>

								<div class="row">
									<div class="col-4 nopadding">
										<input 
											type="number" 
											class="form-control"
											name="duration_1" 
											min="1"
											placeholder="0-20" 
											max="20" 
											required/>
									</div>

									<div class="col-8 nopadding">
										<select class="form-control" name="duration_2">
											<option selected value="Month(s)">
												Month(s)
											</option>
											<option value="Week(s)">
												Week(s)
											</option>
										</select>
									</div>

								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 nopadding">
								<br/>
								<label for="apply_by">
									Apply By :
								</label>
								<input 
									type="date"
									class="form-control"
									min="<?php echo date("Y-m-d"); ?>"
									name="apply_by" 
									required />
							</div>
							<div class="col-sm-6 nopadding">
								<br/>
								<label for="ninternships">
									Number of Internships : 
								</label>
								<input
									type="number" 
									class="form-control" 
									name="ninternships" 
									min="1"
									required
									placeholder="Minimum 1." />
							</div>
						</div>

						<br/>

						<label for="stipend">
							Stipend : 
						</label>
						<input 
							type="number" 
							class="form-control" 
							name="stipend"
							min="0" 
							placeholder="Enter the amount per week/month (0 -> Unpaid)" 
							required/>

						<br/>

						<label for="location">
							Location(s) :
						</label>

						<input type="text" 
							class="form-control" 
							name="location" 
							placeholder="Work From Home / Location(s)"
							required />

						<br/>

						<label for="skills">
							Skills Required : 
						</label>
						<input
							type="text" 
							class="form-control" 
							name="skills" 
							placeholder="Enter a comma seperated list of skills." />

						<br/>

						<div align="center">
							<button class="btn btn-primary" type="submit">
								Post Internship
							</button>
							&nbsp;
							<a href="./user.php">
								<button class="btn btn-info">
									Back
								</button>
							</a>
						</div>
					</form>
				<?php
			?>
		</div>
		<?php
			include './fragments/footer.html';
		?>
	</main>
</body>
</html>