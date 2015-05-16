<?php
global $post;

if ( ! is_object( $post ) )
	return;

$layout = sp_get_page_layout(); 
$orientation = $layout['orientation'];

if ( $orientation === 'both-sidebars-layout' )
	$span_column = sp_column_css( '', '12', '', '2' );
else
	$span_column = sp_column_css( '', '', '', '3' );

// get current page/post's sitewide widget check
// this is to see if we need to apply any post specific widgets
$sitewide_widgets = get_post_meta( $post->ID, '_sp_page_layout_sitewide_widgets', true );
$hide_sidebars = sp_get_option( 'hide_sidebars_on_xs_mobile' );

if ( $hide_sidebars === 'on' )
	$hide_sidebars = 'hidden-xs';
else
	$hide_sidebars = '';
?>

	<?php if ( is_active_sidebar( 'sidebar-general' ) ) : ?>
		<aside id="sidebar-general" class="sidebar hidden-print <?php echo esc_attr( $hide_sidebars ); ?> <?php echo esc_attr( $span_column ); ?>" role="complementary">
			<div class="widget-wrapper">
				<?php dynamic_sidebar( 'sidebar-general' ); ?>
			</div><!--close .widget-wrapper-->
		</aside><!-- #secondary -->
	<?php endif; ?>