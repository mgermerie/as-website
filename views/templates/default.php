<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<title>Olympiades 2024 - <?php echo $pageTitle ?></title>

		<link rel="stylesheet" href="./assets/css/constants.css">
		<link rel="stylesheet" href="./assets/css/style.css">
	</head>

	<body>

<?php	require_once( './views/includes/header.php' ); ?>
<?php	require_once( './views/includes/account-panel.php' ); ?>
<?php	require_once( './views/includes/authentification-panels.php' ); ?>
<?php	require_once( './views/includes/error-panels.php' ); ?>
<?php	require_once( './views/includes/footer.php' ); ?>

<?php	echo $pageContent ?>

		<script	src="/assets/js/forms-submission.js"></script>
		<script	src="/assets/js/authentification-panels.js"></script>
		<script	src="/assets/js/account-panel.js"></script>
		<script	src="/assets/js/error-panel.js"></script>

	</body>

</html>

