<?php


$pageTitle = 'Espace administrateur';


# MODELS

require_once( './models/DatabaseManager.php' );
require_once( './models/EventsManager.php' );
require_once( './models/ResultsManager.php' );
require_once( './models/navigation.php' );


$navData = get_nav_items();


$database = new DatabaseManager();
$eventsManager = new EventsManager( $database );
$resultsManager = new ResultsManager( $database );

$contestantsList = $database->get_users();


if ( $_SERVER['REQUEST_METHOD'] === 'GET' )
{
    if ( isset( $_GET['requestRegistered'] ) )
    {
        echo json_encode(
            $eventsManager->get_registered_users_for_event(
                $_GET['requestRegistered'],
            ),
        );
        exit();
    }
    else if ( isset( $_GET['requestTypedResults'] ) )
    {
        echo json_encode(
            $resultsManager->get_results_for_event(
                $_GET['requestTypedResults'],
            ),
        );
        exit();
    }
}


# VIEWS

require_once( './views/pages/admin.php' );

