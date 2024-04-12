<?php


require_once( './models/basics.php' );


function get_error_messages()
{
	try
	{
		return json_decode(
			file_get_contents( './data/error-messages.json' ),
			true,
		);
	}
	catch( Exception $e )
	{
		die( 'ERREUR : '.$e->getMessage() );
	}
}


function handle_error ( $error )
{
	if ( !isset( $_SESSION['MESSAGE'] ) )
	{
		$_SESSION['MESSAGE'] = [];
	}

	switch ( $error )
	{
		case 'database_connection':
			redirect( 'index.php?action=505' );
			break;
		case 'database_error':
			array_push( $_SESSION['MESSAGE'], 'database_error' );
			break;
		case 'credentials_unknown':
			array_push( $_SESSION['MESSAGE'], 'credentials_unknown' );
			break;
		case 'credentials_email_exists':
			array_push( $_SESSION['MESSAGE'], 'credentials_email_exists' );
			break;
		case 'credentials_team_exists':
			array_push( $_SESSION['MESSAGE'], 'credentials_team_exists' );
			break;
	}
}


$errorMessages = get_error_messages();

