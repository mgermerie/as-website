<?php


$pageTitle = 'Mes résultats';


# MODELS

require_once( './models/navigation.php' );


$navData = get_nav_items();


# VIEWS

require_once( './views/pages/personalResults.php' );

