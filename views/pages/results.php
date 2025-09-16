<?php ob_start(); ?>

<link rel="stylesheet" href="/node_modules/gridjs/dist/theme/mermaid.min.css">

<?php $pageHead = ob_get_clean(); ?>


<?php ob_start(); ?>


<div class="page-content-wrapper">


	<?php if ( empty( $eventsWithResults ) ) { ?>

		<div class="page-banner">

			<h1 class="page-title special-font">
				Resultats
			</h1>

		</div>

		<section class="page-section">

			<div class="results-page-section-image"></div>

			<h2 class="page-section-title no-data-available">
				Il ne peut pas y avoir de résultats s'il n'y a pas encore eu d'épreuves...
			</h2>

		</section>

	<?php } else { ?>

		<div class="page-banner has-tabs-bar">

			<h1 class="page-title special-font">
				Resultats
			</h1>


			<ul class="page-tabs-bar">

				<li class="page-tab-name">

					<button	class="page-tab-button active"
							id="tab-button-individual">
						Épreuves individuelles
					</button>

				</li>

				<li class="page-tab-name">

					<button	class="page-tab-button"
							id="tab-button-team">
						Épreuves par équipe
					</button>

				</li>

				<?php foreach ( $eventsWithResults as $event ) { ?>

					<li class="page-tab-name">

						<button	class="page-tab-button"
								id="tab-button-<?php echo $event['title']; ?>">

							<?php echo $event['title']; ?>

						</button>

					</li>

				<?php } ?>

			</ul>

		</div>

		<section	class="page-section page-tab"
					id="tab-individual">

			<h2 class="page-section-title">
				Résultats des épreuves individuelles
			</h2>

			<div id="results-container"></div>

		</section>

		<section	class="page-section page-tab"
					id="tab-team">

			<h2 class="page-section-title">
				Résultats des épreuves par équipe
			</h2>

			<div id="results-container-team"></div>

		</section>

		<?php foreach ( $eventsWithResults as $event ) { ?>

			<section	class="page-section page-tab"
						id="tab-<?php echo $event['title']; ?>">

				<h2 class="page-section-title">
					Résultats des épreuves de
					<?php echo $event['title']; ?>
				</h2>

				<div id="results-container-<?php echo $event['title']; ?>"></div>
			</section>

		<?php } ?>

	<?php } ?>

</div>



<script src="/node_modules/gridjs/dist/gridjs.production.min.js"></script>

<script src="/assets/js/constants.js"></script>

<script src="/assets/js/table/Table.js"></script>
<script src="/assets/js/tabs/Tabs.js"></script>

<?php if ( !empty( $eventsWithResults ) ) { ?>
	<script src="/assets/js/pages/results.js"></script>
<?php } ?>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

