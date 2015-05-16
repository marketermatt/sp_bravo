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
?>
<h3><?php _e( 'Order Details', 'sp-theme' ); ?></h3>

<ul class="order_details clearfix">
	<li class="order">
		<?php _e( 'Order:', 'sp-theme' ); ?>
		<strong><?php echo $order->get_order_number(); ?></strong>
	</li>
	<li class="date">
		<?php _e( 'Date:', 'sp-theme' ); ?>
		<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
	</li>
	<li class="status">
		<?php _e( 'Status:', 'sp-theme' ); ?>
		<?php $status = get_term_by( 'slug', $order->status, 'shop_order_status' ); ?>
		<strong><?php echo wc_get_order_status_name( $order->get_status() ); ?></strong>
	</li>
</ul>

<table class="shop_table order_details">
	<thead>
		<tr>
			<th class="product-image"></th>
			<th class="product-name"><?php _e( 'Product', 'sp-theme' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'sp-theme' ); ?></th>
			<th class="product-total"><?php _e( 'Total', 'sp-theme' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if (sizeof($order->get_items())>0) {

			foreach($order->get_items() as $item) {
				$_product     = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
				$item_meta    = new WC_Order_Item_Meta( $item['item_meta'] );

				if ( is_object( $_product ) )
					$image = sp_get_image( get_post_thumbnail_id( $_product->id ), 60, 60, true );
				else
					$image = sp_get_image( get_post_thumbnail_id( 0 ), 60, 60, true );
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_table_item_class', 'order_table_item', $item, $order ) ); ?>">
					<td class="product-image"><img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" /></td>
						
					<td class="product-name">
						<?php
							if ( $_product && ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );
							else
								echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['product_id'] ), $item['name'] ), $item );

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

					<td class="product-quantity">
						<?php
							echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item['qty'] ) . '</strong>', $item );
						?>
					</td>
					<?php

					echo '<td class="product-total">' . $order->get_formatted_line_subtotal( $item ) . '</td></tr>';
			
				// Show any purchase notes
				if ( $order->has_status( array( 'completed', 'processing' ) ) ) {
					if ($purchase_note = get_post_meta( $_product->id, '_purchase_note', true))
						echo '<tr class="product-purchase-note"><td colspan="3">' . apply_filters('the_content', $purchase_note) . '</td></tr>';
				}

			}
		}

		do_action( 'woocommerce_order_items_table', $order );
		?>
	</tbody>
</table>

<div class="row">
	<div class="<?php echo sp_column_css( '', '', '', '4', '', '', '8' ); ?>">
		<table class="summary">
			<?php
				if ( $totals = $order->get_order_item_totals() ) foreach ( $totals as $total ) :
					?>
					<tr class="<?php echo strtolower( str_replace( ':', '', str_replace( ' ', '-', $total['label'] ) ) ); ?>">
						<th scope="row"><?php echo $total['label']; ?></th>
						<td><?php echo $total['value']; ?></td>
					</tr>
					<?php
				endforeach;
			?>
		</table>

		<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
	</div><!--close .column-->
</div><!--close .row-->

<header>
	<h3><?php _e( 'Customer details', 'sp-theme' ); ?></h3>
</header>
<dl class="customer_details">
<?php
	if ($order->billing_email) echo '<dt>'.__( 'Email:', 'sp-theme' ).'</dt><dd>'.$order->billing_email.'</dd>';
	if ($order->billing_phone) echo '<dt>'.__( 'Telephone:', 'sp-theme' ).'</dt><dd>'.$order->billing_phone.'</dd>';

	// Additional customer details hook
	do_action( 'woocommerce_order_details_after_customer_details', $order );
?>
</dl>

<?php if (get_option('woocommerce_ship_to_billing_address_only')=='no' && get_option('woocommerce_calc_shipping') !== 'no') : ?>

<div class="row addresses">

	<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">

<?php endif; ?>

		<header class="title">
			<h3><?php _e( 'Billing Address', 'sp-theme' ); ?></h3>
		</header>
		<address><p>
			<?php
				if (!$order->get_formatted_billing_address()) _e( 'N/A', 'sp-theme' ); else echo $order->get_formatted_billing_address();
			?>
		</p></address>

<?php if (get_option('woocommerce_ship_to_billing_address_only')=='no' && get_option('woocommerce_calc_shipping') !== 'no') : ?>

	</div><!--close .column-->

	<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">

		<header class="title">
			<h3><?php _e( 'Shipping Address', 'sp-theme' ); ?></h3>
		</header>
		<address><p>
			<?php
				if (!$order->get_formatted_shipping_address()) _e( 'N/A', 'sp-theme' ); else echo $order->get_formatted_shipping_address();
			?>
		</p></address>

	</div><!--close .column-->

</div><!--close .row-->

<?php endif; ?>
