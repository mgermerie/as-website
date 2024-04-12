<?php


require_once( './models/basics.php' );
require_once( './models/errors.php' );


class DatabaseManager
{
	public $pdo;


	function __construct ( $options=[] )
	{
		try
		{
			$databaseAcess = parse_ini_file(
				'../access.ini',
				true,
				INI_SCANNER_RAW,
			)['database'];
			$dbHost = $databaseAcess['dbhost'];
			$dbUsername = $databaseAcess['username'];
			$dbPassword = $databaseAcess['password'];
			$dbName = $databaseAcess['dbname'];

			$this->pdo = new PDO(
				"mysql:host=$dbHost;dbname=$dbName;charset=utf8",
				"$dbUsername",
				"$dbPassword",
			);
			execute_callback( @$options['on_success'] );
		}
		catch ( Exception $e )
		{
			handle_error( 'database_connection' );
			execute_callback( @$options['on_failure'] );
			return false;
		}
	}


	function execute_statement (
		$statement,
	)
	{
		# TODO: Protect against SQL injections
		$query = $this->pdo->prepare( $statement );
		$query->execute();
		return $query;
	}




	function get_user_from_email (
		$email,
	)
	{
		return $this->execute_statement(
			"SELECT *
				FROM users
				WHERE email = '{$email}'",
		)->fetchAll();
	}


	function add_new_user (
		$name,
		$firstName,
		$email,
		$hashedPassword,
	)
	{
		return $this->execute_statement(
			"INSERT INTO
				users (name, first_name, email, password)
				VALUES ('$name', '$firstName', '$email', '$hashedPassword')",
		);
	}


	function add_team_to_user (
		$userId,
		$teamId,
	)
	{
		return $this->execute_statement(
			"UPDATE
				users
				SET team=$teamId
				WHERE id=$userId",
		);
	}




	function get_teams ()
	{
		return $this->execute_statement(
			"SELECT *
				FROM teams",
		)->fetchAll();
	}


	function get_team_from_id (
		$teamId,
	)
	{
		return $this->execute_statement(
			"SELECT *
				FROM teams
				WHERE id = '{$teamId}'",
		)->fetchAll();
	}


	function get_team_from_name (
		$teamName,
	)
	{
		return $this->execute_statement(
			"SELECT *
				FROM teams
				WHERE name = '{$teamName}'",
		)->fetchAll();
	}


	function add_team (
		$teamName,
	)
	{
		return $this->execute_statement(
			"INSERT INTO
				teams (name)
				VALUE ('$teamName')",
		);
	}


	function get_team_members_from_team_id (
		$teamId,
	)
	{
		return $this->execute_statement(
			"SELECT id, name, first_name
				FROM users
				WHERE team=$teamId
				ORDER BY name"
		)->fetchAll();
	}


	function get_teamless_users ()
	{
		return $this->execute_statement(
			"SELECT id, name, first_name
				FROM users
				WHERE team IS NULL
				ORDER BY name",
		)->fetchAll();
	}


	function get_events ()
	{
		return $this->execute_statement(
			"SELECT *
				FROM events",
		)->fetchAll();
	}


	function get_events_between_dates (
		$dateStart,
		$dateEnd,
	)
	{
		return $this->execute_statement(
			"SELECT events.id,
					events.title,
					events.start,
					events.end,
					events.location_id,
					locations.name,
					ST_X(locations.location) as latitude,
					ST_Y(locations.location) as longitude
				FROM events
				LEFT JOIN locations ON events.location_id=locations.id
				WHERE start IS NOT NULL
					AND end IS NOT NULL
					AND start > '{$dateStart}'
					AND end < '{$dateEnd}'",
		)->fetchAll();
	}


	function get_typed_events_between_dates (
		$type,
		$dateStart,
		$dateEnd,
	)
	{
		$events = $this->execute_statement(
			"SELECT events.id,
					events.title,
					events.start,
					events.end,
					events.location_id,
					locations.name,
					ST_X(locations.location) as latitude,
					ST_Y(locations.location) as longitude
				FROM events
				LEFT JOIN locations ON events.location_id=locations.id
				WHERE events.start IS NOT NULL
					AND events.end IS NOT NULL
					AND events.start > '{$dateStart}'
					AND events.end < '{$dateEnd}'
					AND events.title='{$type}'",
		)->fetchAll();

		return $events;
	}


	function get_distinct_event_types ()
	{
		return $this->execute_statement(
			"SELECT DISTINCT title
				FROM events",
		)->fetchAll();
	}


	function get_distinct_events_with_locations ()
	{
		return $this->execute_statement(
			"SELECT DISTINCT
					events.title,
					events.location_id,
					events.team_event,
					locations.name,
					ST_X(locations.location) as latitude,
					ST_Y(locations.location) as longitude
				FROM events
				LEFT JOIN locations on events.location_id=locations.id",
		)->fetchAll();
	}


	function get_event_from_id (
		$eventId
	)
	{
		return $this->execute_statement(
			"SELECT *
				FROM events
				WHERE id=$eventId",
		)->fetchAll()[0];
	}


	function register_user_to_event (
		$userId,
		$eventId,
	)
	{
		return $this->execute_statement(
			"INSERT INTO
				events_registration (event_id, user_id)
				VALUES ($eventId, $userId)",
		);
	}


	function register_referee_to_event (
		$userId,
		$eventId,
	)
	{
		return $this->execute_statement(
			"INSERT
				INTO events_registration (event_id, user_id, referee)
				VALUES ($eventId, $userId, true)",
		);
	}


	function unregister_user_from_event (
		$userId,
		$eventId,
	)
	{
		return $this->execute_statement(
			"DELETE
				FROM events_registration
				WHERE user_id=$userId
					AND event_id=$eventId
					AND referee=false",
		);
	}


	function unregister_referee_from_event (
		$userId,
		$eventId,
	)
	{
		return $this->execute_statement(
			"DELETE
				FROM events_registration
				WHERE user_id=$userId
					AND event_id=$eventId
					AND referee=true",
		);
	}


	function get_register_events_for_user (
		$userId,
	)
	{
		return $this->execute_statement(
			"SELECT events_registration.event_id,
					events_registration.referee,
					events.title
				FROM events_registration
				LEFT JOIN events ON events_registration.event_id=events.id
				WHERE events_registration.user_id=$userId",
		)->fetchAll();
	}


	function remove_event (
		$eventId,
	)
	{
		return $this->execute_statement(
			"DELETE
				FROM events
				WHERE id=$eventId;
			DELETE
				FROM events_registration
				WHERE event_id=$eventId",
		);
	}
}

