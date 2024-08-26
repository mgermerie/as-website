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
			$databaseAccess = parse_ini_file(
				'../access.ini',
				true,
				INI_SCANNER_RAW,
			)['database'];
			$dbHost = $databaseAccess['dbhost'];
			$dbUsername = $databaseAccess['username'];
			$dbPassword = $databaseAccess['password'];
			$dbName = $databaseAccess['dbname'];

			$this->pdo = new PDO(
				"mysql:host=$dbHost;dbname=$dbName;charset=utf8",
				"$dbUsername",
				"$dbPassword",
				[
					PDO::ATTR_EMULATE_PREPARES => false,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				],
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
		$values=[],
	)
	{
		$query = $this->pdo->prepare( $statement );
		$query->execute($values);
		return $query;
	}




	function get_user_from_email (
		$email,
	)
	{
		return $this->execute_statement(
			"SELECT *
				FROM users
				WHERE email = :email",
			[ ':email' => $email ],
		)->fetchAll();
	}


	function get_user_name_from_id (
		$userId,
	)
	{
		return $this->execute_statement(
			"SELECT name, first_name
				FROM users
				WHERE id = :user_id",
			[ ':user_id' => $userId ],
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
				VALUES (:name, :firstName, :email, :hashedPassword)",
			[
				':name' => $name,
				':firstName' => $firstName,
				':email' => $email,
				':hashedPassword' => $hashedPassword,
			],
		);
	}


	function update_user_password (
		$userId,
		$hashedPassword,
	)
	{
		return $this->execute_statement(
			"UPDATE users
				SET password=:hashedPassword
				WHERE id=:userId",
			[
				':hashedPassword' => $hashedPassword,
				':userId' => $userId,
			],
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
				SET team=:teamId
				WHERE id=:userId",
			[
				':teamId' => $teamId,
				':userId' => $userId,
			],
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
				WHERE id = :teamId",
			[ ':teamId' => $teamId ],
		)->fetchAll();
	}


	function get_team_from_name (
		$teamName,
	)
	{
		return $this->execute_statement(
			"SELECT *
				FROM teams
				WHERE name = :teamName",
			[ ':teamName' => $teamName ],
		)->fetchAll();
	}


	function add_team (
		$teamName,
		$teamLeader,
	)
	{
		return $this->execute_statement(
			"INSERT INTO
				teams (name, leader_id)
				VALUE (:teamName, :teamLeader)",
			[
				':teamName' => $teamName,
				':teamLeader' => $teamLeader,
			],
		);
	}


	function get_team_members_from_team_id (
		$teamId,
	)
	{
		return $this->execute_statement(
			"SELECT id, name, first_name
				FROM users
				WHERE team= :teamId
				ORDER BY name",
			[ ':teamId' => "$teamId" ],
		)->fetchAll();
	}


	function get_users () {
		return $this->execute_statement(
			"SELECT id, name, first_name
				FROM users",
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
					ST_Y(locations.location) as longitude,
					team_referee_registration.team_id
				FROM events
				LEFT JOIN locations
					ON events.location_id=locations.id
				LEFT JOIN team_referee_registration
					ON events.id=team_referee_registration.event_id
				WHERE start IS NOT NULL
					AND end IS NOT NULL
					AND start > :dateStart
					AND end < :dateEnd",
			[
				':dateStart' => $dateStart,
				':dateEnd' => $dateEnd,
			],
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
					ST_Y(locations.location) as longitude,
					team_referee_registration.team_id
				FROM events
				LEFT JOIN locations
					ON events.location_id=locations.id
				LEFT JOIN team_referee_registration
					ON events.id=team_referee_registration.event_id
				WHERE events.start IS NOT NULL
					AND events.end IS NOT NULL
					AND events.start > :dateStart
					AND events.end < :dateEnd
					AND events.title= :type",
			[
				':dateStart' => $dateStart,
				':dateEnd' => $dateEnd,
				':type' => $type,
			],
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
				WHERE id=:eventId",
			[ ':eventId' => $eventId ],
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
				VALUES (:eventId, :userId)",
			[
				':eventId' => $eventId,
				':userId' => $userId,
			],
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
				WHERE user_id=:userId
					AND event_id=:eventId",
			[
				':eventId' => $eventId,
				':userId' => $userId,
			],
		);
	}


	function get_register_events_for_user (
		$userId,
	)
	{
		return $this->execute_statement(
			"SELECT events_registration.event_id,
					events.title
				FROM events_registration
				LEFT JOIN events ON events_registration.event_id=events.id
				WHERE events_registration.user_id=:userId",
			[ ':userId' => $userId ],
		)->fetchAll();
	}


	function register_referee_team_to_event (
		$teamId,
		$eventId,
	)
	{
		return $this->execute_statement(
			"INSERT INTO
				team_referee_registration (event_id, team_id)
				VALUES (:eventId, :teamId)",
			[
				':eventId' => $eventId,
				':teamId' => $teamId,
			],
		);
	}


	function remove_event (
		$eventId,
	)
	{
		return $this->execute_statement(
			"DELETE
				FROM events
				WHERE id=:eventId;
			DELETE
				FROM events_registration
				WHERE event_id=:eventId",
			[ ':eventId' => $eventId ],
		);
	}


	function get_events_with_team_referee (
		$teamId,
	)
	{
		$this->execute_statement(
			"SET lc_time_names = 'fr_FR'",
		);
		return $this->execute_statement(
			"SELECT events.title,
					DAY(events.start) as day,
					DAYNAME(events.start) as day_name,
					MONTHNAME(events.start) as month_name
				FROM events
				LEFT JOIN team_referee_registration
					ON events.id=team_referee_registration.event_id
				WHERE team_referee_registration.team_id=:team_id",
			[ ':team_id' => $teamId ],
		)->fetchAll();
	}




	function get_results ()
	{
		return $this->execute_statement(
			"SELECT events.title,
					events.team_event,
					users.first_name,
					users.name,
					teams.name as team,
					results.performance_number,
					results.performance_distance,
					results.performance_time,
					results.score
				FROM results
				LEFT JOIN events ON results.event_id=events.id
				LEFT JOIN users ON results.user_id=users.id
				LEFT JOIN teams ON users.team=teams.id",
		)->fetchAll();
	}
}

