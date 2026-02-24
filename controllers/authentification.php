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
        $teamsManager = new TeamsManager( $database );

        $authManager->login(
            $_POST['userMail'],
            $_POST['userPassword'],
            [
                'on_success' => function () use ( $teamsManager ) {
                    if ( isset( $_SESSION['LOGGED_USER']['teamId'] ) )
                    {
                        $team = $teamsManager->get_team_from_id(
                            $_SESSION['LOGGED_USER']['teamId']
                        );
                        $_SESSION['LOGGED_USER']['team'] = $team;
                        $_SESSION['LOGGED_USER']['teamLeader'] =
                            $team['leader_id'] == $_SESSION['LOGGED_USER']['id'];
                    }
                    redirect( $_SESSION['lastLoadedPage'] );
                },
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
				$_POST['userSize'],
				isset( $_POST['asMember'] ) ? 1 : 0,
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
                $_SESSION['LOGGED_USER']['id'],
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
                'on_success' => function () use ( $team ) {
                    $_SESSION['LOGGED_USER']['team'] = $team;
                    $_SESSION['LOGGED_USER']['teamLeader'] =
                        $team['leader_id'] == $_SESSION['LOGGED_USER']['id'];
                    redirect( $_SESSION['lastLoadedPage'] );
                },
                'on_failure' => $defaultCallback,
            ],
        );
    }

    else if ( isset ( $_POST['changePassword'] ) )
    {
        AuthentificationManager::logout();
        session_start();

        $database = new DatabaseManager( ['on_failure' => $defaultCallback] );
        $authManager = new AuthentificationManager( $database );

        if (
            $authManager->login(
                $_POST['userMail'],
                $_POST['userTempPassword'],
                [
                    'on_failure' => function () {
                        redirect( 'index.php?action=passwordReset' );
                    },
                ],
            )
        )
        {
            $authManager->reset_password(
                $_SESSION['LOGGED_USER']['id'],
                $_POST['userPassword'],
                [
                    'on_success' => function () use ( $database ) {
                        $teamsManager = new TeamsManager( $database );
                        if ( isset( $_SESSION['LOGGED_USER']['teamId'] ) )
                        {
                            $team = $teamsManager->get_team_from_id(
                                $_SESSION['LOGGED_USER']['teamId']
                            );
                            $_SESSION['LOGGED_USER']['team'] = $team;
                            $_SESSION['LOGGED_USER']['teamLeader'] =
                                $team['leader_id'] == $_SESSION['LOGGED_USER']['id'];
                        }
                        redirect( 'index.php' );
                    },
                    'on_failure' => function () {
                        redirect( 'index.php?action=passwordReset' );
                    },
                ],
            );
        }
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

