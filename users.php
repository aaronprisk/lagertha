<br /><br /><br /><br />
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
    include("header/header.php");  
	// load the registration class
	require_once("classes/Registration.php");
	$registration = new Registration();

	if (isset($registration)) {
   	 if ($registration->errors) {
      	  foreach ($registration->errors as $error) {
      	  		echo "<div class='alert alert-dismissible alert-danger'>
 							<button type='button' class='close' data-dismiss='alert'>&times;</button>
						   <strong>" . $error . "</div>";
       	 }
   	 }
   	 if ($registration->messages) {
      	  foreach ($registration->messages as $message) {
         		echo "<div class='alert alert-dismissible alert-success'>
 							<button type='button' class='close' data-dismiss='alert'>&times;</button>
						   <strong>" . $message . "</div>";
       	 }
   	 }
	}
	echo "

<!-- register form -->
<form method='post' action='users.php' name='registerform'>

    <!-- the user name input field uses a HTML5 pattern check -->
    <label for='login_input_username'>Username (only letters and numbers, 2 to 64 characters)</label>
    <input id='login_input_username' class='login_input' type='text' pattern='[a-zA-Z0-9]{2,64}' name='user_name' required />

    <!-- the email input field uses a HTML5 email type check -->
    <label for='login_input_email'>User's email</label>
    <input id='login_input_email' class='login_input' type='email' name='user_email' required />

    <label for='login_input_password_new'>Password (min. 6 characters)</label>
    <input id='login_input_password_new' class='login_input' type='password' name='user_password_new' pattern='.{6,}' required autocomplete='off' />

    <label for='login_input_password_repeat'>Repeat password</label>
    <input id='login_input_password_repeat' class='login_input' type='password' name='user_password_repeat' pattern='.{6,}' required autocomplete='off' />
    <input type='submit'  name='register' value='Register' />

</form>

<!-- backlink -->
<a href='index.php'>Back to Login Page</a>";




} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    header("Location: login.php");
    include("views/not_logged_in.php");
}
?>


    </div> <!-- /container -->
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








