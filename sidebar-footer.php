<?php 
global $post;
$sitewide_widgets = '';

$hide_sidebars = sp_get_option( 'hide_footer_sidebars_on_xs_mobile' );

if ( $hide_sidebars === 'on' )
	$hide_sidebars = 'hidden-xs';
else
	$hide_sidebars = '';

// get current page/post's sitewide widget check
// this is to see if we need to apply any post specific widgets
if ( is_object( $post ) )
	$sitewide_widgets = get_post_meta( $post->ID, '_sp_custom_layout_disable_sitewide_widgets', true );

$columns = sp_get_option( 'footer_widget_area_columns' );
$column_class = sp_calc_footer_columns( $columns );
?>

<aside id="sidebar-footer" class="sidebar container <?php echo esc_attr( $hide_sidebars ); ?> hidden-print">
	<div class="row">
	<?php
	/////////////////////////////////////////////////////
	// footer widgets
	/////////////////////////////////////////////////////		
	// show sitewide sidebar widgets if current post does not have specific widgets assigned
	if ( sp_get_option( 'sitewide_sidebars_enable', 'is', 'on' ) && $sitewide_widgets !== 'on' ) {
		echo '<div class="widget-wrapper">';
		
		// loop through each column
		for ( $i = 1; $i <= $columns; $i++ ) {
			echo '<div class="' . esc_attr( $column_class ) . '">';

			// check if sidebar is active
			if ( is_active_sidebar( 'footer-widget-area-col-' . $i ) ) {						
				dynamic_sidebar( 'footer-widget-area-col-' . $i );			
			}

			echo '</div><!--close .column-->';
		}

		echo '</div><!--close .widget-wrapper-->';
	}
	?>    
	</div><!--close row-->
</aside><!--close .sidebar-->