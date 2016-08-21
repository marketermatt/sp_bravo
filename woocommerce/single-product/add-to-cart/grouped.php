<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.7
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;

?>

<?php do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="cart" method="post" enctype='multipart/form-data'>
	<ul class="grouped-products">
		<?php foreach ( $grouped_products as $product_id ) : 
			$product = get_product( $product_id );
			$post    = $product->post;
			setup_postdata( $post );			
		?>
			<li class="row">
				<div class="<?php echo sp_column_css( '', '', '', '12' ); ?>">
					<label for="product-<?php echo $product_id; ?>">
						<?php echo $product->is_visible() ? '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' : get_the_title(); ?>
					</label><br />

					<?php do_action ( 'woocommerce_grouped_product_list_before_price', $product ); ?>

					<div class="price-wrap">

					<?php
						echo $product->get_price_html();

						if ( ( $availability = $product->get_availability() ) && $availability['availability'] )
							echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
					?>
					</div><!--close .price-wrap-->
					<br />
					
					<?php if ( $product->is_sold_individually() || ! $product->is_purchasable() ) : ?>
						<?php woocommerce_template_loop_add_to_cart(); ?>
					<?php else : ?>
						<?php
							$quantites_required = true;
							woocommerce_quantity_input( array( 'input_name' => 'quantity[' . $product_id . ']', 'input_value' => '0' ) );
						?>
					<?php endif; ?>

				</div><!--close .column-->

			</li>
		<?php endforeach; 
			wp_reset_postdata();
			$product = get_product( $post->ID );
		?>
	</ul>
	
	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
	
	<?php if ( $quantites_required ) : ?>

		<?php do_action('woocommerce_before_add_to_cart_button'); ?>

		<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>