<?php


function get_nav_items()
{
	try
	{
		return json_decode(
			file_get_contents( './data/navigation.json' ),
			true,
		);
	}
	catch( Exception $e )
	{
		die( 'ERREUR : '.$e->getMessage() );
	}
}

