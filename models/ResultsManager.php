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


	function get_events ()
	{
		return $this->database->get_events_with_results();
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


	function add_result (
		$eventId,
		$userFullName,
		$teamName,
		$performance,
		$score,
		$adminId,
		$options=[],
	)
	{
		$userId = NULL;
		$teamId = NULL;

		if ( isset( $userFullName ) && !empty( $userFullName ) )
		{
			$user = $this->database->get_user_from_name( $userFullName );
			if ( count( $user ) !== 1 )
			{
				handle_error( 'user_unknown' );
				execute_callback( @$options['on_failure'] );
				return false;
			}
			$userId = $user[0]['id'];
		}
		else if ( isset( $teamName ) && !empty( $teamName ) )
		{
			$team = $this->database->get_team_from_name( $teamName );
			if ( count( $team ) !== 1 )
			{
				handle_error( 'team_unknown' );
				execute_callback( @$options['on_failure'] );
				return false;
			}
			$teamId = $team[0]['id'];
		}
		else
		{
			handle_error( 'user_unknown' );
			handle_error( 'team_unknown' );
			execute_callback( @$options['on_failure'] );
			return false;
		}

		if ( $this->database->add_result(
			$eventId,
			$userId,
			$teamId,
			$performance,
			$score,
			$adminId,
		) )
		{
			execute_callback( @$options['on_success'] );
			return true;
		}

		handle_error( 'database_error' );
		execute_callback( @$options['on_failure'] );
		return false;
	}
}
