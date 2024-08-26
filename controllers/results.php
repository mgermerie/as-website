<?php


$pageTitle = 'Résultats';
$pageTag = 'results';


# MODELS

require_once( './models/DatabaseManager.php' );
require_once( './models/TeamsManager.php' );
require_once( './models/ResultsManager.php' );
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

$contestantsList = $database->get_users();


if ( $_SERVER['REQUEST_METHOD'] === 'GET' )
{
    if ( isset ( $_GET['requestResults'] ) )
    {
        echo json_encode( $resultsManager->get_results() );
        exit();
    }
}


# VIEWS

require_once( './views/pages/results.php' );

