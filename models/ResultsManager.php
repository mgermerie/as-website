<?php


require_once( './models/basics.php' );
require_once( './models/errors.php' );


class ResultsManager
{
	public $database;


	function __construct (
		$database,
	)
	{
		$this->database = $database;
	}


	function get_results ()
	{
		return $this->database->get_results();
	}


	function get_results_for_event (
		$eventId,
	)
	{
		return $this->database->get_results_for_event( $eventId );
	}
}
