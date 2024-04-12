<div	class="account-panel-wrapper"
		id="account-panel-wrapper">

	<div class="account-panel">

		<ul class="account-panel-menu">
			<li>
				<a	class="link first-color no-underline"
					href=""
					title=""
					style="
						--before-image: url('/assets/icons/file-earmark-person.svg');
					">
					Mes données personnelles
				</a>
			</li>
			<li>
				<a	class="link first-color no-underline"
					href="index.php?action=calendar"
					title="Inscription aux épreuves"
					style="
						--before-image: url('/assets/icons/calendar-week.svg');
					">
					Inscription aux épreuves
				</a>
			</li>
			<li>
				<a	class="link first-color no-underline"
					href="index.php?action=personalResults"
					title="Mes résultats"
					style="
						--before-image: url('/assets/icons/clipboard-data.svg');
					">
					Mes résultats
				</a>
			</li>
<?php 		if ( is_null( $_SESSION['LOGGED_USER']['team'] ) ) { ?>
				<li>
					<a	class="link first-color no-underline"
						href="/?action=authentification&requestTeamRegister"
						title="Rejoindre une équipe"
						style="
							--before-image: url('/assets/icons/people.svg');
						">
						Rejoindre une équipe
					</a>
				</li>
<?php 		} ?>
		</ul>

		<form	action="?action=authentification"
				method="POST">
			<label class="form-label form-label-submit">
				<input	class="button first-color full-button"
						type="submit"
						name="logout"
						value="Se déconnecter">
			</label>
		</form>

	</div>

</div>

