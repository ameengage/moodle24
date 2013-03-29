<?php
$config = array();

$config['email'] = 'demo@demo.com';
$config['password'] = 'demo123';

// Show all errors except the notice ones
error_reporting(E_ALL ^ E_NOTICE);

// Initialize session
session_id();
session_start();
header('Cache-control: private'); // IE 6 FIX

if($_POST['action'] == 'user_login')
{
	include('conn_string.php');

$post_email = $_POST['email'];
$post_password = $_POST['password'];

    $em = $_POST['email'];
	$pw = $_POST['password'];

	//$sql = "select id,name,user_level from user where email = '".$em."' and password = '".$pw."' and active = 1";
	//echo $sql;
	//$rs = $dbm->query($sql);
	//$nr = $rs->num_rows;
	//$row = $rs->fetch_assoc();

	if($em == 'admin' && $pw == 'R@nGen2011') $nr = 1;
	else $nr = 0;

	//$nr = 1;

// check username and password

if($nr > 0)
{ 
// No error? Register the session & redirect the user to his/her 'Control Panel'
	
        $_SESSION['username'] = $em;
		//$_SESSION['uid'] = $row['id'];
		//$_SESSION['ulevel'] = $row['user_level'];

		

//echo 'HHH = '.$_SESSION['username'];

			if($_POST['remember_me'])
			{
			// set the cookies for 1 month

			setcookie ("remember_me", true, (time() + TIME_DIFF) + (3600 * 24 * 30));
			setcookie ("info", $user_id.','.md5($password), (time() + TIME_DIFF) + (3600 * 24 * 30));
			}
	        echo 'OK'; // this response is checked in 'process-login.js'
	}
	else 
	{
    $auth_error = '<div id="notification_error">The login info is not correct.</div>';

    echo $auth_error;
	}
}
?>