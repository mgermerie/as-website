<?php ob_start(); ?>

<?php require_once( './views/includes/header.php' ); ?>

<h1>Page en cours de construction</h1>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

