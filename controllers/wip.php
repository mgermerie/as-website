<?php


$pageTitle='Work in progress';
$pageTag='wip';


# MODELS

# Header navigation
require_once( './models/navigation.php' );
$navData = get_nav_items();


# VIEWS

require_once( './views/pages/wip.php' );

