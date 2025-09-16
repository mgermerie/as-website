<?php


$pageTitle = 'Mes résultats';


# MODELS

require_once( './models/DatabaseManager.php' );
require_once( './models/ResultsManager.php' );
require_once( './models/TeamsManager.php' );
require_once( './models/navigation.php' );


$navData = get_nav_items();


$database = new DatabaseManager();

if ( isset( $_SESSION['LOGGED_USER']['needsTeam'] ) )
{
    unset( $_SESSION['LOGGED_USER']['needsTeam'] );
    $teamsManager = new TeamsManager( $database );
    $teamsList = $teamsManager->get_teams();
    $needsTeam = true;
}

$resultsManager = new ResultsManager( $database );
$results = $resultsManager->get_results();
$team = $_SESSION['LOGGED_USER']['team'] ?? null;

$hasResults = false;

foreach ( $results as $result )
{
	if (
		(
			isset( $team )
			&& $result['team_event']
			&& $result['team'] === $team['name']
		) || (
			$result['first_name'] === $_SESSION['LOGGED_USER']['firstName']
			&& $result['name'] === $_SESSION['LOGGED_USER']['name']
		)
	)
	{
		$hasResults = true;
		break;
	}
}

if ( $_SERVER['REQUEST_METHOD'] === 'GET' )
{
	if ( isset ( $_GET['requestResults'] ) )
	{
		echo json_encode( $results );
		exit();
	}
	else if ( isset ( $_GET['requestUser'] ) )
	{
		$response = [
			'name' => $_SESSION['LOGGED_USER']['name'],
			'first_name' => $_SESSION['LOGGED_USER']['firstName'],
		];
		if ( isset( $team ) )
		{
			$response['team'] = $team['name'];
		}
		echo json_encode( $response );
		exit();
	}
}



# VIEWS

require_once( './views/pages/personalResults.php' );

