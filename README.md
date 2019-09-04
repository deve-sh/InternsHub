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
- **Pagination**
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

**Step 1** : Extract all the contents of the ZIP File to a directory of your choice that the web server can run.

**Step 2** : In your MySQLi Database, run the queries found in the file `Queries.sql`, this should create the tables needed for the web application.

**Step 3** : Open `inc/config.php` using a text editor and replace the configuration variables with the values pertaining to your database and App Name of your choice.

**Step 4** : If all the configuration is correct, then you should see all of your 