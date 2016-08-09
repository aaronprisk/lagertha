<?php
// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    include("header/header.php");
    include("includes/connect.php");
    include("includes/lagertha_functions.php");
} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    header("Location: login.php");
    include("views/not_logged_in.php");
}
		
	// Pull Settings from DB
   $settingquery = "SELECT check_freq FROM settings WHERE settings_id=1"; 
	$settingresult = $link->query($settingquery);
	while($row = $settingresult->fetch_assoc()) {
		$cur_check_freq = $row['check_freq'];
		}
		
	
echo "
<html><body><br /><br /><br /><br />
<div class='panel panel-primary'>
	<div class='panel-heading'>
  		<h3 class='panel-title'><i class='fa fa-cog' aria-hidden='true'></i> Client Settings</h3>
   </div>
   <div class='panel-body'>
	<form action='update_settings.php'>
  		<label class='control-label' for='inputSmall'> Check Frequency (60 seconds minimum)</label>
  		<input class='input-sm col-xs-1' placeholder='".$cur_check_freq."' name='check_freq' type='number' min='60' id='inputSmall'>
  		<br /><br />
		<div class='well well-sm'>
  		<strong>Check Frequency</strong> defines how often a client queries the Lagertha server for pending tasks. The check frequency number acts as the max number of seconds a client can wait until it queries the Lagertha Server. 
  		<br /> CAUTION: Setting this number too low could result in spike in network traffic and server load.
		</div>
		<button type='submit' class='btn btn-success'>Save Settings</button>
	<form>
</div></div>
</body></html>"
?>


