<section	class="page-section page-tab"
			id="tab-event-registration">

	<h2 class="page-section-title">
		Voir les inscriptions
	</h2>

	<p class="info-page-section-text">
		Cliquez sur une épreuve du calendrier pour voir la liste des
		participants qui y sont inscrits.
	</p>

	<div id="calendar-container">
	</div>

</section>


<template id="registrations-panel-template">

<div	class="panel-wrapper"
		id="registrations-panel-wrapper">

	<div	class="panel large-panel"
			id="registrations-panel">

		<button class="button first-color no-border
					panel-close-button registrations-panel-button-close"
				style="
					--after-image: url('/assets/icons/x-circle.svg');
				">
			Fermer
		</button>

		<h3 class="event-panel-title"
			id="registrations-panel-title">
			Event title
		</h3>

		<section class="event-panel-details-section">
			<h4	class="event-panel-section-title">
				Liste des participants inscrits
			</h4>
			<div id="registrations-table-container"></div>
		</section>

		<section class="event-panel-details-section">
			<h4	class="event-panel-section-title">
				Personnes inscrites à l'encadrement
			</h4>
			<div id="registrations-table-container-referee"></div>
		</section>

	</div>

</div>

</template>

