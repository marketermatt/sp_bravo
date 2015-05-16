<?php
/* Template Name: Product Wishlist */
get_header();
 
global $current_user;

$current_user = wp_get_current_user();

$displaying_saved_wishlist = false;

// get wishlist items
if ( isset( $_REQUEST['product_wishlist_ids'] ) ) {
	$wishlist_ids = $_REQUEST['product_wishlist_ids'];

	$wishlist_ids = explode( ',', $wishlist_ids );

} elseif ( isset( $_COOKIE['sp_product_wishlist'] ) ) {
	$wishlist_ids = maybe_unserialize( $_COOKIE['sp_product_wishlist'] );

	// sanitize the cookie
	is_array( $wishlist_ids ) ? array_walk_recursive( $wishlist_ids, 'sp_clean_multi_array' ) : null;
}

// get saved wishlists
$saved_wishlists = get_user_meta( $current_user->ID, '_sp_product_wishlist', true );

// get account url of the relative ecommerce plugin
if ( sp_woo_exists() )
    $account_url = get_permalink( woocommerce_get_page_id( 'myaccount' ) );
?>

	<header class="page-header">
		<div class="container">
			<?php sp_display_page_title(); ?>
			<?php sp_display_breadcrumbs(); ?>
		</div><!--close .container-->
	</header><!-- .page-header -->

	<div class="container main-container">
		
		<?php do_action( 'sp_wishlist_layout_before_content_row' ); ?>

		<section id="primary" role="main" class="row wishlist-page">

			<div class="<?php echo sp_column_css( '', '', '', '3' ); ?>">
				<nav class="account-nav">
					<h3><?php _e( 'My Account', 'sp-theme' ); ?></h3>
					<ul>
						<?php if ( is_user_logged_in() ) { ?>
						<li><a href="<?php echo esc_url( $account_url ); ?>" title="<?php esc_attr_e( 'Back to My Account', 'sp-theme' ); ?>" class="back-to-account-link"><i class="icon-angle-left" aria-hidden="true"></i><?php _e( 'Back to My Account', 'sp-theme' ); ?></a></li>
						<?php } else { ?>
						<li><a href="<?php echo esc_url( $account_url ); ?>" title="<?php esc_attr_e( 'Login / Register', 'sp-theme' ); ?>"><?php _e( 'Login / Register', 'sp-theme' ); ?> <i class="icon-angle-right" aria-hidden="true"></i></a></li>
						<?php } ?>
					</ul>
				</nav>
			</div><!--close .column-->

			<div class="content <?php echo sp_column_css( '', '', '', '9' ); ?>">

				<?php 
				if ( sp_woo_exists() ) {
					wc_print_notices();

					// display saved wishlists
					if ( isset( $_GET['wishlist'] ) && ! empty( $_GET['wishlist'] ) ) {

						$displaying_saved_wishlist = true;

						$wishlist_name = sanitize_text_field( $_GET['wishlist'] );
						
						echo '<h3 class="wishlist-name">' . __( 'Wishlist Name:', 'sp-theme' ) . ' ' . $wishlist_name . '</h3>' . PHP_EOL;

						$wishlist_ids = isset( $saved_wishlists[$wishlist_name] ) ? $saved_wishlists[$wishlist_name] : '';
					}

					if ( isset( $wishlist_ids ) && ! empty( $wishlist_ids ) )
						echo sp_woo_product_wishlist_html( $wishlist_ids ); 
					else
						echo '<p>' . __( 'There are no items in your wishlist.', 'sp-theme' ) . '</p>' . PHP_EOL;
				}

				// don't show action buttons if displaying saved wishlist
				if ( ! $displaying_saved_wishlist ) {
				?>
				<div class="wishlist-action row">
					<?php
					// check if users can register than show save button
					if ( sp_users_can_register() && isset( $wishlist_ids ) && ! empty( $wishlist_ids ) ) {
						$output = '';

						// check if user is logged in
						if ( is_user_logged_in() ) {
						
							$output .= '<p>' . PHP_EOL;
							$output .= '<label>' . __( 'Save Wishlist', 'sp-theme' ) . '</label>' . PHP_EOL;
							$output .= '<select name="product_wishlist_save_type" class="select2-select">' . PHP_EOL;
							$output .= '<option value="0">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;
							$output .= '<option value="new">' . __( 'Save New Wishlist', 'sp-theme' ) . '</option>' . PHP_EOL;

							// if there are existing saved wishlists
							if ( $saved_wishlists ) 
								$output .= '<option value="existing">' . __( 'Save to Existing Wishlist', 'sp-theme' ) . '</option>' . PHP_EOL;

							$output .= '</select>' . PHP_EOL;
							$output .= '</p>' . PHP_EOL;

							$output .= '<p class="new">';
							$output .= '<label>' . __( 'New Wishlist Name', 'sp-theme' ) . '</label>' . PHP_EOL;
							$output .= '<input type="text" name="wishlist_name" value="" class="form-control" /><br />' . PHP_EOL;
							$output .= '<a href="" title="' . __( 'Save Wishlist', 'sp-theme' ) . '" class="save-wishlist button" data-wishlist-type="new">' . __( 'Save Wishlist', 'sp-theme' ) . '</a>' . PHP_EOL;
							$output .= '</p>';

							if ( isset( $saved_wishlists ) && $saved_wishlists ) {
								$output .= '<p class="existing">';
								$output .= '<label>' . __( 'Save to Existing Wishlist', 'sp-theme' ) . '</label>' . PHP_EOL;
								$output .= '<select name="existing_wishlist" class="select2-select">' . PHP_EOL;

								foreach ( $saved_wishlists as $saved_wishlist_name => $v ) {
									$output .= '<option value="' . esc_attr( $saved_wishlist_name ) . '">' . $saved_wishlist_name . '</option>';
								}

								$output .= '</select><br /><br />' . PHP_EOL;
								$output .= '<a href="" title="' . __( 'Save Wishlist', 'sp-theme' ) . '" class="save-wishlist button" data-wishlist-type="existing">' . __( 'Save Wishlist', 'sp-theme' ) . '</a>' . PHP_EOL;
								$output .= '</p>';						
							}
						} else {
							_e( 'Please login or register to save wishlist to your account.', 'sp-theme' );
						?>
						<?php
						}

						echo $output;
					}
					?>
				</div><!--close .wishlist-action-->
				<?php
				}
				?>
				<a href="#" title="<?php _e( 'Email Wishlist', 'sp-theme' ); ?>" class="email-product-wishlist-toggle button"><i class="icon-envelope-alt" aria-hidden="true"></i> <?php _e( 'Email Wishlist', 'sp-theme' ); ?></a>

				<div class="email-product-wishlist-container">
					
					<form action="#" method="post" class="wishlist-email-form">
						<div class="form-group"><label class="field-label control-label"><?php _e( 'Email', 'sp-theme' ); ?> <span class="required">*</span></label>
							<div class="controls">
								<input type="email" name="wishlist_email" value="" data-required="required" placeholder="<?php esc_attr_e( 'Email', 'sp-theme' ); ?>" class="form-control" />
							</div><!--close .controls-->
						</div><!--close .form-group-->

						<div class="form-group"><label class="field-label control-label"><?php _e( 'Email Subject', 'sp-theme' ); ?> <span class="required">*</span></label>
							<div class="controls">
								<input type="text" name="wishlist_email_subject" value="" data-required="required" placeholder="<?php esc_attr_e( 'Check out these products.', 'sp-theme' ); ?>" class="form-control" />
							</div><!--close .controls-->
						</div><!--close .form-group-->

						<p class="alert main"><button class="close" data-dismiss="alert" type="button">&times;</button><span class="msg"></span></p>
						<div class="form-actions clearfix">
							<button type="submit" class="btn btn-primary" name="email_product_wishlist" data-wishlist-name="<?php echo esc_attr( isset( $wishlist_name ) ? $wishlist_name : '' ); ?>"><i class="loader" aria-hidden="true"></i> <?php _e( 'Send', 'sp-theme' ); ?></button>
						</div><!--close .form-actions-->

						<?php echo wp_nonce_field( 'sp_submit_email_product_wishlist_form', '_sp_submit_email_product_wishlist_form_nonce', true, false ); ?>						
					</form><!--close .wishlist-email-form-->

				</div><!--clcose .email-product-wishlist-container-->

				<input type="hidden" name="wishlist_type" value="<?php echo $displaying_saved_wishlist ? 'saved' : 'cookie'; ?>" />
				<input type="hidden" name="wishlist_name" value="<?php echo isset( $wishlist_name ) ? $wishlist_name : ''; ?>" />
				<input type="hidden" name="user_id" value="<?php echo isset( $current_user ) ? $current_user->ID : ''; ?>" />

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; // end of the loop. ?>

			</div><!--close .column-->			
		</section><!--close #primary-->

		<?php do_action( 'sp_wishlist_layout_after_content_row' ); ?>

	</div><!--close . container-->
<?php get_footer(); ?>