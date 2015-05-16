<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * custom post types
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

// add to init action hook
add_action( 'init', '_sp_register_post_types' );

/**
 * function to register custom post types and taxonomies
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_register_post_types() {
	// portfolio post type 
	$labels = array(
		'name' 					=> _x( 'Portfolio Entries', 'post type general name', 'sp-theme' ),
		'singular_name' 		=> _x( 'Portfolio Entry', 'post type singular name', 'sp-theme' ),
		'menu_name'				=> _x( 'Portfolios', 'post type menu name', 'sp-theme' ),	
		'all_items'				=> __( 'All Portfolios', 'sp-theme' ),
		'add_new' 				=> _x( 'Add New', 'portfolio', 'sp-theme' ),
		'add_new_item' 			=> __( 'Add New Portfolio Entry', 'sp-theme' ),
		'edit_item' 			=> __( 'Edit Portfolio Entry', 'sp-theme' ),
		'new_item' 				=> __( 'New Portfolio Entry', 'sp-theme' ),
		'view_item' 			=> __( 'View Portfolio Entry', 'sp-theme' ),
		'search_items' 			=> __( 'Search Portfolio Entries', 'sp-theme' ),
		'not_found' 			=> __( 'No Portfolio Entries found', 'sp-theme' ),
		'not_found_in_trash' 	=> __( 'No Portfolio Entries found in Trash', 'sp-theme' ), 
		'parent_item_colon' 	=> ''
	);
		
	$args = array(
		'labels' 			=> $labels,
		'public' 			=> true,
		'show_ui' 			=> true,
		'show_in_menu'		=> true,
		'menu_position'		=> 40,
		'capability_type' 	=> 'post',
		'hierarchical' 		=> false,
		'query_var' 		=> true,
		'show_in_nav_menus'	=> false,
		'menu_icon'			=> '',
		'rewrite'			=> array( 'slug' => 'portfolio' ),
		'supports' 			=> array( 'title', 'thumbnail', 'excerpt', 'editor', 'comments' )
	);

	register_post_type( 'sp-portfolio', $args );

	// registers the portfolio categories
	$labels = array(
		'name' 				=> _x( 'Portfolio Categories', 'taxonomy general name', 'sp-theme' ),
		'singular_name' 	=> _x( 'Portfolio Category', 'taxonomy singular name', 'sp-theme' ),
		'search_items' 		=> __( 'Search Categories', 'sp-theme' ),
		'all_items' 		=> __( 'All Categories', 'sp-theme' ),
		'parent_item' 		=> __( 'Parent Category', 'sp-theme' ),
		'parent_item_colon' => __( 'Parent Category:', 'sp-theme' ),
		'edit_item' 		=> __( 'Edit Category', 'sp-theme' ), 
		'update_item' 		=> __( 'Update Category', 'sp-theme' ),
		'add_new_item' 		=> __( 'Add New Category', 'sp-theme' ),
		'new_item_name' 	=> __( 'New Category Name', 'sp-theme' ),
		'menu_name' 		=> __( 'Categories', 'sp-theme' ),
	); 	

	register_taxonomy( 
		'sp-portfolio-categories', 
		array( 'sp-portfolio' ), 
		array(	'labels'			=> $labels,
				'hierarchical' 		=> true, 
				'query_var' 		=> true,
				'show_admin_column'	=> true,
				'rewrite'			=> array( 'slug' => 'portfolio-category' )
		) 
	);  

	// registers tags for portfolio entries
	$labels = array(
		'name' 				=> _x( 'Portfolio Tags', 'taxonomy general name', 'sp-theme' ),
		'singular_name' 	=> _x( 'Portfolio Tag', 'taxonomy singular name', 'sp-theme' ),
		'search_items' 		=> __( 'Search Tags', 'sp-theme' ),
		'all_items' 		=> __( 'All Tags', 'sp-theme' ),
		'parent_item' 		=> __( 'Parent Tag', 'sp-theme' ),
		'parent_item_colon' => __( 'Parent Tag:', 'sp-theme' ),
		'edit_item' 		=> __( 'Edit Tag', 'sp-theme' ), 
		'update_item' 		=> __( 'Update Tag', 'sp-theme' ),
		'add_new_item' 		=> __( 'Add New Tag', 'sp-theme' ),
		'new_item_name' 	=> __( 'New Tag Name', 'sp-theme' ),
		'menu_name' 		=> __( 'Tags', 'sp-theme' ),
	); 	

	register_taxonomy( 
		'sp-portfolio-tags', 
		array( 'sp-portfolio' ), 
		array( 	'labels'			=> $labels,
				'hierarchical' 		=> false, 
				'query_var' 		=> true,
				'show_admin_column'	=> true,
				'rewrite'			=> array( 'slug' => 'portfolio-tag' )
	) );  

	// testimonial post type 
	$labels = array(
		'name' 					=> _x( 'Testimonial Entries', 'post type general name', 'sp-theme' ),
		'singular_name' 		=> _x( 'Testimonial Entry', 'post type singular name', 'sp-theme' ),
		'menu_name'				=> _x( 'Testimonials', 'post type menu name', 'sp-theme' ),	
		'all_items'				=> __( 'All Testimonials', 'sp-theme' ),
		'add_new' 				=> _x( 'Add New', 'Testimonial', 'sp-theme' ),
		'add_new_item' 			=> __( 'Add New Testimonial Entry', 'sp-theme' ),
		'edit_item' 			=> __( 'Edit Testimonial Entry', 'sp-theme' ),
		'new_item' 				=> __( 'New Testimonial Entry', 'sp-theme' ),
		'view_item' 			=> __( 'View Testimonial Entry', 'sp-theme' ),
		'search_items' 			=> __( 'Search Testimonial Entries', 'sp-theme' ),
		'not_found' 			=> __( 'No Testimonial Entries found', 'sp-theme' ),
		'not_found_in_trash' 	=> __( 'No Testimonial Entries found in Trash', 'sp-theme' ), 
		'parent_item_colon' 	=> ''
	);
		
	$args = array(
		'labels' 			=> $labels,
		'public' 			=> true,
		'show_ui' 			=> true,
		'show_in_menu'		=> true,
		'menu_position'		=> 40,
		'capability_type' 	=> 'post',
		'hierarchical' 		=> false,
		'query_var' 		=> true,
		'show_in_nav_menus'	=> false,
		'menu_icon'			=> '',
		'supports' 			=> array( 'title', 'editor' ),
		'rewrite'			=> array( 'slug' => 'testimonial' )
	);

	register_post_type( 'sp-testimonial', $args );	

	// registers the testimonial categories
	$labels = array(
		'name' 				=> _x( 'Testimonial Categories', 'taxonomy general name', 'sp-theme' ),
		'singular_name' 	=> _x( 'Testimonial Category', 'taxonomy singular name', 'sp-theme' ),
		'search_items' 		=> __( 'Search Categories', 'sp-theme' ),
		'all_items' 		=> __( 'All Categories', 'sp-theme' ),
		'parent_item' 		=> __( 'Parent Category', 'sp-theme' ),
		'parent_item_colon' => __( 'Parent Category:', 'sp-theme' ),
		'edit_item' 		=> __( 'Edit Category', 'sp-theme' ), 
		'update_item' 		=> __( 'Update Category', 'sp-theme' ),
		'add_new_item' 		=> __( 'Add New Category', 'sp-theme' ),
		'new_item_name' 	=> __( 'New Category Name', 'sp-theme' ),
		'menu_name' 		=> __( 'Categories', 'sp-theme' ),
	); 	

	register_taxonomy( 
		'sp-testimonial-categories', 
		array( 'sp-testimonial' ), 
		array(	'labels'			=> $labels,
				'hierarchical' 		=> true, 
				'query_var' 		=> true,
				'show_admin_column'	=> true,
				'rewrite'			=> array( 'slug' => 'testimonial-category' )
		) 
	); 

	// carousel post type 
	$labels = array(
		'name' 					=> _x( 'Carousel Groups', 'post type general name', 'sp-theme' ),
		'singular_name' 		=> _x( 'Carousel Group', 'post type singular name', 'sp-theme' ),
		'menu_name'				=> _x( 'Carousels', 'post type menu name', 'sp-theme' ),	
		'all_items'				=> __( 'All Carousels', 'sp-theme' ),
		'add_new' 				=> _x( 'Add New', 'Carousel', 'sp-theme' ),
		'add_new_item' 			=> __( 'Add New Carousel Group', 'sp-theme' ),
		'edit_item' 			=> __( 'Edit Carousel Group', 'sp-theme' ),
		'new_item' 				=> __( 'New Carousel Group', 'sp-theme' ),
		'view_item' 			=> __( 'View Carousel Group', 'sp-theme' ),
		'search_items' 			=> __( 'Search Carousel Groups', 'sp-theme' ),
		'not_found' 			=> __( 'No Carousel Groups found', 'sp-theme' ),
		'not_found_in_trash' 	=> __( 'No Carousel Groups found in Trash', 'sp-theme' ), 
		'parent_item_colon' 	=> ''
	);
		
	$args = array(
		'labels' 				=> $labels,
		'public' 				=> false,
		'show_ui' 				=> true,
		'show_in_menu'			=> true,
		'menu_position'			=> 40,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'exclude_from_search' 	=> true,
		'query_var' 			=> true,
		'show_in_nav_menus'		=> false,
		'menu_icon'				=> '',
		'supports' 				=> array( 'title' ),
		'rewrite'				=> array( 'slug' => 'carousel' )
	);

	register_post_type( 'sp-slider', $args );

	// contact form post type 
	$labels = array(
		'name' 					=> _x( 'Contact Forms', 'post type general name', 'sp-theme' ),
		'singular_name' 		=> _x( 'Contact Form', 'post type singular name', 'sp-theme' ),
		'menu_name'				=> _x( 'Contact Forms', 'post type menu name', 'sp-theme' ),	
		'all_items'				=> __( 'All Contact Forms', 'sp-theme' ),
		'add_new' 				=> _x( 'Add New', 'Contact Form', 'sp-theme' ),
		'add_new_item' 			=> __( 'Add New Contact Form', 'sp-theme' ),
		'edit_item' 			=> __( 'Edit Contact Form', 'sp-theme' ),
		'new_item' 				=> __( 'New Contact Form', 'sp-theme' ),
		'view_item' 			=> __( 'View Contact Form', 'sp-theme' ),
		'search_items' 			=> __( 'Search Contact Forms', 'sp-theme' ),
		'not_found' 			=> __( 'No Contact Forms found', 'sp-theme' ),
		'not_found_in_trash' 	=> __( 'No Contact Forms found in Trash', 'sp-theme' ), 
		'parent_item_colon' 	=> ''
	);
		
	$args = array(
		'labels' 				=> $labels,
		'public' 				=> false,
		'show_ui' 				=> true,
		'show_in_menu'			=> true,
		'menu_position'			=> 41,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'exclude_from_search' 	=> true,
		'query_var' 			=> true,
		'show_in_nav_menus'		=> false,
		'menu_icon'				=> '',
		'supports' 				=> array( 'title' )
	);

	register_post_type( 'sp-contact-form', $args );


	// faq post type 
	$labels = array(
		'name' 					=> _x( 'FAQ Entries', 'post type general name', 'sp-theme' ),
		'singular_name' 		=> _x( 'FAQ Entry', 'post type singular name', 'sp-theme' ),
		'menu_name'				=> _x( 'FAQs', 'post type menu name', 'sp-theme' ),	
		'all_items'				=> __( 'All FAQs', 'sp-theme' ),
		'add_new' 				=> _x( 'Add New', 'FAQ', 'sp-theme' ),
		'add_new_item' 			=> __( 'Add New FAQ Entry', 'sp-theme' ),
		'edit_item' 			=> __( 'Edit FAQ Entry', 'sp-theme' ),
		'new_item' 				=> __( 'New FAQ Entry', 'sp-theme' ),
		'view_item' 			=> __( 'View FAQ Entry', 'sp-theme' ),
		'search_items' 			=> __( 'Search FAQ Entries', 'sp-theme' ),
		'not_found' 			=> __( 'No FAQ Entries found', 'sp-theme' ),
		'not_found_in_trash' 	=> __( 'No FAQ Entries found in Trash', 'sp-theme' ), 
		'parent_item_colon' 	=> ''
	);
		
	$args = array(
		'labels' 			=> $labels,
		'public' 			=> false,
		'show_ui' 			=> true,
		'show_in_menu'		=> true,
		'menu_position'		=> 41,
		'capability_type' 	=> 'post',
		'hierarchical' 		=> false,
		'query_var' 		=> true,
		'show_in_nav_menus'	=> false,
		'menu_icon'			=> '',
		'supports' 			=> array( 'title', 'editor' ),
		'rewrite'			=> array( 'slug' => 'faq' )
	);

	register_post_type( 'sp-faq', $args );	

	// registers the faq categories
	$labels = array(
		'name' 				=> _x( 'FAQ Categories', 'taxonomy general name', 'sp-theme' ),
		'singular_name' 	=> _x( 'FAQ Category', 'taxonomy singular name', 'sp-theme' ),
		'search_items' 		=> __( 'Search Categories', 'sp-theme' ),
		'all_items' 		=> __( 'All Categories', 'sp-theme' ),
		'parent_item' 		=> __( 'Parent Category', 'sp-theme' ),
		'parent_item_colon' => __( 'Parent Category:', 'sp-theme' ),
		'edit_item' 		=> __( 'Edit Category', 'sp-theme' ), 
		'update_item' 		=> __( 'Update Category', 'sp-theme' ),
		'add_new_item' 		=> __( 'Add New Category', 'sp-theme' ),
		'new_item_name' 	=> __( 'New Category Name', 'sp-theme' ),
		'menu_name' 		=> __( 'Categories', 'sp-theme' ),
	); 	

	register_taxonomy( 
		'sp-faq-categories', 
		array( 'sp-faq' ), 
		array(	'labels'			=> $labels,
				'hierarchical' 		=> true, 
				'query_var' 		=> true,
				'show_admin_column'	=> true,
				'rewrite'			=> array( 'slug' => 'faq-category' )
		) 
	); 
	return true;	
}