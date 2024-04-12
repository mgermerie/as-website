<?php


require_once( './models/basics.php' );
require_once( './models/errors.php' );


class AuthentificationManager
{
	public $database;


	function __construct ( $database )
	{
		$this->database = $database;
	}


	static function logout ()
	{
		session_unset();
		session_destroy();
	}


	function login (
		$email,
		$password,
		$options=[],
	)
	{
		# Get user with matching email and password
		$user = $this->database->get_user_from_email( $email );

		# Check if user exists and if password matches
		if (
			count( $user ) !== 1
			|| !password_verify( $password, $user[0]['password'] )
		)
		{
			handle_error( 'credentials_unknown' );
			execute_callback( @$options['on_failure'] );
			return false;
		}

		$_SESSION['LOGGED_USER'] = [
			'id' => $user[0]['id'],
			'email' => $user[0]['email'],
			'name' => $user[0]['name'],
			'firstName' => $user[0]['first_name'],
			'team' => $user[0]['team'],
			'isAdmin' => $user[0]['admin'],
			'registeredEvents' => $this->database->get_register_events_for_user(
				$user[0]['id'],
			),
		];

		execute_callback( @$options['on_success'] );
		return true;
	}


	function register_user (
		$email,
		$password,
		$name,
		$firstName,
		$options=[],
	)
	{
		$hashedPassword = password_hash(
			$password,
			PASSWORD_DEFAULT,
		);

		# Check if email is already registered
		if ( count( $this->database->get_user_from_email( $email ) ) !== 0 )
		{
			handle_error( 'credentials_email_exists' );
			execute_callback( @$options['on_failure'] );
			return false;
		}

		# Write new user information on database
		if ( $this->database->add_new_user(
			$name,
			$firstName,
			$email,
			$hashedPassword,
		) )
		{
			execute_callback( @$options['on_success'] );
			return true;
		}

		handle_error( 'database_error' );
		execute_callback( @$options['on_failure'] );
		return false;
	}


	function register_team (
		$userId,
		$teamId,
		$options=[],
	)
	{
		if ( $this->database->add_team_to_user( $userId, $teamId ) )
		{
			$_SESSION['LOGGED_USER']['team'] = $teamId;
			execute_callback( @$options['on_success'] );
			return true;
		}

		handle_error( 'database_error' );
		execute_callback( @$options['on_failure'] );
		return false;
	}

}

