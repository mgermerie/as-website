<!-- Login panel -->

<div	class="panel-wrapper invisible"
		id="login-panel-wrapper">

	<div	class="panel"
			id="login-panel">


		<button	class="button first-color no-border full-button
					panel-close-button login-panel-button-close"
				style="
					--after-image: url('/assets/icons/x-circle.svg');
				">
			Fermer
		</button>


		<form	action="/?action=authentification"
				method="POST">

			<fieldset class="form-fieldset">
				<legend	class="form-fieldset-legend">
					Se connecter
				</legend>

				<label class="form-label">
					Votre adresse email*
					<span class="form-label-hint">
						Exemple : nom.prenom@exemple.fr
					</span>
					<input	class="form-input form-input-text"
							type="email"
							name="userMail">
				</label>

				<label class="form-label">
					Votre mot de passe*
					<input	class="form-input form-input-text"
							type="password"
							name="userPassword">
				</label>

				<label class="form-label form-label-submit">
					<span class="form-label-hint">
						* Champs obligatoire
					</span>
				</label>
				<input	class="button first-color full-button
							form-input form-input-submit"
						type="submit"
						name="login"
						value="Se connecter">

			</fieldset>

		</form>


		<button	class="button first-color
					login-panel-button-close register-panel-button-open"
				style="
					--after-image: url('/assets/icons/arrow-right-short.svg');
				">
			Vous n'avez pas encore de compte ? Inscrivez-vous
		</button>


	</div>

</div>



<!-- Regiter user panel -->

<div	class="panel-wrapper invisible"
		id="register-panel-wrapper">

	<div	class="panel"
			id="register-panel">


		<button	class="button first-color no-border full-button
					panel-close-button register-panel-button-close"
				style="
					--after-image: url('/assets/icons/x-circle.svg');
				">
			Fermer
		</button>


		<form	id="form-register"
				action="/?action=authentification"
				method="POST">

			<fieldset class="form-fieldset">

				<legend	class="form-fieldset-legend">
					Inscription
				</legend>

				<label class="form-label">
					Votre prénom*
					<input	class="form-input form-input-text"
							type="text"
							name="userFirstName">
				</label>

				<label class="form-label">
					Votre nom*
					<input	class="form-input form-input-text"
							type="text"
							name="userName">
				</label>

				<label class="form-label">
					Votre taille de T-shirt (c'est une surprise...)
					<select class="form-input form-input-text"
							name="userSize">
						<option value="" selected>
							Choisir une option
						</option>
						<option value="XS">XS</option>
						<option value="S">S</option>
						<option value="M">M</option>
						<option value="L">L</option>
						<option value="XL">XL</option>
						<option value="XXL">XXL</option>
						<option value="XXXL">XXXL</option>
					</select>
				</label>

				<label class="form-label">
					Votre adresse email*
					<span class="form-label-hint">
						Exemple : nom.prenom@exemple.fr
					</span>
					<input	class="form-input form-input-text"
							type="email"
							name="userMail">
				</label>

				<label class="form-label">
					Votre mot de passe*
					<span	class="form-label-hint form-label-error"
							id="password-match-error">
						Les mots de passe saisis ne sont pas identiques.
					</span>
					<input	class="form-input form-input-text
								form-register-password"
							type="password"
							name="userPassword">
				</label>

				<label class="form-label">
					<span class="form-label-hint">
						Confirmez votre mot de passe
					</span>
					<input	class="form-input form-input-text
								form-register-password"
							type="password"
							name="userPassword2">
				</label>

				<label class="form-label row">
					<input	class="form-input form-input-checkbox"
							type="checkbox"
							name="asMember"
							value="1">
					<span class="form-label-bold">
						Je suis adhérent·e à l'AS IGN
					</span>
				</label>

			</fieldset>

			<label class="form-label form-label-submit">
				<span	class="form-label-hint form-label-error"
						id="not-all-fields-error">
					Merci de renseigner tous les champs obligatoires
				</span>
				<span class="form-label-hint">
					* Champs obligatoire
				</span>
				<input	class="button first-color full-button
							form-input form-input-submit"
						type="submit"
						name="register"
						value="Créer mon compte">
			</label>

		</form>


		<button	class="button first-color
					login-panel-button-open register-panel-button-close"
				style="
					--after-image: url('/assets/icons/arrow-right-short.svg');
				">
			Vous avez déjà un compte ? Connectez-vous
		</button>


	</div>

</div>



<!-- Regiter team panel -->

<div	class="panel-wrapper
<?php 		if ( !isset( $needsTeam ) ) { ?>
				invisible
<?php 		} ?>
			"
		id="register-team-panel-wrapper">

	<div	class="panel"
			id="register-team-panel">


		<button	class="button first-color no-border full-button
					panel-close-button register-team-panel-button-close"
				style="
					--after-image: url('/assets/icons/x-circle.svg');
				">
			Fermer
		</button>


		<form	action="/?action=authentification"
				method="POST">

			<fieldset class="form-fieldset">

				<legend	class="form-fieldset-legend">
					Rejoindre une équipe
				</legend>

				<label class="form-label">
					Vous souhaitez rejoindre une équipe existante ?
					<select	class="form-input form-input-text"
							name="userTeam">
						<option value="" selected disabled hidden>
							Sélectionner une équipe
						</option>
<?php 					if ( isset( $teamsList) ) { ?>
<?php						foreach ( $teamsList as $team ) { ?>
								<option value=
<?php 										echo $team["id"] ?>>
<?php 										echo $team["name"] ?>
								</option>
<?php						} ?>
<?php					} ?>
					</select>
				</label>

				<legend	class="form-fieldset-legend small-legend">
					Ou
				</legend>

				<label class="form-label">
					Votre équipe n'existe pas encore ? Créez-la en renseignant
					son nom.
					<span	class="form-label-hint important">
						Vous serez alors le responsable de l'équipe créée et
						aurez à votre charge l'insription de l'équipe à
						l'encadrement des épreuves.
					</span>
					<input	class="form-input form-input-text"
							type="text"
							name="newTeam">
				</label>

			</fieldset>

			<label class="form-label form-label-submit">
				<input	class="button first-color full-button
							form-input form-input-submit"
						type="submit"
						name="registerTeam"
						value="Rejoindre l'équipe">
			</label>

		</form>


		<button	class="button first-color
					register-team-panel-button-close">
			Ne pas rejoindre d'équipe pour l'instant
		</button>

		<span class="form-label-hint">
			Vous pourrez retrouver ce formulaire en cliquant sur le bouton «
			Rejoindre une équipe » de votre espace personnel.
		</span>

	</div>

</div>

