<?php if ( isset( $_SESSION['MESSAGE'] ) ) { ?>
	<div class="error-panel-wrapper">

<?php 	foreach ( $_SESSION['MESSAGE'] as $errorCode ) { ?>
<?php 		$error = $errorMessages[$errorCode]; ?>

			<div class="error-panel">

				<button	class="button first-color no-border panel-close-button
							error-panel-close-button"
						style="
							--after-image: url('/assets/icons/x-circle.svg');
						">
				</button>

				<h3 class="error-panel-title">
<?php 				echo $error["title"] ?>
				</h3>

<?php 			foreach ( $error["message"] as $message ) { ?>
					<p class="error-panel-message">
<?php 					echo $message ?>
					</p>
<?php 			} ?>

			</div>

<?php 	} ?>

	</div>

<?php unset( $_SESSION['MESSAGE'] ); ?>
<?php } ?>

