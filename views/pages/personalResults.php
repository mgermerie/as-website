<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title special-font">
			Mes resultats
		</h1>
		<p class="page-description">
			Retrouvez sur cette page vos résultats personnels, ainsi que ceux de
			votre équipe si vous en avez rejoint une.
		</p>
	</div>

	<section class="page-section">
		<div class="results-page-section-image"></div>
		<h2 class="page-section-title no-data-available">
			Il ne peut pas y avoir de résultats s'il n'y a pas encore eu d'épreuves...
		</h2>
	</section>
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

