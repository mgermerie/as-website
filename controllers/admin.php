<?php


$pageTitle = 'Espace administrateur';


# MODELS

require_once( './models/DatabaseManager.php' );
require_once( './models/EventsManager.php' );
require_once( './models/ResultsManager.php' );
require_once( './models/TeamsManager.php' );
require_once( './models/navigation.php' );


$navData = get_nav_items();


$database = new DatabaseManager();
$eventsManager = new EventsManager( $database );
$resultsManager = new ResultsManager( $database );
$teamsManager = new TeamsManager( $database );

$contestantsList = $database->get_users();
$teamsList = $teamsManager->get_teams();


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
    else if ( isset( $_GET['requestRegisteredReferee'] ) )
    {
        echo json_encode(
            $eventsManager->get_registered_referee_for_event(
                $_GET['requestRegisteredReferee'],
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
else if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
{
    if ( isset( $_POST['insertResult'] ) )
    {
        $resultsManager->add_result(
            $_POST['eventId'],
            $_POST['contestantName'],
            $_POST['teamName'],
            $_POST['performance'],
            $_POST['score'],
            $_SESSION['LOGGED_USER']['id'],
            [
                'on_success' => function () {
                    echo 'insertionSuccess';
                },
                'on_failure' => function () {
                    echo 'error';
                },
            ],
        );
    }
    exit();
}


# VIEWS

require_once( './views/pages/admin.php' );

