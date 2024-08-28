<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<title>Olympiades 2024 - <?php echo $pageTitle ?></title>

		<link rel="stylesheet" href="./assets/styles/constants.css">
		<link rel="stylesheet" href="./assets/styles/style.css">
	</head>

	<body>

<?php	require_once( './views/includes/error-panels.php' ); ?>

		<div	class="panel-wrapper"
				id="toto">

			<div	class="panel"
					id="login-toto">

				<form	id="form-reset-password"
						action="/?action=authentification"
						method="POST">

					<fieldset class="form-fieldset">
						<legend	class="form-fieldset-legend">
							Mise à jour du mot de passe
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
							Votre mot de passe actuel*
							<input	class="form-input form-input-text"
									type="password"
									name="userTempPassword">
						</label>

						<label class="form-label">
							Votre nouveau mot de passe*
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
								Confirmez votre nouveau mot de passe
							</span>
							<input	class="form-input form-input-text
										form-register-password"
									type="password"
									name="userPassword2">
						</label>


						<label class="form-label form-label-submit">
							<span	class="form-label-hint form-label-error"
									id="not-all-fields-error">
								Merci de renseigner tous les champs obligatoires
							</span>
							<span class="form-label-hint">
								* Champs obligatoire
							</span>
						</label>
						<input	class="button first-color full-button
									form-input form-input-submit"
								type="submit"
								name="changePassword"
								value="Mettre à jour">

					</fieldset>

				</form>

			</div>

		</div>

		<script	src="/assets/js/password-reset-submission.js"></script>
		<script	src="/assets/js/error-panel.js"></script>

	</body>

</html>
