<?php ob_start(); ?>

<link rel="stylesheet" href="/node_modules/gridjs/dist/theme/mermaid.min.css">

<?php $pageHead = ob_get_clean(); ?>

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

	<?php if ( $hasResults ) { ?>

		<div class="personal-results-wrapper">

			<section class="page-section">

				<h2 class="page-section-title">
					Vos résultats
				</h2>

				<div id="results-container-self"></div>

			</section>

			<section class="page-section">

				<h2 class="page-section-title">
					Les résultats de votre équipe
				</h2>

				<div id="results-container-team"></div>

			</section>

			<section class="page-section">

				<h2 class="page-section-title">
					Les résultats de vos coéquipiers
				</h2>

				<div id="results-container-mates"></div>

			</section>

		</div>

	<?php } else { ?>

		<section class="page-section">

			<div class="results-page-section-image"></div>

			<h2 class="page-section-title no-data-available">
				Il ne peut pas y avoir de résultats si vous ou votre équipe
				n'avez pas encore participé à une épreuve...
			</h2>

		</section>

	<?php } ?>

</div>


<script src="/node_modules/gridjs/dist/gridjs.production.min.js"></script>

<script src="/assets/js/constants.js"></script>

<script src="/assets/js/table/Table.js"></script>
<script src="/assets/js/tabs/Tabs.js"></script>

<?php if ( $hasResults ) { ?>
	<script src="/assets/js/pages/personalResults.js"></script>
<?php } ?>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

