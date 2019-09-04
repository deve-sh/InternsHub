<?php
	// Page to actually install the web app.
	session_start();

	require_once('./installchecker.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Installing ...</title>
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
			<div class="fixedContainer">
				Install
			</div>
		</header>
		<div class="fixedContainer">
			<?php
				// Checking if the user has entered all the details or not.

				if(
					   !$_POST['appname']
					|| !$_POST['dbhost']
					|| !$_POST['dbname']
					|| !$_POST['dbuser']
				){

					?>
						<div class="alert alert-danger">
							You haven't entered all the necessary details. Kindly fill the complete form.
						</div>
					<?php
					header("refresh:1.5;url=./");
					exit();	// Stop execution here itself.
				}

				// Sanitizing inputs.

				$config['appname'] = mysql_real_escape_string($_POST['appname']);
				$config['dbhost'] = mysql_real_escape_string($_POST['dbhost']);
				$config['dbname'] = mysql_real_escape_string($_POST['dbname']);
				$config['dbuser'] = mysql_real_escape_string($_POST['dbuser']);
				$config['dbpass'] = mysql_real_escape_string($_POST['dbpass']);

				// Checking if the database credentials are correct or not.

				$db = mysqli_connect($config['dbhost'], $config['dbuser'], $config['dbpass'], $config['dbname']);

				if(!$db || mysqli_connect_errno()){
					?>
						<div class="alert alert-danger">
							Invalid Database Credentials
						</div>
					<?php

					exit();
				}

				// First removing all the comments from the database queries using a regex.
				// $queries -> This variable is defined in installchecker.php.

				$queries = preg_replace("~(--.*)|(((/\\*)+?[\w\W]+?(\\*/)+))~", "", $queries);

				// Now running the queries.

				$querying = mysqli_multi_query($db, $queries);		// Run all the queries at once.

				if(!$querying){
					?>
						<div class="alert alert-info">
							Could not query the database. Kindly try again.
						</div>
					<?php

					header("refresh:3;url=./");
					exit();
				}

				// Now inserting all this data into config.php
				// First creating a string to insert into config.php.

				$configString = "<?php\n\tsession_start();\n";

				foreach ($config as $key => $value) {
					$configString .= "\t\$config[\"".$key."\"] = \"".$value."\";\n";
				}

				$configString .= "\n\t\$db = mysqli_connect(\n\t\t\$config['dbhost'],\n\t\t\$config['dbuser'],\n\t\t\$config['dbpass'],\n\t\t\$config['dbname']\n\t) or die(\"Could not establish connection with database.\");\n";

				$configString .= "?>";

				// Opening the configuration file.

				$configFile = fopen("../inc/config.php", "w");		// Open the file for writing the data.

				if(!fwrite($configFile, $configString)){	// Writing the string we created, to the file.
					?>
						<div class="alert alert-info">
							Installation could not be completed due to some problem. Kindly try again.
						</div>
					<?php

					header("refresh:1.5;url=./");
					exit();
				}

				?>
					<div class="alert alert-success">
						Successfully installed Web App. Redirecting you to your web app.
					</div>
				<?php

				session_destroy();
				
				header("refresh:2;url=../");
				exit();
			?>
		</div>
	</main>
</body>
</html>