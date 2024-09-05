<?php ob_start(); ?>

<link rel="stylesheet" href="/node_modules/gridjs/dist/theme/mermaid.min.css">

<?php $pageHead = ob_get_clean(); ?>


<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner has-tabs-bar">
		<h1 class="page-title">
			Résultats
		</h1>

		<ul class="page-tabs-bar">

			<li class="page-tab-name">
				<button	class="page-tab-button active"
						id="tab-individual-results-button">
					Épreuves individuelles
				</button>
			</li>

			<li class="page-tab-name">
				<button	class="page-tab-button"
						id="tab-team-results-button">
					Épreuves par équipe
				</button>
			</li>

		</ul>
	</div>

	<section	class="page-section page-tab"
				id="tab-individual-results">
		<h2 class="page-section-title">
			Résultats des épreuves individuelles
		</h2>
		<div id="results-container"></div>
	</section>

	<section	class="page-section page-tab"
				id="tab-team-results">
		<h2 class="page-section-title">
			Résultats des épreuves par équipe
		</h2>
		<div id="results-container-team"></div>
	</section>

</div>


<script src="/node_modules/gridjs/dist/gridjs.production.min.js"></script>

<script src="/assets/js/constants.js"></script>

<script src="/assets/js/table/Table.js"></script>
<script src="/assets/js/tabs/Tabs.js"></script>

<script src="/assets/js/pages/results.js"></script>


<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

