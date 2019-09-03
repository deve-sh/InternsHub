/*
	All the scripts required for the app go here.
	This is a small file as the project does not need a lot of JavaScript.
*/

function openSN(){
	// Function to open the sidenav.

	document.getElementById('sidenav').style.width = "100%";
}

function closeSN(){
	// Function to close the sidenav.

	document.getElementById('sidenav').style.width = "0";
}

function optionsRemover(){
	// Function to hide the dashboard and logout functions while the user is on the logout or other sensitive page.
	// This is to avoid abuse of the header bar.

	if(window.location.toString().includes('logout.php')
		|| window.location.toString().includes('login-conf.php')
		|| window.location.toString().includes('signup-conf.php')){
		// Hide Main Menu.
		document.getElementById('menuContainer').style.display = "none";

		// Hide Sidenav if the user is on a small screen device.

		document.getElementById('sidenavContainer').style.display = "none";
	}
}