<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title special-font">
			Participants
		</h1>
		<p class="page-description">
			Retrouvez sur cette page la liste des participants et participantes
			à l'édition 2025 des olympiades, qu'ils ou elles soient en équipe ou
			en solitaire.
		</p>
	</div>


	<section class="page-section">

		<h2 class="page-section-title">
			Équipes
		</h2>

		<div class="team-cards-wrapper">

<?php 		if ( empty( $teamsWithUsers ) ) { ?>
				<h3 class="no-data-available">
					Il n'y a pas encore d'équipes. À vous de créer la votre !
				</h3>
<?php 		} ?>

<?php 		foreach ( $teamsWithUsers as $team ) { ?>

				<div class="team-card">

					<h3 class="team-card-title special-font">
<?php 					echo $team['name']; ?>
					</h3>

					<section class="team-card-section">

						<h4 class="team-card-section-title">
							Membres de l'équipe
						</h4>

						<div class="contestants-page-members-wrapper in-card">
<?php						foreach ( $team['members'] as $member ) { ?>
								<p class="contestants-page-member">
<?php								echo $member['first_name'].' '; ?>
									<span class="contestants-page-member-name">
<?php									echo $member['name']; ?>
									</span>
								</p>
<?php						} ?>
						</div>

					</section>

				</div>

	<?php 	} ?>

		</div>

	</section>


	<section class="page-section">

		<h2 class="page-section-title">
			Participants et participantes solitaires
		</h2>

		<div class="contestants-page-members-wrapper">

<?php 		if ( empty( $teamLessUsers ) ) { ?>
				<h3 class="no-data-available">
					Il n'y a pas encore de participantes et participants
					solitaires.
				</h3>
<?php 		} ?>

<?php		foreach ( $teamLessUsers as $member ) { ?>
				<p class="contestants-page-member">
<?php				echo $member['first_name'].' '; ?>
					<span class="contestants-page-member-name">
<?php					echo $member['name']; ?>
					</span>
				</p>
<?php		} ?>

		</div>

	</section>

</div>


<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

