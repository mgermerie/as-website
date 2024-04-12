<?php


session_start();


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
	require_once( './controllers/personalResults.php' );
	$_SESSION['lastLoadedPage'] = 'index.php?action=personalResults';
}
else if ( $_GET['action'] === 'wip' )
{
	require_once( './controllers/wip.php' );
	$_SESSION['lastLoadedPage'] = 'index.php?action=wip';
}
else
{
	echo "Erreur 404 : la page que vous recherchez n'existe pas.";
}

