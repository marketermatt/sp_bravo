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
$sitewide_widgets = get_post_meta( $post->ID, '_sp_custom_layout_disable_sitewide_widgets', true );
$hide_sidebars = sp_get_option( 'hide_sidebars_on_xs_mobile' );

if ( $hide_sidebars === 'on' )
	$hide_sidebars = 'hidden-xs';
else
	$hide_sidebars = '';
?>

<aside id="sidebar-left" class="sidebar hidden-print <?php echo esc_attr( $hide_sidebars ); ?> <?php echo esc_attr( $span_column ); ?>">
	<div class="widget-wrapper">
		<?php
		/////////////////////////////////////////////////////
		// sitewide widgets
		/////////////////////////////////////////////////////		
		// show sitewide sidebar widgets if current post does not have specific widgets assigned
		if ( sp_get_option( 'sitewide_sidebars_enable', 'is', 'on' ) && $sitewide_widgets !== 'on' )
			dynamic_sidebar( 'sidebar-left-sitewide' );

		/////////////////////////////////////////////////////
		// custom page widgets
		/////////////////////////////////////////////////////
		// check if custom page widget is set and is an array
		if ( sp_get_option( 'custom_page_widget', 'isset' ) && is_array( sp_get_option( 'custom_page_widget' ) ) ) {
			// get the page ids
			$page_ids = sp_get_option( 'custom_page_widget' ); // array
			
			// loop through the ids and output each custom widget
			foreach( $page_ids as $page ) {
				// continue if the page id matches the page id set
				if ( $post->ID == $page )
					dynamic_sidebar( 'sidebar-left-page-' . $page );	
			}
		}

		/////////////////////////////////////////////////////
		// custom blog category widgets
		/////////////////////////////////////////////////////
		// check if custom blog widget is set and is an array
		if ( sp_get_option( 'custom_blog_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_blog_category_widget' ) ) ) {
			// get the category ids
			$cat_ids = sp_get_option( 'custom_blog_category_widget' );
			
			// loop through the ids and output each widget
			foreach( $cat_ids as $cat ) {
				// checks if current post category matches the saved settings
				if ( in_category( $cat ) )
					dynamic_sidebar( 'sidebar-left-blog-category-' . $cat );	
			}
		}

		/////////////////////////////////////////////////////
		// custom WOO category widgets
		/////////////////////////////////////////////////////		
		// check if WOO is active
		if ( sp_woo_exists() ) {
			if ( sp_get_option( 'custom_product_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_product_category_widget' ) ) ) {

				// get the product category ids
				$cat_ids = sp_get_option( 'custom_product_category_widget' );

				// loop through the ids and output each widget
				foreach( $cat_ids as $cat ) {
					// checks if it is an array before continuing
					if ( isset( get_queried_object()->term_id ) && get_queried_object()->term_id === (int)$cat ) {
						dynamic_sidebar( 'sidebar-left-product-category-' . $cat );	
					}
				}
			}
		}
?>    
    
	</div><!--close .widget-wrapper-->
</aside><!--close .sidebar-->