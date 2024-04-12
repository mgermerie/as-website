<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title">
			Erreur 505
		</h1>
	</div>

	<section class="page-section only-page-section">
		<h2 class="page-section-title no-data-available">
			Une erreur est survenue sur le serveur de base de données. Merci de
			réessayer ultérieurement. Si le problème persiste, merci de nous
			contacter à l'adresse olympiades@ign.fr
		</h2>
	</section>
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

