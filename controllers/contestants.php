<?php


$pageTitle = 'Équipes';
$pageTag = 'contestants';


# MODELS

require_once( './models/DatabaseManager.php' );
require_once( './models/TeamsManager.php' );
require_once( './models/navigation.php' );


$navData = get_nav_items();


$database = new DatabaseManager();

if ( isset( $_SESSION['LOGGED_USER']['needsTeam'] ) )
{
    unset( $_SESSION['LOGGED_USER']['needsTeam'] );
    $needsTeam = true;
}

$teamsManager = new TeamsManager( $database );
$teamsList = $teamsManager->get_teams();


$teamsWithUsers = [];
foreach ( $teamsList as $team )
{
    array_push(
        $teamsWithUsers,
        [
            'name' => $team['name'],
            'members' => $teamsManager->get_team_members( $team ),
        ],
    );
}
$teamLessUsers = $database->get_teamless_users();


# VIEWS

require_once( './views/pages/contestants.php' );

