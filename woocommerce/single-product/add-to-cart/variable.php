<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $post;
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart clearfix" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	
	<?php if ( ! empty( $available_variations ) ) : ?>
		<dl class="variations">
			<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
				<dt class="label">
					<label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label>
				</dt>
				<dd class="value"><select id="<?php echo esc_attr( sanitize_title($name) ); ?>" name="attribute_<?php echo sanitize_title($name); ?>">
						<option value=""><?php echo __( 'Choose an option', 'sp-theme' ) ?>&hellip;</option>
						<?php
								if ( is_array( $options ) ) {

									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
									} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
										$selected_value = $selected_attributes[ sanitize_title( $name ) ];
									} else {
										$selected_value = '';
									}

									// Get terms if this is a taxonomy - ordered
									if ( taxonomy_exists( $name ) ) {

										$terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) ) {
												continue;
											}
											echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
										}

									} else {

										foreach ( $options as $option ) {
											echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
										}

									}
								}
						?>
					</select> <?php
						if ( sizeof($attributes) === $loop )
							echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', 'sp-theme' ) . '</a>';
					?>
				</dd>
	        <?php endforeach;?>
		</dl>
		
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap clearfix" style="display:none;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>
			<div class="single_variation"></div>
			<div class="variations_button">
				<input type="hidden" name="variation_id" value="" />
				<?php woocommerce_quantity_input(); ?>
				<?php do_action( 'sp_woocommerce_before_add_to_cart_button' ); ?>
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />

			<input type="hidden" name="variation_id" value="" />
			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>
		<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<?php else : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'sp-theme' ); ?></p>	
	<?php endif; ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>
