<?php
// log store out by unsetting session variable called email, and ending the session

	session_start();
	if(isset($_SESSION['email'])){
		unset($_SESSION['email']);
	}
	session_destroy();
	
	
	//redirect user to grocerLogin.php
	header("Location: customerSide.php");
	exit;
?>