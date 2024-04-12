<?php


require_once( './models/basics.php' );
require_once( './models/errors.php' );


class TeamsManager
{
	public $database;


	function __construct (
		$database,
	)
	{
		$this->database = $database;
	}


	function get_teams ()
	{
		return $this->database->get_teams();
	}


	function get_team_from_id (
		$teamId,
	)
	{
		return $this->database->get_team_from_id( $teamId )[0];
	}


	function get_team_from_name (
		$teamName,
	)
	{
		return $this->database->get_team_from_name( $teamName )[0];
	}


	function create_team (
		$teamName,
		$options=[],
	)
	{
		# Check if team is already registered
		if ( count ( $this->database->get_team_from_name( $teamName ) ) !== 0 )
		{
			handle_error( 'credentials_team_exists' );
			execute_callback( @$options['on_failure'] );
			return false;
		}

		if ( $this->database->add_team(
			$teamName,
		) )
		{
			execute_callback( @$options['on_success'] );
			return true;
		}

		handle_error( 'database_error' );
		execute_callback( @$options['on_failure'] );
		return false;
	}


	function get_team_members(
		$team,
	)
	{
		return $this->database->get_team_members_from_team_id( $team['id'] );
	}
}

