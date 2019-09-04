# InternsHub

This is a PHP Web App functionally similar to Internshala.
See it working live [here](#putlinkhere).

## Features

Some features included in the web app are : 

- Clean user interface.
- Fragment Modularity.
- Areas specific to Student and Employers.
- Detailed Database Schema.
- Usage of Core PHP.
- **Pagination.**
- **Self Installation Script included.**
- Secure, as everything (Or at least most of the things) are rendered on the server side using PHP.
- Complete splitting of the styles, scripts and the fragments to avoid bugs that come due to their mixing.

## Rules adhered to.

The following rules were taken into consideration when building the web app : 

- BootStrap is used throughout the web application wherever necessary.
- Only Core PHP was used and no frameworks.
- The application will have 2 kinds of users, student and employer.
- After registering, the employer should be able to post internships, with bare minimum details. Internship posting should be restricted only to an employer and a student as well as a non-registered user, should not be allowed.
- There should be a page which should display all the internships being posted on the application. This page should be accessible to everyone irrespective of whether the user is even logged in.
- A student should be able to apply to any internship he may want. If the student has already applied for an internship, he should be restricted from applying again. If the user is not logged in, it should redirect to the login page. And if the user is logged in as an employer, he should not be allowed to apply.
- The employer should be able to see all the application he has received for his internships.

## Setting Up

Before setting up the web app youself, make sure you have the following : 

- PHP 7.0+
- MySQL (Improved) 5.0+
- A Web Server capable of running PHP.

Now, if you have all the requirements fulfilled. It's time to set up the app.

### Automatic Setup

The app has an `install` folder that is used to install the web app automatically. It is functional sugar over the existing app ensuring you don't have to waste much time setting the web app up.

The app will automatically route to `install/` route when it is run for the first time. Take the following steps to install the app.

**Step 1** : Extract all the contents of the ZIP File to a directory of your choice that the web server can run.

**Step 2** : Just turn on your web server, open your browser, and route to the directory relative to your web host in which you extracted the project. The web app should automatically redirect you to the **`/install`** route.

**Step 3** : You will see a form containing all the fields required to set up the app. Fill them all correctly. And submit the form. If all the credentials are correct, then the web app should install itself automatically.

Post installation, you will be redirected to the root of your app. You may see it in all its glory!

### Manual Setup

You can also set up the app manually if you want to. The following steps should be taken to do so : 

**Step 1** : Extract all the contents of the ZIP File to a directory of your choice that the web server can run.

**Step 2** : Open `inc/config.php` using a text editor and replace its contents with the following snippet and fill out all the details inside `""` :

```php
<?php
	session_start();

	$config["appname"] = "";	// Write the name of your app.
	$config["dbhost"] = "";		// Write the name of the host your database is hosted on.
	$config["dbuser"] = "";		// Write the name of the user that has access to your database.
	$config["dbpass"] = "";		// Write the password of the user above.
	$config["dbname"] = "";		// Write the name of the database that needs to be connected.

	$db = mysqli_connect(
		$config["dbhost"],
		$config["dbuser"],
		$config["dbpass"],
		$config["dbname"]
	) or die("Could not establish connection with database.");
?>
```

**Step 3** : Open the file `Queries.sql` and run all the queries inside it in the database you connected the app to in the above.

**Step 4** : The web app should be setup now if you entered the correct credentials. Turn on your web server, open your browser, and route to the directory relative to your web host in which you extracted the app.

You should now be able to see your app in its full glory!

## Directory Structure

The directory structure of the web app looks like : 

- **files/** : Contains all the files required for the visual point of the app.
- **fragments/** : Contains all the portions of a webpage that are used over and over again.
- **inc/** : Contains the configuration file for the web app without which the app won't work.
- **install/** : Contains the files necessary for the automatic installation of the app.
- **js/** : Contains all the JavaScript required for the app.
- **styles/** : Contains all the Styles required for the app, inline styles have not been used in order to minimize inconsistency of design.

## Problems and Issues

For any issues or problems arising out of the app, please do let me know.

Just send me a message or [mail me](mailto:devesh2027@gmail.com).