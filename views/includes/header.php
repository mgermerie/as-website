<header class="header">


	<div class="header-logo-wrapper">
		<img 	class="header-logo"
				src="./assets/images/logo-asign.png"
				alt="Logo AS IGN">
	</div>


	<nav>
		<ul class="header-navigation">
<?php		foreach ( $navData as $navItem ) { ?>
				<li class="header-navigation-input">
					<a 	class="link second-color
<?php 						if ( $navItem["tag"] === $pageTag ) { ?>
								current-page
<?php 						} else { ?>
								no-underline
<?php 						} ?>"
						href=
<?php 						echo $navItem["link"]; ?>
						title="">
<?php 					echo $navItem["name"]; ?>
					</a>
				</li>
<?php 		} ?>
		</ul>
	</nav>


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


</header>
