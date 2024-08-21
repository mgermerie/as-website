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
				<h3 class="team-card-title">
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
			Encadrement des épreuves
		</h2>

		<div class="info-page-section-content-wrapper">
			<p class="info-page-section-text">
				Votre équipe peut s'engager à encadrer une ou plusieurs
				épreuves qui ont lieu à Saint-Mandé. L'équipe se verra alors
				accorder un bonus.
			</p>
			<p class="info-page-section-text">
				Pour ce faire, votre responsable d'équipe peut inscrire
				votre équipe à l'encadrement d'une ou plusieurs épreuves sur
				la page du calendrier. L'inscription de votre équipe à
				l'encadrement d'une épreuve vous engage à ce que
				suffisamment de vos coéquipiers et coéquipières soient
				présents le jour de l'épreuve. Vous devrez alors assurer le
				bon déroulement de l'épreuve, ainsi que le recueil des
				résultats.
			</p>
		</div>

		<div class="info-page-section-content-wrapper">
<?php 		if ( $referedEvents ) { ?>
				<p class="info-page-section-text">
					Votre équipe est inscrite à l'encadrement des épreuves
					suivantes :
				</p>
				<ul class="page-section-list">
<?php				foreach ( $referedEvents as $event ) { ?>
						<li>
<?php						echo $event['title'] ?>
							le
							<strong>
<?php							echo $event['day_name'].' '
									.$event['day'].' '
									.$event['month_name'] ?>
							</strong>
						</li>
<?php				} ?>
				</ul>
<?php		} else { ?>
				<p class="info-page-section-text">
					Votre équipe n'est pas inscrite à l'encadrement d'une
					épreuve.
				</p>
<?php		} ?>
		</div>

	</section>

	<section class="page-section">

		<h2 class="page-section-title">
			Responsable d'équipe
		</h2>

		<div class="info-page-section-content-wrapper">
			<p class="info-page-section-text">
				Votre responsable d'éqipe est
				<span class="contestants-page-member">
<?php				echo $teamLeader['first_name']; ?>
					<span class="contestants-page-member-name">
<?php					echo $teamLeader['name']; ?>
					</span>
				</span>
			</p>
			<p class="info-page-section-text">
				Le ou la responsable d'équipe est la personne qui a créé
				l'équipe sur ce site web. Ce rôle l'engage à inscrire son
				équipe à l'encadrement d'une ou plusieurs épreuves sur la
				page du calendrier, chose qu'il ou elle est le seul ou la
				seule à pouvoir faire.
			</p>
		</div>

	</section>


</div>


<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>

