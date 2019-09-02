<?php
	// Fragment to display the header component of the web app.
?>
<header id='header'>
	<div class='fixedContainer row'>
		<div class="col-6">

			<!--
				Part of the header that is to be shown only when the user is using a device with a small screen.
			-->

			<div id='sidenavContainer'>
				<span onclick="openSN()" class='sidenavOpener'><i class="fas fa-bars fa-lg"></i></span> &nbsp;&nbsp;
				<div id="sidenav">
					
					<div class='sidenavcloser' onclick="closeSN()">&times;</div>

					<a href="internships.php">Internships</a>
					<?php
						if(!$_SESSION['int_loggedin']){
							?>
								<a href="login.php" title="Login" aria-label="Login">Login</a>
								<a href="signup.php" title="Signup" aria-label="Signup as Student">Register</a>
							<?php
						}
						else{
							// If the user is logged in, either as a student or an employer.
							?>
								<a href="logout.php" title="Logout" aria-label="Logout">Logout</a>
							<?php
						}
					?>
					<a href="contactus.php">Contact</a>
				</div>
			</div>

			<!-- Logo or Name of App -->

			<span class='logo'>
				<a href='./' title="Home">
					<?php
						echo $config['appname'];
					?>
				</a>
			</span>
		</div>
		<div class="col-6">

			<div id="menuContainer">
				<a href="internships.php" title="View All Internships">Internships</a>

				&nbsp;
				&nbsp;

				<a href="login.php" title="Login">Login</a>
				
				&nbsp;
				&nbsp;

				<a href="signup.php" title="Register">Register</a>
			</div>

		</div>
	</div>
</header>