<header class="header">



	<!-- Website logo -->

	<div class="header-logo-wrapper">
		<a 	class="header-logo-link"
			href="index.php"
			title="Retour à l'accueil">
			<img 	class="header-logo"
					src="./assets/images/logo-asign.png"
					alt="Logo AS IGN">
		</a>
	</div>



	<!-- Main menu -->

	<div 	class="header-menu"
			id="header-hidable-menu">

		<button class="button second-color no-border close-button"
				id="header-close-menu-button"
				style="
					--after-image: url('/assets/icons/x-circle.svg');
				">
			Fermer
		</button>


<?php 	if ( isset( $_SESSION['LOGGED_USER'] ) ) { ?>


			<!-- Colapsed account panel -->

			<div class="collapsed-account-panel-wrapper">
				<ul class="account-panel-menu">
					<li>
						<a	class="link second-color"
							href="index.php?action=calendar"
							title="Inscription aux épreuves"
							style="
								--before-image: url('/assets/icons/calendar-week.svg');
							">
							Inscription aux épreuves
						</a>
					</li>
					<li>
						<a	class="link second-color"
							href="index.php?action=personalResults"
							title="Mes résultats"
							style="
								--before-image: url('/assets/icons/clipboard-data.svg');
							">
							Mes résultats
						</a>
					</li>
<?php 				if ( is_null( $_SESSION['LOGGED_USER']['teamId'] ) ) { ?>
						<li>
							<a	class="link second-color"
								href="/?action=authentification&requestTeamRegister"
								title="Rejoindre une équipe"
								style="
									--before-image: url('/assets/icons/people.svg');
								">
								Rejoindre une équipe
							</a>
						</li>
<?php 				} else { ?>
						<li>
							<a	class="link second-color"
								href="/?action=team"
								title="Mon équipe"
								style="
									--before-image: url('/assets/icons/people.svg');
								">
								Mon équipe
							</a>
						</li>
<?php 				} ?>

<?php 				if ( isset( $_SESSION['LOGGED_USER']['isAdmin'] ) ) { ?>
						<li>
							<a	class="link second-color"
								href="/?action=admin"
								title="Espace administrateur"
								style="
									--before-image: url('/assets/icons/pencil-square.svg');
								">
								Espace administrateur
							</a>
						</li>
<?php 				} ?>

				</ul>

				<form	class="account-panel-disconnect"
						action="?action=authentification"
						method="POST">
					<label class="form-label form-label-submit">
						<input	class="button second-color"
								type="submit"
								name="logout"
								value="Se déconnecter">
					</label>
				</form>
			</div>


<?php 	} else { ?>


			<!-- Colapsed connection button -->

			<button class="button second-color
						login-panel-button-open"
					id="collapsed-login-button"
					style="
						--before-image: url('/assets/icons/person-circle.svg');
					">
				Se connecter
			</button>


<?php 	} ?>



		<!-- Navigation -->

		<nav>
			<ul class="header-navigation">
<?php			foreach ( $navData as $navItem ) { ?>
					<li class="header-navigation-input">
						<a 	class="link second-color
<?php 							if ( $navItem["tag"] === $pageTag ) { ?>
									current-page
<?php 							} else { ?>
									no-underline
<?php 							} ?>"
							href=
<?php 							echo $navItem["link"]; ?>
							title="">
<?php 						echo $navItem["name"]; ?>
						</a>
					</li>
<?php 			} ?>
			</ul>
		</nav>

	</div>



	<!-- Burger button -->

	<button class="button second-color no-border burger-button"
			id="header-open-menu-button"
			style="
				--after-image: url('/assets/icons/list.svg');
			">
	</button>



	<!-- Expanded connection button -->

	<div class="header-account-toggle">

<?php 	if ( isset( $_SESSION['LOGGED_USER'] ) ) { ?>
			<button class="button second-color no-border"
					id="account-panel-button-open"
					style="
						--after-image: url('/assets/icons/chevron-down.svg');
					">
<?php 			echo $_SESSION['LOGGED_USER']['firstName'].' '
					.$_SESSION['LOGGED_USER']['name']; ?>
			</button>
<?php 	} else { ?>
			<button class="button second-color no-border
						login-panel-button-open"
					style="
						--before-image: url('/assets/icons/person-circle.svg');
					">
				Se connecter
			</button>
<?php 	} ?>

	</div>



	<!-- Expanded account panel -->

	<div	class="account-panel-wrapper"
			id="account-panel-wrapper">

		<div class="account-panel">

			<ul class="account-panel-menu">
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
<?php 			if ( is_null( $_SESSION['LOGGED_USER']['teamId'] ) ) { ?>
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
<?php 			} else { ?>
					<li>
						<a	class="link first-color no-underline"
							href="/?action=team"
							title="Mon équipe"
							style="
								--before-image: url('/assets/icons/people.svg');
							">
							Mon équipe
						</a>
					</li>
<?php			} ?>

<?php 			if ( $_SESSION['LOGGED_USER']['isAdmin'] ) { ?>
					<li>
						<a	class="link first-color no-underline"
							href="/?action=admin"
							title="Espace administrateur"
							style="
								--before-image: url('/assets/icons/pencil-square.svg');
							">
							Espace administrateur
						</a>
					</li>
<?php 			} ?>
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



</header>

