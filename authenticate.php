<?php

include('includes/functions.php');

$username = mysql_real_escape_string($_POST['username']);
$password = md5($_POST['password']);

if(isset($_POST['login'])) {
	if(isset($_POST['username'])) {
		if(isset($_POST['password'])) {
			$query = mysql_query("SELECT * FROM Users WHERE Username = '$username'") or die(mysql_error());
			$user = mysql_fetch_array($query);

			if($password == $user['password']) {
				$_SESSION['user'] = $user['username'];
				header("Location: index.php");
			} else {
				echo "Please Check Your Login Credentials";
				include('login.php')
			}
		} else  {
			echo "Please check your login credentials";
			include('login.php');
		}
	} else {
		echo "Please check your login credentials";
		include('login.php');
	}
} else {
	echo "Please check your login credentials";
	include('login.php');
}

?>