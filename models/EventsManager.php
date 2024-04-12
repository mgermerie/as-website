<?php


require_once( './models/basics.php' );
require_once( './models/errors.php' );


class EventsManager
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
		return $this->database->get_events();
	}


	function get_events_between_dates (
		$dateStart,
		$dateEnd,
	)
	{
		return $this->database->get_events_between_dates( $dateStart, $dateEnd);
	}


	function get_typed_events_between_dates (
		$eventType,
		$dateStart,
		$dateEnd,
	)
	{
		return $this->database->get_typed_events_between_dates(
			$eventType,
			$dateStart,
			$dateEnd,
		);
	}


	function get_event_types ()
	{
		return $this->database->get_distinct_event_types();
	}

	function get_event_name_from_id (
		$eventId,
	)
	{
		return $this->database->get_event_from_id( $eventId )['title'];
	}

	function get_distinct_events_with_locations ()
	{
		return $this->database->get_distinct_events_with_locations();
	}


	function register_user_to_event (
		$userId,
		$eventId,
		$options=[],
	)
	{
		$eventName = $this->get_event_name_from_id( $eventId );

		$query = $this->database->register_user_to_event(
			$userId,
			$eventId,
		);

		if ( $query && $eventName )
		{
			array_push(
				$_SESSION['LOGGED_USER']['registeredEvents'],
				[
					'event_id' => $eventId,
					'title' => $eventName,
				],
			);
			execute_callback( @$options['on_success'] );
			return true;
		}

		handle_error( 'database_error' );
		execute_callback( @$options['on_failure'] );
		return false;
	}


	function unregister_user_from_event (
		$userId,
		$eventId,
		$options=[],
	)
	{
		$query = $this->database->unregister_user_from_event(
			$userId,
			$eventId,
		);
		if ( $query )
		{
			self::unregister_session_event( $eventId );
			execute_callback( @$options['on_success'] );
			return true;
		}

		handle_error( 'database_error' );
		execute_callback( @$options['on_failure'] );
		return false;
	}


	function remove_event (
		$eventId,
		$options=[],
	)
	{
		if ( $this->database->remove_event( $eventId ) )
		{
			self::unregister_session_event( $eventId, true );
			self::unregister_session_event( $eventId, false );
			execute_callback( @$options['on_success'] );
			return true;
		}

		handle_error( 'database_error' );
		execute_callback( @$options['on_failure'] );
		return false;
	}


	static function unregister_session_event (
		$eventId,
	)
	{
		foreach (
			$_SESSION['LOGGED_USER']['registeredEvents'] as $key => $value
		)
		{
			if (
				$value['event_id'] == "$eventId"
			)
			{
				array_splice(
					$_SESSION['LOGGED_USER']['registeredEvents'],
					$key,
					1,
				);
			}
		}
	}
}

