<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title">
			Mes résultats
		</h1>
		<p class="page-description">
			Retrouvez sur cette page vos résultats personnels, ainsi que ceux de
			votre équipe si vous en avez rejoint une.
		</p>
	</div>

	<section class="page-section results-page-section">
		<h2 class="page-section-title results-page-section-title">
			Il n'y a pas encore de résultats à afficher...
		</h2>
	</section>
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

