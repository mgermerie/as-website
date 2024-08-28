<?php


session_start();


require_once( './models/basics.php' );


if ( !isset( $_GET['action'] ) || $_GET['action'] === '' )
{
	require_once( './controllers/homepage.php' );
	$_SESSION['lastLoadedPage'] = 'index.php';
}
else if ( $_GET['action'] === 'authentification' )
{
	require_once( './controllers/authentification.php' );
}
else if ( $_GET['action'] === 'contestants' )
{
	require_once( './controllers/contestants.php' );
	$_SESSION['lastLoadedPage'] = 'index.php?action=contestants';
}
else if ( $_GET['action'] === 'calendar' )
{
	require_once( './controllers/calendar.php' );
	$_SESSION['lastLoadedPage'] = 'index.php?action=calendar';
}
else if ( $_GET['action'] === 'results' )
{
	require_once( './controllers/results.php' );
	$_SESSION['lastLoadedPage'] = 'index.php?action=results';
}
else if ( $_GET['action'] === 'information' )
{
	require_once( './controllers/information.php' );
	$_SESSION['lastLoadedPage'] = 'index.php?action=information';
}
else if ( $_GET['action'] === 'personalResults' )
{
	if ( isset( $_SESSION['LOGGED_USER'] ) )
	{
		require_once( './controllers/personalResults.php' );
		$_SESSION['lastLoadedPage'] = 'index.php?action=personalResults';
	}
	else
	{
		redirect( 'index.php' );
	}
}
else if ( $_GET['action'] === 'team' )
{
	if ( isset( $_SESSION['LOGGED_USER'] ) )
	{
		require_once( './controllers/team.php' );
		$_SESSION['lastLoadedPage'] = 'index.php?action=team';
	}
	else
	{
		redirect( 'index.php' );
	}
}
else if ( $_GET['action'] === 'passwordReset' ) {
	require_once( './controllers/passwordReset.php' );
}
else if ( $_GET['action'] === '505' )
{
	require_once( './controllers/505.php' );
	$_SESSION['lastLoadedPage'] = 'index.php?action=505';
}
else
{
	echo "Erreur 404 : la page que vous recherchez n'existe pas.";
}

