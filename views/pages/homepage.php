<?php ob_start(); ?>


<div class="page-content-wrapper">

	<div class="home-page-banner">

		<div class="home-page-background-image"></div>
		<div class="home-page-blur-filter"></div>

		<div class="home-page-title-wrapper">
			<h2 class="home-page-subtitle">
				<img	class="home-page-subtitle-image"
						src="/assets/images/pizza.png"
						alt="Image d'une pizza représentant la lettre O">
				lympiades IGN 2026
			</h2>
			<h1 class="home-page-title special-font">
				Année de l'Italie
			</h1>
		</div>

			<div class="home-page-call-to-action">

<?php		if ( isset( $_SESSION['LOGGED_USER'] ) ) { ?>
				<a	class="button button-link first-color
						full-button large-button"
					href="/?action=calendar"
					title="Calendrier des épreuves"
					style="
						--after-image: url('/assets/icons/calendar-week.svg');
					">
					Calendrier des épreuves
				</a>
<?php		} else { ?>
				<button class="button first-color full-button large-button
							register-panel-button-open"
						style="
							--after-image: url('/assets/icons/person-add.svg');
						">
						Inscription
				</button>
<?php		} ?>

		</div>

	</div>

</div>


<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

