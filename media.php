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
?>			

<html>
<body>
<br />
<br />
<br />
<br />
     
<div class="panel panel-primary">
	<div class="panel-heading">
  		<h3 class="panel-title"><i class="fa fa-image" aria-hidden="true"></i> Uploaded Media</h3>
   </div>
   <div class="panel-body">

	<?php
	$dirname = "uploads/";
	$images = glob($dirname."*.*");
	foreach($images as $image) {
	echo '<a href="'.$image.'"><img src="'.$image.'" width=200 height=125 style="float: left; padding: 2px;" /></a>';
	}
	?>
	</div>
</div>


<div class="panel panel-primary">
	<div class="panel-heading">
  		<h3 class="panel-title"><i class="fa fa-upload" aria-hidden="true"></i> Upload New Media</h3>
   </div>
   <div class="panel-body">
		<form action="upload.php" method="post" enctype="multipart/form-data">
    		Select image to upload:
    		<input type="file" name="fileToUpload" id="fileToUpload">
    		<br>
    		<input class="btn btn-info" type="submit" value="Upload Image" name="submit">
		</form>
	</div>
</div>


</body>
</html>