<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title special-font">
			Informations / Reglement
		</h1>
		<p class="page-description">
			Retrouvez sur cette page la liste des épreuves, le règlement des
			olympiades ainsi qu'une carte des emplacements des différentes
			épreuves.
		</p>
	</div>


	<section class="page-section">

		<h2 class="page-section-title">
			Liste et emplacements des épreuves
		</h2>

		<div class="info-page-map-wrapper">

			<div class="info-page-map-list-container">

				<p class="info-page-map-list-description">
					Cliquez sur une épreuve pour voir son ou ses emplacements
					sur la carte
				</p>

				<div class="info-page-map-list-wrapper">
					<h3 class="info-page-map-list-title">
						Épreuves individuelles
					</h3>
					<ul	class="info-page-map-list"
						id="individual-events">
					</ul>
				</div>

				<div class="info-page-map-list-wrapper">
					<h3 class="info-page-map-list-title">
						Épreuves par équipes
					</h3>
					<ul	class="info-page-map-list"
						id="team-events">
					</ul>
				</div>

			</div>

			<div	class="info-page-map"
					id="events-locations">
			</div>

		</div>

	</section>


	<section class="page-section">
		<h2 class="page-section-title">
			Règlement des épreuves
		</h2>
		<div class="info-page-section-content-wrapper">
			<p class="info-page-section-text">
				Vous pouvez retrouver aux liens ci-dessous le règlement de
				l'édition 2026 des olympiades, ainsi que le barème.
			</p>
		</div>
		<div class="info-page-section-content-wrapper rules-links-wrapper">
			<a	class="button button-link first-color full-button large-button
					info-page-rules-link"
				href="./data/rules/reglement.pdf"
				target="_blank"
				title="Voir le règlement (pdf)"
				style="
					--after-image: url('/assets/icons/file-earmark-pdf.svg');
				">
				Voir le règlement (pdf)
			</a>
			<a	class="button button-link first-color full-button large-button
					info-page-rules-link"
				href="./data/rules/bareme.pdf"
				target="_blank"
				title="Voir le barème (pdf)"
				style="
					--after-image: url('/assets/icons/file-earmark-pdf.svg');
				">
				Voir le barème (pdf)
			</a>
		</div>
	</section>


	<section class="page-section">
		<h2 class="page-section-title">
			Conditions de participation
		</h2>
		<div class="info-page-section-content-wrapper">
			<p class="info-page-section-text">
				La participation à l'édition 2026 des olympiades est ouverte à
				tous les agents et agentes de l'IGN, qu'ils ou elles soient à
				Saint-Mandé ou en Direction Territoriale.
			</p>
			<p class="info-page-section-text">
				La participation est toutefois conditionnée une adhésion active
				à l'association sportive de l'IGN durant cette même année. À
				défaut d'adhésion, le participant devra s'acquiter d'un forfait
				de 3 euros auprès de l'association sportive de l'IGN.
			</p>
		</div>
	</section>

</div>


<template id="event-list-input-template">
	<li class="info-page-event-input">
		<button class="link first-color info-page-event-link"></button>
	</li>
</template>


<link	rel="stylesheet"
		href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
		integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
		crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
		integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
		crossorigin=""></script>

<script src="/assets/js/map.js"></script>


<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

