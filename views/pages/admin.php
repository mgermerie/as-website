<?php ob_start(); ?>

<link rel="stylesheet" href="/node_modules/gridjs/dist/theme/mermaid.min.css">

<?php $pageHead = ob_get_clean(); ?>


<?php ob_start(); ?>


<div class="page-content-wrapper">

	<div class="page-banner has-tabs-bar">
		<h1 class="page-title">
			Espace administrateur
		</h1>

		<ul class="page-tabs-bar">

			<li class="page-tab-name">
				<button	class="page-tab-button active"
						id="tab-event-registration-button">
					Voir les inscriptions
				</button>
			</li>

			<li class="page-tab-name">
				<button	class="page-tab-button"
						id="tab-add-results-button">
					Ajouter des résultats
				</button>
			</li>

		</ul>
	</div>

<?php require_once( './views/includes/admin-space/show-registrations.php' ); ?>
<?php require_once( './views/includes/admin-space/insert-result.php' ); ?>

</div>


<script src="node_modules/fullcalendar/index.global.min.js"></script>
<script src="/node_modules/gridjs/dist/gridjs.production.min.js"></script>

<script src="/assets/js/tabs/Tabs.js"></script>
<script src="/assets/js/calendar/Calendar.js"></script>
<script src="/assets/js/table/Table.js"></script>

<script src="/assets/js/pages/admin.js"></script>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>
