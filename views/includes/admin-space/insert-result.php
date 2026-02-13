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

		<button class="button first-color full-button no-border
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
				<fieldset class="form-fieldset">
					<label	class="form-label"
							id="insert-individual-result-label">
						Prénom et nom du participant
						<input	class="form-input form-input-text"
								type="text"
								placeholder=
									"Utiliser l'auto-complétion pour éviter les erreurs"
								name="contestantName"
								list="contestantsList">
						<datalist id="contestantsList">
<?php 						if ( isset( $contestantsList ) ) { ?>
<?php 							foreach ( $contestantsList as $contestant ) { ?>
									<option value="
<?php 										echo $contestant["first_name"].
												' '.$contestant["name"]; ?>"
									>
<?php 									echo $contestant["first_name"].' '
											.$contestant["name"]; ?>
									</option>
<?php 							} ?>
<?php 						} ?>
						</datalist>
					</label>

					<label	class="form-label hidden"
							id="insert-team-result-label">
						Nom de l'équipe
						<input	class="form-input form-input-text"
								type="text"
								name="teamName"
								list="teamsList">
						<datalist id="teamsList">
<?php 						if ( isset( $teamsList ) ) { ?>
<?php 							foreach ( $teamsList as $team ) { ?>
									<option value="
<?php 										echo $team["name"]; ?>"
									>
<?php 									echo $team["name"]; ?>
									</option>
<?php 							} ?>
<?php 						} ?>
						</datalist>
					</label>

					<div class="form-fieldset form-horizontal-section">
						<label	class="form-label"
								id="insert-performance-label">
							Performance à l'épreuve
							<input	class="form-input form-input-text"
									id="performance-input"
									type="text"
									name="performance">
						</label>

						<label class="form-label">
							Score
							<input	class="form-input form-input-text"
									id="score-input"
									placeholder="Saisir la performance pour calculer automatiquement le score"
									type="text"
									name="score">
						</label>
					</div>

					<label class="form-label form-label-submit">
						<input	class="button first-color full-button
									form-input form-input-submit"
								type="submit"
								name="insertResult"
								value="Ajouter un résultat">
					</label>

				</fieldset>

			</form>

		</section>

		<section class="event-panel-details-section">
			<h4	class="event-panel-section-title">
				Résultats déjà enregistrés pour cette épreuve (les résultats les
				plus récents apparaissent en premier)
			</h4>
			<div id="insert-result-table-container"></div>
		</section>

	</div>

</div>

</template>

