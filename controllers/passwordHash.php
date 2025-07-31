<?php


$pageTitle = 'Hash password';


if ( $_SERVER['REQUEST_METHOD'] === 'POST')
{
	if ( isset( $_POST['newpass'] ) )
	{
		$hashed_password = password_hash($_POST['newpass'], PASSWORD_DEFAULT);
		echo $hashed_password;
	}
	exit();
}


# VIEWS

require_once( './views/pages/passwordHash.php' );
