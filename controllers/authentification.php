<?php


# MODELS

require_once( './models/AuthentificationManager.php' );
require_once( './models/basics.php' );
require_once( './models/DatabaseManager.php' );
require_once( './models/TeamsManager.php' );


$defaultCallback = function () { redirect( $_SESSION['lastLoadedPage'] ); };


if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
{
    if ( isset( $_POST['login'] ) )
    {
        $database = new DatabaseManager( ['on_failure' => $defaultCallback] );
        $authManager = new AuthentificationManager( $database );

        $authManager->login(
            $_POST['userMail'],
            $_POST['userPassword'],
            [
                'on_success' => $defaultCallback,
                'on_failure' => $defaultCallback,
            ],
        );
    }

    else if ( isset( $_POST['logout'] ) )
    {
        AuthentificationManager::logout();
        redirect( 'index.php' );
    }

    else if ( isset( $_POST['register'] ) )
    {
        $database = new DatabaseManager( ['on_failure' => $defaultCallback] );
        $authManager = new AuthentificationManager( $database );

        if (
            $authManager->register_user(
                $_POST['userMail'],
                $_POST['userPassword'],
                $_POST['userName'],
                $_POST['userFirstName'],
                [ 'on_failure' => $defaultCallback ],
            )
        )
        {
            $authManager->login(
                $_POST['userMail'],
                $_POST['userPassword'],
                [
                    'on_success' => function () {
                        $_SESSION['LOGGED_USER']['needsTeam'] = true;
                        redirect( $_SESSION['lastLoadedPage'] );
                    },
                    'on_failure' => $defaultCallback,
                ],
            );
        }
    }

    else if ( isset( $_POST['registerTeam'] ) )
    {
        $database = new DatabaseManager( ['on_failure' => $defaultCallback] );
        $authManager = new AuthentificationManager( $database );
        $teamsManager = new TeamsManager( $database );

        if ( isset( $_POST['newTeam'] ) && $_POST['newTeam'] !== "" )
        {
            $teamsManager->create_team(
                $_POST['newTeam'],
                [ 'on_failure' => $defaultCallback ],
            );
            $team = $teamsManager->get_team_from_name( $_POST['newTeam'] );
        }
        else {
            $team = $teamsManager->get_team_from_id( $_POST['userTeam'] );
        }

        $authManager->register_team(
            $_SESSION['LOGGED_USER']['id'],
            $team['id'],
            [
                'on_success' => $defaultCallback,
                'on_failure' => $defaultCallback,
            ],
        );
    }
}

if ( $_SERVER['REQUEST_METHOD'] === 'GET' )
{
    if ( isset( $_GET['requestTeamRegister'] ) )
    {
        $_SESSION['LOGGED_USER']['needsTeam'] = true;
        redirect( $_SESSION['lastLoadedPage'] );
    }
}

