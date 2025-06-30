<?php


$pageTitle = 'Mon équipe';
$pageTag = 'team';


# MODELS

require_once( './models/DatabaseManager.php' );
require_once( './models/TeamsManager.php' );
require_once( './models/navigation.php' );


$navData = get_nav_items();


$database = new DatabaseManager();

$teamsManager = new TeamsManager( $database );
$team = $_SESSION['LOGGED_USER']['team'];
$teamName = $team['name'];
$teamMembers = $teamsManager->get_team_members( $team );
$teamLeader = $teamsManager->get_team_leader_name( $team );


# VIEWS

require_once( './views/pages/team.php' );

