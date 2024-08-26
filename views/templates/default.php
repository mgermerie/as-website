<!DOCTYPE html>
<html lang="fr">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<title>Olympiades 2024 - <?php echo $pageTitle ?></title>

		<link rel="stylesheet" href="./assets/styles/constants.css">
		<link rel="stylesheet" href="./assets/styles/style.css">

<?php	if ( isset( $pageHead ) ) { ?>
<?php		echo $pageHead ?>
<?php	} ?>

	</head>

	<body>

<?php	require_once( './views/includes/header.php' ); ?>
<?php	require_once( './views/includes/footer.php' ); ?>
<?php	require_once( './views/includes/error-panels.php' ); ?>
<?php	require_once( './views/includes/authentification-panels.php' ); ?>

<?php	echo $pageContent ?>

		<script	src="/assets/js/forms-submission.js"></script>
		<script	src="/assets/js/authentification-panels.js"></script>
		<script src="/assets/js/header.js"></script>
		<script	src="/assets/js/account-panel.js"></script>
		<script	src="/assets/js/error-panel.js"></script>

	</body>

</html>

