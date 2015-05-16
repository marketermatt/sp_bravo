<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * register widget areas
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * function that registers all widget areas
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_widgets_init() {
	/////////////////////////////////////////////////////
	// sitewide widgets
	/////////////////////////////////////////////////////	
	// check to see if sitewide sidebar widget is turned on
	if ( sp_get_option( 'sitewide_sidebars_enable', 'is', 'on' ) ) {
		$sidebars = array( 'Left', 'Right' );
		
		foreach ( $sidebars as $sidebar ) {
			register_sidebar( array(
				'name'			=>  sprintf( __( 'Sidebar %s (Sitewide)', 'sp-theme' ), $sidebar ),
				'id'			=> 'sidebar-' . strtolower( $sidebar ) . '-sitewide',
				'description'	=> sprintf( __( 'Sidebar %s (Sitewide)', 'sp-theme' ), $sidebar ),
				'before_widget'	=> '<div id="%1$s" class="widget-container %2$s clearfix">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h3 class="widget-title"><span>',
				'after_title'	=> '</span></h3>',
			) );
		}

		register_sidebar( array(
			'name'			=>  sprintf( __( 'Sidebar %s (Sitewide)', 'sp-theme' ), 'Site Top' ),
			'id'			=> 'sidebar-site-top',
			'description'	=> sprintf( __( 'Sidebar %s (Sitewide)', 'sp-theme' ), 'Site Top' ),
			'before_widget'	=> '<div id="%1$s" class="widget-container %2$s clearfix">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h3 class="widget-title"><span>',
			'after_title'	=> '</span></h3>',
		) );		
	}

	/////////////////////////////////////////////////////
	// custom page widgets
	/////////////////////////////////////////////////////	
	if ( sp_get_option( 'custom_page_widget', 'isset' ) && is_array( sp_get_option( 'custom_page_widget' ) ) ) {
		$page_ids = sp_get_option( 'custom_page_widget' );
				
		foreach ( $page_ids as $page ) {
			// check if locations are set
			if ( sp_get_option( 'custom_page_widget_' . $page . '_locations', 'isset' ) && is_array( sp_get_option( 'custom_page_widget_' . $page . '_locations' ) ) ) {
				// get the page widget locations
				$locations = sp_get_option( 'custom_page_widget_' . $page . '_locations' );

				foreach( $locations as $location ) {
					if ( $page != 0 ) {
						register_sidebar( array(
							'name'			=> sprintf( __( '%s: %s Only', 'sp-theme' ), ucwords( str_replace( '-', ' ', $location ) ), get_the_title( $page ) ),
							'id'			=> str_replace( ' ', '-', strtolower( $location ) ) . '-page-' . $page,
							'description'	=> sprintf( __( '%s', 'sp-theme' ), 'The widgets in this area will only show on this particular page.' ),
							'before_widget'	=> '<div id="%1$s" class="widget-container %2$s clearfix">',
							'after_widget'	=> '</div>',
							'before_title'	=> '<h3 class="widget-title"><span>',
							'after_title'	=> '</span></h3>',
						) );
					}
				}
			}
		}
	}
	
	/////////////////////////////////////////////////////
	// blog category widgets
	/////////////////////////////////////////////////////	
	if ( sp_get_option( 'custom_blog_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_blog_category_widget' ) ) ) {
		$cat_ids = sp_get_option( 'custom_blog_category_widget' );
				
		foreach ( $cat_ids as $cat ) { 
			// check if locations are set
			if ( sp_get_option( 'custom_blog_category_widget_' . $cat . '_locations', 'isset' ) && is_array( sp_get_option( 'custom_blog_category_widget_' . $cat . '_locations' ) ) ) {
				// get the page widget locations
				$locations = sp_get_option( 'custom_blog_category_widget_' . $cat . '_locations' );

				foreach( $locations as $location ) { 
					if ( $cat != 0 ) {
						$cat_obj = get_term( $cat, 'category' );
						
						if ( ! is_object( $cat_obj ) )
							continue;
						
						register_sidebar( array(
							'name'			=> sprintf( __( '%s: %s Only', 'sp-theme' ), ucwords( str_replace( '-', ' ', $location ) ), $cat_obj->name ),
							'id'			=> str_replace( ' ', '-', strtolower( $location ) ) . '-blog-category-' . $cat,
							'description'	=> sprintf( __( '%s', 'sp-theme' ), 'The widgets in this area will only show on this particular page.' ),
							'before_widget'	=> '<div id="%1$s" class="widget-container %2$s clearfix">',
							'after_widget'	=> '</div>',
							'before_title'	=> '<h3 class="widget-title"><span>',
							'after_title'	=> '</span></h3>',
						) );
					}
				}
			}
		}
	}
	
	/////////////////////////////////////////////////////
	// product category widgets
	/////////////////////////////////////////////////////	
	if ( sp_get_option( 'custom_product_category_widget', 'isset' ) && is_array( sp_get_option( 'custom_product_category_widget' ) ) ) {
		$cat_ids = sp_get_option( 'custom_product_category_widget' );
		
		foreach ( $cat_ids as $cat ) { 
			// check if locations are set
			if ( sp_get_option( 'custom_product_category_widget_' . $cat . '_locations', 'isset' ) && is_array( sp_get_option( 'custom_product_category_widget_' . $cat . '_locations' ) ) ) {
				// get the page widget locations
				$locations = sp_get_option( 'custom_product_category_widget_' . $cat . '_locations' );

				foreach( $locations as $location ) {  
					if ( $cat != 0 ) { 
						// get the name of the product category
						$cat_name = sp_get_term_name( $cat );

						// continue if object found
						if ( $cat_name ) {
							register_sidebar( array(
								'name'			=> sprintf( __( '%s: %s Only', 'sp-theme' ), ucwords( str_replace( '-', ' ', $location ) ), $cat_name ),
								'id'			=> str_replace( ' ', '-', strtolower( $location ) ) . '-product-category-' . $cat,
								'description'	=> sprintf( __( '%s', 'sp-theme' ), 'The widgets in this area will only show on this particular page.' ),
								'before_widget'	=> '<div id="%1$s" class="widget-container %2$s clearfix">',
								'after_widget'	=> '</div>',
								'before_title'	=> '<h3 class="widget-title"><span>',
								'after_title'	=> '</span></h3>',
							) );
						}
					}
				}
			}
		}
	}
	
	/////////////////////////////////////////////////////
	// footer widgets
	/////////////////////////////////////////////////////	
	$footer_widget_area_columns = sp_get_option( 'footer_widget_area_columns' );

	if ( $footer_widget_area_columns != '' ) {
		for ( $i = 1; $i <= $footer_widget_area_columns; $i++ ) {
			register_sidebar( array(
				'name'			=> sprintf( __( 'Footer Widget Area Column %d', 'sp-theme' ), $i ),
				'id'			=> 'footer-widget-area-col-' . $i,
				'description'	=> sprintf( __( 'Footer Widget Area Column %d', 'sp-theme' ), $i ),
				'before_widget'	=> '<div id="%1$s" class="widget-container %2$s clearfix footer-widget">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h3 class="widget-title"><span>',
				'after_title'	=> '</span></h3>',
			) );
		}
	}

	/////////////////////////////////////////////////////
	// pb page widgets
	/////////////////////////////////////////////////////	
	$page_ids = get_all_page_ids();

	foreach( $page_ids as $id ) {
		// get saved modules
		$allmodules = get_post_meta( $id, '_sp_page_builder_modules', true );

		if ( ! empty( $allmodules ) && ! is_array( $allmodules ) ) {
			$allmodules = maybe_unserialize( base64_decode( $allmodules ) );

			if ( is_array( $allmodules ) ) {
				foreach( $allmodules['row'] as $row ) {
					if ( isset( $row['column'] ) ) {
						foreach( $row['column'] as $column ) {
							if ( isset( $column['module'] ) ) {
								foreach( $column['module'] as $module ) {
									if ( key( $module ) === 'widget_area' ) {
										register_sidebar( array(
											'name'			=> $module['widget_area'],
											'id'			=> str_replace( array( ' ', '(', ')' ), '', strtolower( trim( $module['widget_area'] ) ) ),
											'description'	=> __( 'Page Builder Widget Area', 'sp-theme' ),
											'before_widget'	=> '<div id="%1$s" class="widget-container %2$s clearfix pd-widget">',
											'after_widget'	=> '</div>',
											'before_title'	=> '<h3 class="widget-title"><span>',
											'after_title'	=> '</span></h3>',
										) );
									}	
								}
							}
						}
					}
				}
			}		
		}
	}

	/*
	$footer_widget_area_2_columns = sp_get_option( 'footer_widget_area_2_columns' );

	if ( $footer_widget_area_2_columns != '' ) {
		for ( $i = 1; $i <= $footer_widget_area_2_columns; $i++ ) {
			register_sidebar( array(
				'name'			=> sprintf( __( 'Footer Widget Area 2 Column %d', 'sp-theme' ), $i ),
				'id'			=> 'footer-widget-area-2-' . $i,
				'description'	=> sprintf( __( 'Footer Widget Area 2 Column %d', 'sp-theme' ), $i ),
				'before_widget'	=> '<div id="%1$s" class="widget-container %2$s clearfix footer-widget">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '</h3>',
			) );
		}
	}

	// site top widget area
	register_sidebar( array(
		'name'			=> __( 'Site Top Widget', 'sp-theme' ),
		'id'			=> 'site-top-widget',
		'description'	=> __( 'Site Top Widget Area which is a widget area above the header.', 'sp-theme' ),
		'before_widget'	=> '<div id="%1$s" class="site-top-widget widget-container %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',		
	) );

	// site bottom widget area
	register_sidebar( array(
		'name'			=> __( 'Site Bottom Widget', 'sp-theme' ),
		'id'			=> 'site-bottom-widget',
		'description'	=> __( 'Site Bottom Widget Area which is a widget area below the footer.', 'sp-theme' ),
		'before_widget'	=> '<div id="%1$s" class="site-bottom-widget widget-container %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',	
	) );

	// page top widget area
	register_sidebar( array(
		'name'			=> __( 'Page Top Widget', 'sp-theme' ),
		'id'			=> 'page-top-widget',
		'description'	=> __( 'Page Top Widget Area which is a widget area on top of the page but below the header.', 'sp-theme' ),
		'before_widget'	=> '<div id="%1$s" class="page-top-widget widget-container %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',	
	) );

	// page bottom widget area
	register_sidebar( array(
		'name'			=> __( 'Page Bottom Widget', 'sp-theme' ),
		'id'			=> 'page-bottom-widget',
		'description'	=> __( 'Page Bottom Widget Area which is a widget area below the page but above the footer.', 'sp-theme' ),
		'before_widget'	=> '<div id="%1$s" class="page-bottom-widget widget-container %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',	
	) );
	*/
	return true;
}
add_action( 'widgets_init', '_sp_widgets_init' );