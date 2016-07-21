<?php
/**
 * A simple, clean and secure PHP Login Script / MINIMAL VERSION
 * For more versions (one-file, advanced, framework-like) visit http://www.php-login.net
 *
 * Uses PHP SESSIONS, modern password-hashing and salting and gives the basic functions a proper login system needs.
 *
 * @author Panique
 * @link https://github.com/panique/php-login-minimal/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    include("views/logged_in.php");
    include("header/header.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    header("Location: login.php");
    include("views/not_logged_in.php");
}
?>			

<br />
<br />
<br />

<div class="panel panel-primary">
	<div class="panel-heading">
  		<h3 class="panel-title">Create New Software Task</h3>
   </div>
   <div class="panel-body text-center">

 		<h3>Software Tasks</h3>
 		<hr>
 		<br />
		 <i class="fa fa-archive fa-3x" aria-hidden="true"></i> <h4>Install Package</h4>
 		<br />
		 <i class="fa fa-download fa-3x" aria-hidden="true"></i> <h4>Update Packages</h4>
 		<br />
		 <i class="fa fa-minus-circle fa-3x" aria-hidden="true"></i> <h4>Remove Package</h4>
 		<br />
      	 <div class="alert alert-dismissible alert-danger" role="alert">
       	 <strong>WARNING!</strong> Installing or Removing packages can render client computers inoperable. Use proper caution when creating these tasks.
     		 </div>		

</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
  		<h3 class="panel-title">Create New Special Task</h3>
  	</div>
   <div class="panel-body text-center">
 		<h3>Special Tasks</h3>
 		<hr>
 		 <br />
 		 <i class="fa fa-image fa-3x" aria-hidden="true"></i> <h4>Change Wallpaper</h4>
		 <br />
	</div>
</div>
	



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    
    
    
    
  
    
    
    
  </body>
</html>
