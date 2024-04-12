<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title">
			Résultats
		</h1>
	</div>

	<section class="page-section results-page-section">
		<h2 class="page-section-title results-page-section-title">
			Il n'y a pas encore de résultats à afficher...
		</h2>
	</section>
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

