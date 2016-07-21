<?php 

include("includes/functions.php");
include('header/header.php');


$taskid = mysql_real_escape_string($_REQUEST['id']);
showRecord($taskid);

?>
	
<!-- End Shell -->

<!-- Footer -->
<div id="footer">
&copy;Mountain Database Management System ~ Appalachian Computer Services<br>
Mountain Database Version 1.0 - For Technical Support Call (814)791-9008
</div>
<!-- End Footer -->
</body>
</html>