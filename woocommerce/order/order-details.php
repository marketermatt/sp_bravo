<?php
/**
 * Order details
 *
 * actual version 2.2.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$order = wc_get_order( $order_id );
$show_full_order_details = apply_filters( 'sp_woo_show_full_order_details', false );

if ( $show_full_order_details ) {
?>
	<h3><span><?php _e( 'Order Details', 'sp-theme' ); ?></span></h2>
	<table class="shop_table order_details">
		<thead>
			<tr>
				<th class="product-name"><?php _e( 'Product', 'sp-theme' ); ?></th>
				<th class="product-total"><?php _e( 'Total', 'sp-theme' ); ?></th>
			</tr>
		</thead>
		<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) foreach ( $totals as $total ) :
				?>
				<tr>
					<th scope="row"><?php echo $total['label']; ?></th>
					<td><?php echo $total['value']; ?></td>
				</tr>
				<?php
			endforeach;
		?>
		</tfoot>
		<tbody>
			<?php
			if ( sizeof( $order->get_items() ) > 0 ) {

				foreach( $order->get_items() as $item ) {
					$_product     = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
					$item_meta    = new WC_Order_Item_Meta( $item['item_meta'] );

					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
						<td class="product-name">
							<?php
								if ( $_product && ! $_product->is_visible() )
									echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );
								else
									echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['product_id'] ), $item['name'] ), $item );

								echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item['qty'] ) . '</strong>', $item );

								$item_meta->display();

								if ( $_product && $_product->exists() && $_product->is_downloadable() && $order->is_download_permitted() ) {

									$download_files = $order->get_item_downloads( $item );
									$i              = 0;
									$links          = array();

									foreach ( $download_files as $download_id => $file ) {
										$i++;

										$links[] = '<small><a href="' . esc_url( $file['download_url'] ) . '">' . sprintf( __( 'Download file%s', 'sp-theme' ), ( count( $download_files ) > 1 ? ' ' . $i . ': ' : ': ' ) ) . esc_html( $file['name'] ) . '</a></small>';
									}

									echo '<br/>' . implode( '<br/>', $links );
								}
							?>
						</td>
						<td class="product-total">
							<?php echo $order->get_formatted_line_subtotal( $item ); ?>
						</td>
					</tr>
					<?php

					if ( $order->has_status( array( 'completed', 'processing' ) ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) ) {
						?>
						<tr class="product-purchase-note">
							<td colspan="3"><?php echo apply_filters( 'the_content', $purchase_note ); ?></td>
						</tr>
						<?php
					}
				}
			}

			do_action( 'woocommerce_order_items_table', $order );
			?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

	<header>
		<h2><?php _e( 'Customer details', 'sp-theme' ); ?></h2>
	</header>
	<dl class="customer_details">
	<?php
		if ($order->billing_email) echo '<dt>'.__( 'Email:', 'sp-theme' ).'</dt><dd>'.$order->billing_email.'</dd>';
		if ($order->billing_phone) echo '<dt>'.__( 'Telephone:', 'sp-theme' ).'</dt><dd>'.$order->billing_phone.'</dd>';

		// Additional customer details hook
		do_action( 'woocommerce_order_details_after_customer_details', $order );
	?>
	</dl>

	<?php if (get_option('woocommerce_ship_to_billing_address_only')=='no' && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

	<div class="col2-set addresses">

		<div class="col-1">

	<?php endif; ?>

			<header class="title">
				<h3><?php _e( 'Billing Address', 'sp-theme' ); ?></h3>
			</header>
			<address><p>
				<?php
					if (!$order->get_formatted_billing_address()) _e( 'N/A', 'sp-theme' ); else echo $order->get_formatted_billing_address();
				?>
			</p></address>

	<?php if (get_option('woocommerce_ship_to_billing_address_only')=='no' && get_option('woocommerce_calc_shipping') !== 'no' ) : ?>

		</div><!-- /.col-1 -->

		<div class="col-2">

			<header class="title">
				<h3><?php _e( 'Shipping Address', 'sp-theme' ); ?></h3>
			</header>
			<address><p>
				<?php
					if (!$order->get_formatted_shipping_address()) _e( 'N/A', 'sp-theme' ); else echo $order->get_formatted_shipping_address();
				?>
			</p></address>

		</div><!-- /.col-2 -->

	</div><!-- /.col2-set -->

	<?php endif; ?>

	<div class="clear"></div>
<?php 
} else {
?>

	<?php
	if (sizeof($order->get_items())>0) {

		foreach($order->get_items() as $item) {

			$_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );

			if ( $_product && $_product->exists() && $_product->is_downloadable() && $order->is_download_permitted() ) {
				
				echo '<h3>' . __( 'Your Downloadable Content', 'sp-theme' ) . '</h3>';

				$download_file_urls = $order->get_downloadable_file_urls( $item['product_id'], $item['variation_id'], $item );

				$i     = 0;
				$links = array();

				foreach ( $download_file_urls as $file_url => $download_file_url ) {

					$filename = woocommerce_get_filename_from_url( $file_url );

					$links[] = '<a href="' . $download_file_url . '">' . sprintf( __( 'Download file%s', 'sp-theme' ), ( count( $download_file_urls ) > 1 ? ' ' . ( $i + 1 ) . ': ' : ': ' ) ) . $filename . '</a>';

					$i++;
				}

				echo implode( '<br/>', $links );
			}

		}
	}

	do_action( 'woocommerce_order_items_table', $order );
	?>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
<?php
}
?>