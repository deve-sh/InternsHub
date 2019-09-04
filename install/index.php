<?php
	// Route to install the web application without the user having to do anything.
	session_start();

	require_once("./installchecker.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Install App
	</title>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="author" content="Devesh Kumar">
	<meta name="description" content="A Web App to find Internships.">
	<meta name="HandheldFriendly" content="True">		<!-- Responsive -->

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="../styles/styles.css" />
</head>
<body>
	<main class="container-fluid">
		<header id="header">
			<div class="fixedContainer row">
				<div class="col-12">
					Install Web App
				</div>
			</div>
		</header>

		<div class="fixedContainer">
			<br/>
			<form class="installForm" method="POST" action="installer.php">
				<h3>Install App</h3>

				<p>
					Only MySQLi Databases supported.
				</p>

				<br/>

				<label for="appname">
					Application Name :
				</label>

				<input 
					type="text" 
					class="form-control" 
					placeholder="Give your app a name." 
					name="appname" 
					required
				/>

				<br/>

				<label for='dbhost'>
					Database Host : 
				</label>
				<input 
					type="text" 
					class="form-control" 
					name="dbhost" 
					placeholder="The Server your database is hosted on." 
					required/>

				<br/>

				<label for='dbuser'>
					Database User : 
				</label>
				<input 
					type="text" 
					class="form-control" 
					name="dbuser" 
					placeholder="The user that controls your database." 
					required/>

				<br/>

				<label for='dbpass'>
					Database User Password : 
				</label>
				<input 
					type="password" 
					class="form-control" 
					name="dbpass" 
					placeholder="Can be empty too." 
					/>

				<br/>

				<label for="dbname">
					Database Name : 
				</label>
				<input 
					type="text" 
					class="form-control" 
					name="dbname" 
					placeholder="The database where the tables are to be created." 
					required
				/>

				<br/>

				<button class="btn btn-primary" type="submit">Install</button>
			</form>
		</div>
		<?php include '../fragments/footer.html'; ?>
	</main>
</body>
</html>