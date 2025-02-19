<?php
ob_start();
if(isset($_POST['submit'])) {

include_once 'constants.php';
include_once 'functions.php';
$username = xss_clean($_POST['username']);
$password = xss_clean($_POST['password']);
sec_session_start();

if(!empty($username) && !empty($password)){

		if(login($username, $password, $mysqli) == true) {

       	$output = ob_get_contents();

		ob_end_clean();

		header('Location: ../dashboard.php');

		exit();

    	} else {

		//Login failed 

		$output = ob_get_contents();

		ob_end_clean();

		header('Location: ../index.php?act=login&error=1');

		exit();

   		}

	}	

	

else {

    //The correct POST variables were not sent to this page. 

    $output = ob_get_contents();

	ob_end_clean();

	header('Location: ../index.php?act=login&error=param');

	exit();

}	

}