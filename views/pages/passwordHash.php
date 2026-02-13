<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<title>Olympiades 2026<?php echo $pageTitle ?></title>
	</head>

	<body>

		<form id="form">
			<label>
				Valeur du mot de passe (à transmettre par mail à l'utilisateur)
				<input type="text" name="newpass">
			</label>
			<input type="submit" value="calculer le hash">
		</form>

		<p>
			Le hash du mot de passe (à remplacer dans la base de données) est : <span id="hash"></span>
		</p>

		<script type="text/javascript">
			const form = document.getElementById('form');
			form.addEventListener(
				'submit',
				(event) => {
					event.preventDefault();
					const formData = new FormData(form);
					fetch(
						'index.php?action=passwordHash',
						{
							method: 'POST',
							body: formData,
						},
					).then(response => response.text()).then((response) => {
						document.getElementById('hash').innerHTML = response;
					});
				},
			);
		</script>
	</body>

</html>
