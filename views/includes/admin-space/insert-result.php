<section	class="page-section page-tab"
			id="tab-add-results">

	<h2 class="page-section-title">
		Ajouter des résultats
	</h2>

	<p class="info-page-section-text">
		Cliquez sur une épreuve du calendrier pour y ajouter un résultat.
	</p>

	<div id="results-calendar-container">
	</div>

</section>


<template id="insert-result-panel-template">

<div	class="panel-wrapper"
		id="insert-result-panel-wrapper">

	<div	class="panel large-panel"
			id="insert-result-panel">

		<button class="button first-color no-border
					panel-close-button insert-result-panel-button-close"
				style="
					--after-image: url('/assets/icons/x-circle.svg');
				">
			Fermer
		</button>

		<h3 class="event-panel-title"
			id="insert-result-panel-title">
		</h3>

		<section class="event-panel-details-section">

			<h4	class="event-panel-section-title">
				Ajouter un nouveau résultat pour cette épreuve
			</h4>

			<form	class=""
					id="form-add-result"
					action=""
					method="POST">
				<fieldset class="">
					<label class="">
						Prénom et nom du participant
						<input	class=""
								type="text"
								name="contestantName"
								list="contestantsList">
						<datalist id="contestantsList">
		<?php 				if ( isset( $contestantsList ) ) { ?>
		<?php 					foreach ( $contestantsList as $contestant ) { ?>
									<option value="
		<?php 								echo $contestant["first_name"].
												' '.$contestant["name"]; ?>"
									>
		<?php 							echo $contestant["first_name"].' '
											.$contestant["name"]; ?>
									</option>
		<?php 					} ?>
		<?php 				} ?>
						</datalist>
					</label>

					<label class="">
						Performance à l'épreuve
						<input	class=""
								id="performance-input"
								type="text"
								name="performance">
					</label>

					<label class="">
						Score
						<input	class=""
								id="score-input"
								type="text"
								name="score">
					</label>

				</fieldset>
			</form>

		</section>

		<section class="event-panel-details-section">
			<h4	class="event-panel-section-title">
				Résultats déjà enregistrés pour cette épreuve
			</h4>
			<div id="insert-result-table-container"></div>
		</section>

	</div>

</div>

</template>

