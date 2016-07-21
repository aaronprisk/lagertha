<!DOCTYPE html>
<html lang="en">
	<head>
   	<title>Lagertha</title>
   	<meta charset="utf-8">
   	<meta http-equiv="X-UA-Compatible" content="IE=edge">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
   	<link rel="stylesheet" href="../css/bootstrap.css" media="screen">
    	<link rel="stylesheet" href="../assets/css/custom.min.css">
      <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
   	 <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  		 <!--[if lt IE 9]>
   	   <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>
    	  <script src="../bower_components/respond/dest/respond.min.js"></script>
  	  <![endif]-->

</head>
	
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
	header("Location: index.php");
} else {
}
?>				
	
	

<br />
<br />
<br />
<br />

	<div class="container" style="text-align: center;">  
	    <div class='col-md-4 col-md-offset-4'>
	    		<div class="panel panel-primary">
           		 <div class="panel-heading">
            <h3 class="panel-title">Login</h3>
            	 </div>
        <div class="panel-body">
	    	 <img src="images/lag-logo-black.png" height="100px" alt="">
  		  	<form method="post" action="index.php" name="loginform"> 	
  		   	<h2 class="form-signin-heading">Please sign in</h2>	 
     				<label for="login_input_username" class="sr-only">Username</label>Username
    				<input id="login_input_username" class="form-control login_input" type="text" name="user_name" required />
   				<label for="login_input_password" class="sr-only">Password</label>Password
  		 			<input id="login_input_password" class="form-control login_input" type="password" name="user_password" autocomplete="off" required />
  		 			<br />
  		   		<input type="submit" class="btn btn-lg btn-primary btn-block" name="login" value="Log in" />
			</form>
			</div>
		</div>
	</div>
</div> <!-- /container -->

	

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="login_files/ie10-viewport-bug-workaround.js"></script>

</body></html>