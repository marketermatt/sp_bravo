<?php 
global $page, $paged, $post;
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js <?php echo sp_get_browser_agent(); ?>" id="top">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php
if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'theme_slug_render_title' );
endif;
?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<noscript><p class="noscript"><?php _e( 'This site requires JavaScript.  Please enable it in your browser settings.', 'sp-theme' ); ?></p></noscript>
<!--[if lte IE 7]><p class="noscript"><?php _e( 'It appears you\'re using a very old Internet Explorer browser version.  Please update to the latest version to view this site properly.', 'sp-theme' ); ?></p><![endif]-->

<div id="wrap-all">
	<div class="layout-container <?php echo sp_site_layout(); ?>">
	<?php do_action( 'sp_before_main_header_container' ); ?>
	<header id="main-header">
		<?php
		// check to see if we need to show top bar
		if ( sp_get_option( 'show_top_bar', 'is', 'on' ) ) {
		?>
			<div id="top-bar">
				<div class="container">
					<div class="row">
						<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">
							<?php sp_get_menu( 'top-bar-menu' ); ?>
							<div class="left-content">
							<?php echo sp_top_bar_left_content(); ?>
							</div><!--close .left-content-->
						</div><!--close .column-->

						<div class="header-search-column <?php echo sp_column_css( '12', '12', '', '6' ); ?>">
							<?php 
							if ( sp_get_option( 'display_search', 'is', 'on' ) )
								sp_display_search_field();

							sp_woo_exists() ? sp_display_wishlist_compare_icons() : '';
							?>
						</div><!--close .column-->
					</div><!--close .row-->
				</div><!--close container-->
			</div><!--close #top-bar-->
		<?php
		}
		?>

		<div id="brand-container" class="clearfix">
			<?php if ( get_theme_mod( 'site_layout', 'full' ) === 'full' )
				$container_class = 'container';
			else
				$container_class = '';
			?>
			<div class="<?php echo esc_attr( $container_class ); ?>">
				<div class="row login-row">
					<?php
					// login/signup
					sp_display_login_links();    	
					?>
				</div><!--close .row-->
				
				<div class="row cart-row">
					<?php sp_display_header_meta_icons(); ?>
				</div><!--close .row-->

				<div class="row logo-row">
					<!--LOGO-->
					<?php echo sp_display_logo(); ?>
					<!--END LOGO-->
					<br />
					<!--TAGLINE-->
					<?php echo sp_display_tagline(); ?>
					<!--END TAGLINE-->
				</div><!--close .row-->

				<div class="row social-media-row">
					<?php
					// check if we need to display icons here
					if ( sp_get_option( 'show_social_media_icons', 'is', 'on' ) )
						echo '<div class="profile-icon-wrap">' . sp_social_media_profile_icons() . '</div>';
					?>
				</div><!--close .row-->
			</div><!--close .container-->
		</div><!--close #brand-container-->
	</header>

	<div class="nav-wrap">
		<div class="container">

			<div class="row">
					<!--PRIMARY MENU-->
					<?php sp_get_menu( 'primary-menu' ); ?>
					<!--END PRIMARY MENU-->

					<a href="#" title="<?php _e( 'Toggle Menu', 'sp-theme' ); ?>" class="mobile-menu-button sp-tooltip" data-placement="top" data-toggle="tooltip"><i class="icon-reorder"></i></a>

			</div><!--close .row-->

			<div class="row mobile-menu-container">
				<?php sp_get_menu( 'mobile-menu' ); ?>
			</div><!--close .row-->

		</div><!--close .container-->
			
	</div><!--close .nav-wrap-->
	<?php do_action( 'sp_after_main_nav_container' ); ?>