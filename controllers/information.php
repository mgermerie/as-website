<?php


$pageTitle = 'Info pratiques / règlements';
$pageTag = 'information';


# MODELS

require_once( './models/DatabaseManager.php' );
require_once( './models/EventsManager.php' );
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

$eventsManager = new EventsManager( $database );


if ( $_SERVER['REQUEST_METHOD'] === 'GET' )
{
    if ( isset( $_GET['requestEventsWithLocations'] ) )
    {
        echo json_encode(
            $eventsManager->get_distinct_events_with_locations(),
        );
        exit();
    }
}


# VIEWS

require_once( './views/pages/information.php' );

