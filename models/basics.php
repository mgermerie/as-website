<?php


function redirect ( $location )
{
	header( 'Location: '.$location );
	exit();
}


function reload ()
{
	header( 'Location:' .$_SERVER['PHP_SELF']. '?' .$_SERVER['QUERY_STRING'] );
	exit();
}


function execute_callback ( $callback )
{
	if (
		isset( $callback )
		&& is_callable( $callback )
	)
	{
		call_user_func( $callback );
	}
}

