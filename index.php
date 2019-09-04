<?php
	session_start();
	require_once("./inc/config.php");		// Configuration File.
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php
			echo $config['appname'];	// Change your appname in the config.php file.
		?>
	</title>
	<?php include ("./fragments/head.html"); ?>
</head>
<body>
	<main class="container-fluid">
		<!-- Bootstrap's container-fluid to keep the section responsive. -->

		<?php include './fragments/header.php'; ?>

		<div class="introPage">
			<div class="fixedContainer firstRow row">
				<div class="col-md-6">
					<img 
						src="./files/propel.svg" 
						alt="Propel your career!" 
						class="responsiveImage morepadding" 
					/>
				</div>
				<div class="col-md-6 textColumn">
					<h3>
						Propel Your Career
					</h3>
					<br/>
					<p>
						In a world that screams EXPERIENCE even before your first job! We are the ones that come in handy!
					</p>

					<p>
						Well, we help students find internships that matter, that help them move forward, and most importantly, get them the experience they need!
					</p>

					<br/>

					<p class="alignCenter-md">
						<a href="./internships.php">
							<button class="btn btn-info">
								View Internships
							</button>
						</a>
					</p>
				</div>
			</div>
			<div class="secondRow">
				<div class="fixedContainer">
					<div class="row">
						<div class="col-md-6 textColumn">
							<h3>
								Unleash your creative side!
							</h3>

							<br/>

							<p>
								<?php
									echo $config['appname'];
								?> provides a perfect lauch pad to showcase your skills and interests with potential employers.
							</p>

							<p>
								Just sign up and then you can apply to as many internships as you may want. The employer will contact you in case they like your application based on your contact details.
							</p>

							<br/>

							<p class="alignCenter-md">
								<a href="./login.php">
									<button class="btn btn-primary">
										Signup
									</button>
								</a>

								&nbsp;

								<a href="./signup.php">
									<button class="btn btn-info">
										Login
									</button>
								</a>
							</p>
						</div>
						<div class="col-md-6">
							<img 
								src="./files/creativity.svg"
								alt="Unleash your creative side!"
								class="responsiveImage"
							/>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include './fragments/footer.html'; ?>
	</main>
</body>
</html>