<?php ob_start(); ?>

<link	rel="stylesheet"
		href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
		integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
		crossorigin=""/>

<?php $pageHead = ob_get_clean(); ?>


<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title">
			Calendrier
		</h1>
		<p class="page-description">
			Retrouvez sur cette page le calendrier de l'édition 2024 des
			olympiades. Cliquez sur un évènement pour vous y inscrire.
		</p>
<?php	if ( isset( $_SESSION['LOGGED_USER']['isAdmin'] )
			&& $_SESSION['LOGGED_USER']['isAdmin'] ) { ?>
			<p class="page-description">
				En tant qu'administrateur, vous pouvez également cliquer sur un
				jour pour y créer un évènement.
			</p>
<?php	} ?>
	</div>

	<section class="page-section">
		<form 	class="calendar-filter-form"
				id="form-event-filters">
			<fieldset 	class="form-fieldset fieldset-event-filters"
						id="event-filters">
				<legend	class="legend-event-filters">
					Filtrer les épreuves
				</legend>
			</fieldset>
			<button	class="button first-color full-button
						calendar-filter-validate">
				Valider
			</button>
		</form>
		<div id="calendar-container">
		</div>
	</section>


</div>


<template id="event-filter-template">
	<label class="calendar-filter-label">
		<input type="checkbox" checked>
	</label>
</template>


<template id="event-panel-template">

	<div	class="panel-wrapper"
			id="event-panel-wrapper">

		<div	class="panel"
				id="event-panel">

			<button class="button first-color no-border
						panel-close-button event-panel-button-close"
					style="
						--after-image: url('/assets/icons/x-circle.svg');
					">
				Fermer
			</button>

			<h3 class="event-panel-title"
				id="event-panel-title">
				Event title
			</h3>

			<section class="event-panel-details-section">
				<div class="event-panel-details-wrapper">
					<p	class="event-panel-text">
						Début
					</p>
					<div class="event-panel-details-value">
						<p	class="event-panel-text"
							id="event-panel-date-start">
						</p>
						<p	class="event-panel-text"
							id="event-panel-time-start">
						</p>
					</div>
				</div>
				<div class="event-panel-details-wrapper">
					<p	class="event-panel-text">
						Fin
					</p>
					<div class="event-panel-details-value">
						<p	class="event-panel-text"
							id="event-panel-date-end">
						</p>
						<p	class="event-panel-text"
							id="event-panel-time-end">
						</p>
					</div>
				</div>
				<div class="event-panel-details-wrapper">
					<p	class="event-panel-text">
						Emplacement
					</p>
					<div class="event-panel-details-value">
						<p	class="event-panel-text"
							id="event-panel-location">
						</p>
					</div>
				</div>

				<a	class="link first-color large-link"
					id="event-panel-rules"
					href=""
					title="Lire le règlement"
					target="_blank"
					style="--after-image:
						url('/assets/icons/box-arrow-right.svg');
					">
					Consulter le règlement de cette épreuve
				</a>
			</section>


			<section 	class="event-panel-registration"
						id="event-panel-registration">

<?php	if ( isset( $_SESSION['LOGGED_USER'] ) ) { ?>

				<form	class="event-panel-registration-form"
						id="form-event-register"
						action=""
						method="POST">

					<fieldset	class="form-fieldset register-user
									event-panel-registration-fieldset">
						<span class="form-label-hint cannot-register-label">
							Vous êtes déjà inscrit pour participer à cette
							épreuve à une autre date. Vous ne pouvez vous
							inscrire qu'à une seule date pour chaque
							épreuve.
						</span>
						<input	class="button first-color full-button
									form-input form-input-submit
									event-register-button"
								type="submit"
								name="registerToEvent"
								value="S'inscrire">
					</fieldset>

					<fieldset	class="form-fieldset unregister-user
									event-panel-registration-fieldset">
						<span class="form-label-hint">
							Vous êtes inscrit pour participer à cette
							épreuve
						</span>
						<input	class="button first-color
									form-input form-input-submit"
								type="submit"
								name="unRegisterFromEvent"
								value="Se désinscrire">
					</fieldset>

<?php		if ( isset( $_SESSION['LOGGED_USER']['teamLeader'] ) ) { ?>
<?php			if ( $_SESSION['LOGGED_USER']['teamLeader'] ) { ?>

					<fieldset	class="form-fieldset register-referee
									event-panel-registration-fieldset">
						<span class="form-label-hint">
							En inscrivant votre équipe à l'encadrement de cette
							épreuve, vous l'engagez à ce que suffisamment de ses
							membres soient présents le jour de l'épreuve pour en
							assurer le bon fonctionnement (explication et
							contrôle du respect des règles, prise en note des
							résultats...).
						</span>
						<span class="form-label-hint">
							En cas d'empêchement, merci de prévenir l'équipe
							d'organisation des olympiades suffisamment en amont
							de l'épreuve.
						</span>
						<span class="form-label-hint">
							Êtes-vous certain·e de vouloir inscrire votre équipe
							à l'encadrement de cette épreuve ?
						</span>
						<input	class="button first-color full-button
									form-input form-input-submit
									event-register-button"
								type="submit"
								name="registerReferee"
								value="Confirmer l'inscription">
						<button	class="button first-color"
								id="cancel-register-referee-button">
							Annuler
						</button>
					</fieldset>

<?php			} ?>
<?php		} else { ?>
<?php		} ?>

<?php		if ( isset( $_SESSION['LOGGED_USER']['isAdmin'] )
				&& $_SESSION['LOGGED_USER']['isAdmin'] ) { ?>

					<fieldset class="form-fieldset remove-event">
						<span class="form-label-hint">
							Êtes-vous certain de vouloir supprimer
							l'épreuve ? Cette action est irréversible.
						</span>
						<button	class="button first-color full-button"
								id="cancel-event-removal-button">
							Annuler
						</button>
						<input	class="button first-color
									form-input form-input-submit"
								type="submit"
								name="removeEvent"
								value="Supprimer l'épreuve">
					</fieldset>

<?php		} ?>

				</form>

<?php		if ( isset( $_SESSION['LOGGED_USER']['teamLeader'] ) ) { ?>
<?php			if ( $_SESSION['LOGGED_USER']['teamLeader'] ) { ?>

				<span class="form-label-hint cannot-register-referee-label">
					Une autre équipe est déjà inscrite à l'encadrement de cette
					épreuve.
				</span>
				<button	class="button first-color
							button-register-referee"
						id="register-referee-button">
					Inscrire mon équipe à l'encadrement
				</button>

<?php			} ?>

				<span	class="form-label-hint important
							registered-referee-label">
					Votre équipe est inscrite à l'encadrement de cette épreuve.
				</span>

<?php		} ?>

<?php		if ( isset( $_SESSION['LOGGED_USER']['isAdmin'] )
				&& $_SESSION['LOGGED_USER']['isAdmin'] ) { ?>

				<button	class="link first-color center-link
							button-remove-event"
						id="event-removal-button"
						style="--after-image:
							url('/assets/icons/x-circle.svg');
						">
					Supprimer l'épreuve
				</button>

<?php		} ?>
<?php	} else { ?>

				<span class="form-label-hint">
					Connectez-vous pour vous inscrire à cette épreuve
				</span>

				<button	class="button first-color full-button
							login-panel-button-open
							event-panel-button-close">
					Se connecter
				</button>

<?php	} ?>

			</section>

		</div>

	</div>

</template>


<template id="event-map-template">
	<div 	class="event-map"
			id="event-map">
	</div>
</template>


<script src="node_modules/fullcalendar/index.global.min.js"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
		integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
		crossorigin=""></script>

<script src="/assets/js/calendar.js"></script>


<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

