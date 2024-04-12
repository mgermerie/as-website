<?php


$pageTitle = 'Calendrier';
$pageTag = 'calendar';


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
$eventTypes = $eventsManager->get_event_types();


if ( $_SERVER['REQUEST_METHOD'] === 'GET' )
{
    if ( isset( $_GET['requestUserInfo'] ) )
    {
        if ( isset( $_SESSION['LOGGED_USER'] ) )
        {
            echo json_encode( $_SESSION['LOGGED_USER'] );
        }
        else
        {
            echo json_encode( new stdClass );
        }
        exit();
    }

    else if ( isset( $_GET['requestEventTypes'] ) )
    {
        echo json_encode( $eventsManager->get_event_types() );
        exit();
    }

    else if ( isset( $_GET['start'] ) && isset( $_GET['end'] )
    )
    {
        if ( isset( $_GET['eventType'] ) )
        {
            echo json_encode( $eventsManager->get_typed_events_between_dates(
                $_GET['eventType'],
                $_GET['start'],
                $_GET['end'],
            ) );
        }
        else
        {
            echo json_encode( $eventsManager->get_events_between_dates(
                $_GET['start'],
                $_GET['end'],
            ) );
        }
        exit();
    }
}
else if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset( $_SESSION['LOGGED_USER'] )
)
{
    if ( isset( $_POST['registerToEvent'] ) )
    {
        $eventsManager->register_user_to_event(
            $_SESSION['LOGGED_USER']['id'],
            $_POST['eventId'],
            [
                'on_success' => function () {
                    echo 'registerSuccess';
                },
                'on_failure' => function () {
                    echo 'error';
                },
            ],
        );
    }
    else if ( isset( $_POST['unRegisterFromEvent'] ) )
    {
        $eventsManager->unregister_user_from_event(
            $_SESSION['LOGGED_USER']['id'],
            $_POST['eventId'],
            [
                'on_success' => function () {
                    echo 'unregisterSuccess';
                },
                'on_failure' => function () {
                    echo 'error';
                },
            ],
        );
    }
    else if ( isset( $_POST['removeEvent'] ) )
    {
        $eventsManager->remove_event(
            $_POST['eventId'],
            [
                'on_success' => function () {
                    echo 'removeEventSuccess';
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

require_once( './views/pages/calendar.php' );

