<?php


$pageTitle = 'Accueil';
$pageTag = 'home';


# MODELS

require_once( './models/DatabaseManager.php' );
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


# VIEWS

require_once( './views/pages/homepage.php' );

