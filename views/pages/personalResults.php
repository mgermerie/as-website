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

	<section class="page-section only-page-section">
		<h2 class="page-section-title no-data-available
				results-page-section-title">
			Le développement de cette page n'est pas encore fini. Merci de
			patienter encore un peu...
		</h2>
	</section>
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

