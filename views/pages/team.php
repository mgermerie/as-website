<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title">
			Mon équipe
		</h1>
		<p class="page-description">
			Retrouvez sur cette page différentes informations à propos de votre
			équipe.
		</p>
	</div>


	<section class="page-section">

		<div class="team-cards-wrapper">
			<div class="team-card">
				<h3 class="team-card-title special-font">
<?php				echo $teamName; ?>
				</h3>

				<section class="team-card-section">

					<h4 class="team-card-section-title">
						Membres de l'équipe
					</h4>

					<div class="contestants-page-members-wrapper in-card">
<?php					foreach ( $teamMembers as $member ) { ?>
							<p class="contestants-page-member">
<?php							echo $member['first_name'].' '; ?>
								<span class="contestants-page-member-name">
<?php								echo $member['name']; ?>
								</span>
							</p>
<?php					} ?>
					</div>

				</section>
			</div>
		</div>

	</section>

	<section class="page-section">

		<h2 class="page-section-title">
			Responsable d'équipe
		</h2>

		<div class="info-page-section-content-wrapper">
			<p class="info-page-section-text">
				Votre responsable d'équipe est
				<span class="contestants-page-member">
<?php				echo $teamLeader['first_name']; ?>
					<span class="contestants-page-member-name">
<?php					echo $teamLeader['name']; ?>
					</span>
				</span>
			</p>
			<p class="info-page-section-text">
				Le ou la responsable d'équipe est la personne qui a créé
				l'équipe sur ce site web.
			</p>
		</div>

	</section>


</div>


<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

