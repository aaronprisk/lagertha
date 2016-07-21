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
    include("includes/test_functions.php");
    include("includes/roster_functions.php");
} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    header("Location: login.php");
    include("views/not_logged_in.php");
}
?>			

<html>
<body>
<br />
<br />
<br />
<br />
     
<div class="panel panel-primary">
	<div class="panel-heading">
  		<h3 class="panel-title"><i class="fa fa-image" aria-hidden="true"></i> Help & Support</h3>
   </div>
   <div class="panel-body">

<h1>Help & Support</h1>
<br />
<h3>Online Help</h3>
<p>A helpful wiki is in the works :)</p>
<p>If you're having trouble with Lagertha or find a bug, please report it to our team on our github.</p>
<h3>Contribute</h3>
<p>If you'd like contribute to Lagertha, please join us on our github!</p>
<h3>License</h3>
<p>Lagertha is licensed under the GNU GPL 2.0 license. A copy of the GNU GPL 2.0 license is packaged with this software. For more information of the GNU GPL license, please visit <a href="http://gnu.org">GNU.org</a></p>
</div>
</div>

</div>
<!-- End Shell -->


</body>
</html>