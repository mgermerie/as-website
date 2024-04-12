<?php ob_start(); ?>


<div class="page-content-wrapper">


	<div class="page-banner">
		<h1 class="page-title">
			Participants
		</h1>
		<p class="page-description">
			Retrouvez sur cette page la liste des participants et participantes
			à l'édition 2024 des olympiades, qu'ils ou elles soient en équipe ou
			en solitaire.
		</p>
	</div>


	<section class="page-section">

		<h2 class="page-section-title">
			Équipes
		</h2>

		<div class="team-cards-wrapper">

<?php 		foreach ( $teamsWithUsers as $team ) { ?>

				<div class="team-card">

					<h3 class="team-card-title">
<?php 					echo $team['name']; ?>
					</h3>

					<section class="team-card-section">

						<h4 class="team-card-section-title">
							Membres de l'équipe
						</h4>

<!-- TEMP : label layout
-->

						<div class="contestants-page-members-wrapper in-card">
<?php						foreach ( $team['members'] as $member ) { ?>
								<p class="contestants-page-member">
<?php								echo $member['first_name'].' '
										.$member['name']; ?>
								</p>
<?php						} ?>
						</div>

<!-- TEMP : table layout

						<table class="team-card-members">
							<tbody>
<?php							foreach ( $team['members'] as $member ) { ?>
									<tr class="team-card-members-row">
										<td class="team-card-members-left-column">
<?php										echo $member['first_name']; ?>
										</td>
										<td class="team-card-members-right-column">
<?php										echo $member['name']; ?>
										</td>
									</tr>
<?php							} ?>
							</tbody>
						</table>
-->

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
<?php		foreach ( $teamLessUsers as $member ) { ?>
				<p class="contestants-page-member">
<?php				echo $member['first_name'].' '
						.$member['name']; ?>
				</p>
<?php		} ?>
		</div>

	</section>

</div>


<?php $pageContent = ob_get_clean(); ?>

<?php require_once( './views/templates/default.php' ); ?>
