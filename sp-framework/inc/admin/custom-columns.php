<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * custom columns
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_filter( 'manage_edit-sp-portfolio_columns', '_sp_add_portfolio_columns' ); 

/**
 * Function that adds new columns to the existing columns
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_add_portfolio_columns( $columns ) {

	foreach( $columns as $key => $value ) {
		if ( $key == 'cb' ) {
			$new_columns[$key] = $value;
			$new_columns['thumb column-comments'] = __( 'Preview', 'sp-theme' );
		}

		if ( $key == 'taxonomy-sp-portfolio-categories' ) {
			$new_columns[$key] = $value;
			$new_columns['portfolio-sort-position'] = __( 'Sort Position', 'sp-theme' );
		}

		$new_columns[$key] = $value;
	}
	
	return $new_columns;
}

add_filter( 'manage_edit-sp-portfolio_sortable_columns', '_sp_portfolio_columns_sortable' );

/**
 * Function that makes column sortable
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_portfolio_columns_sortable( $columns ) {
	$columns['taxonomy-sp-portfolio-categories'] = 'title';

	return $columns;
}

add_action( 'manage_sp-portfolio_posts_custom_column',  '_sp_portfolio_column_functions', 10, 2 );

/**
 * Function that adds the new column data
 *
 * @access private
 * @since 3.0
 * @param array $column the column data
 * @return mixed the data for the column
 */
function _sp_portfolio_column_functions( $column, $post_id ) {
	
	switch ( $column ) {
		case 'thumb column-comments' :
			$image = sp_get_image( get_post_thumbnail_id( $post_id ), apply_filters( 'portfolio_backend_list_image_width', 50 ), apply_filters( 'portfolio_backend_list_image_height', 50 ), true );

			echo '<img src="' . $image['url'] . '" alt="' . sprintf( esc_attr__( '%s', 'sp-theme' ), $image['alt'] ) . '" width="' . $image['width'] .'" height="' . $image['height'] . '" />';
			break;

		case 'portfolio-sort-position' :
			$position = get_post_meta( $post_id, '_sp_portfolio_sort_position', true );

			echo $position;
			break;		
	}
}

add_filter( 'manage_edit-sp-portfolio-categories_columns', '_sp_add_portfolio_categories_columns' ); 

/**
 * Function that adds new columns to the existing columns
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_add_portfolio_categories_columns( $columns ) {

	foreach( $columns as $key => $value ) {
		if ( $key == 'name' ) {
			$new_columns[$key] = $value;
			$new_columns['shortcode'] = __( 'Shortcode', 'sp-theme' );
		}

		$new_columns[$key] = $value;
	}
	
	return $new_columns;
}

add_action( 'manage_sp-portfolio-categories_custom_column',  '_sp_portfolio_categories_column_functions', 10, 3 );

/**
 * Function that adds the new column data
 *
 * @access private
 * @since 3.0
 * @param array $column the column data
 * @return mixed the data for the column
 */
function _sp_portfolio_categories_column_functions( $empty, $column, $post_id ) {
	switch ( $column ) {

		case 'shortcode' :
			echo '[sp-portfolio category="' . $post_id . '"]';
			break;
	}
	
}

add_filter( 'manage_edit-sp-slider_columns', '_sp_add_slider_columns' );

/**
 * Function that adds new columns to the existing columns
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_add_slider_columns( $columns ) {
	$newcolumns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title', 'sp-theme' ),
		'slide_count' => __( 'No. of Slides', 'sp-theme' ),
		'shortcode' => __( 'Shortcode', 'sp-theme' )
	);
	
	$columns = array_merge( $newcolumns, $columns );
	
	return $columns;
}

add_action( 'manage_sp-slider_posts_custom_column',  '_sp_slider_column_functions', 10, 2 );

/**
 * Function that adds the new column data
 *
 * @access private
 * @since 3.0
 * @param array $column the column data
 * @return mixed the data for the column
 */
function _sp_slider_column_functions( $column, $post_id ) {
	switch ( $column ) {
		case 'slide_count' :
			echo sp_get_slider_slide_count( $post_id );
			break;

		case 'shortcode' :
			echo sp_get_slider_shortcode( $post_id );
			break;
	}
	
}

add_filter( 'manage_edit-sp-testimonial_sortable_columns', '_sp_testimonial_columns_sortable' );

/**
 * Function that makes column sortable
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_testimonial_columns_sortable( $columns ) {
	$columns['taxonomy-sp-testimonial-categories'] = 'title';

	return $columns;
}

add_filter( 'manage_edit-sp-testimonial-categories_columns', '_sp_add_testimonial_categories_columns' ); 

/**
 * Function that adds new columns to the existing columns
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_add_testimonial_categories_columns( $columns ) {

	foreach( $columns as $key => $value ) {
		if ( $key == 'name' ) {
			$new_columns[$key] = $value;
			$new_columns['shortcode'] = __( 'Shortcode', 'sp-theme' );
		}

		$new_columns[$key] = $value;
	}
	
	return $new_columns;
}

add_action( 'manage_sp-testimonial-categories_custom_column',  '_sp_testimonial_categories_column_functions', 10, 3 );

/**
 * Function that adds the new column data
 *
 * @access private
 * @since 3.0
 * @param array $column the column data
 * @return mixed the data for the column
 */
function _sp_testimonial_categories_column_functions( $empty, $column, $post_id ) {
	switch ( $column ) {

		case 'shortcode' :
			echo '[sp-testimonial category="' . $post_id . '"]';
			break;
	}
	
}

add_filter( 'manage_edit-sp-contact-form_columns', '_sp_add_contact_form_columns' ); 

/**
 * Function that adds new columns to the existing columns
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_add_contact_form_columns( $columns ) {

	foreach( $columns as $key => $value ) {
		if ( $key == 'title' ) {
			$new_columns[$key] = $value;
			$new_columns['shortcode'] = __( 'Shortcode', 'sp-theme' );
		}

		$new_columns[$key] = $value;
	}
	
	return $new_columns;
}

add_action( 'manage_sp-contact-form_posts_custom_column',  '_sp_contact_form_column_functions', 10, 3 );

/**
 * Function that adds the new column data
 *
 * @access private
 * @since 3.0
 * @param array $column the column data
 * @return mixed the data for the column
 */
function _sp_contact_form_column_functions( $column, $post_id ) {
	switch ( $column ) {

		case 'shortcode' :
			echo '[sp-contact id="' . $post_id . '"]';
			break;
	}
	
}

add_filter( 'manage_edit-sp-faq-categories_columns', '_sp_add_faq_categories_columns' ); 

/**
 * Function that adds new columns to the existing columns
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_add_faq_categories_columns( $columns ) {

	foreach( $columns as $key => $value ) {
		if ( $key == 'name' ) {
			$new_columns[$key] = $value;
			$new_columns['shortcode'] = __( 'Shortcode', 'sp-theme' );
		}

		$new_columns[$key] = $value;
	}
	
	return $new_columns;
}

add_action( 'manage_sp-faq-categories_custom_column',  '_sp_faq_categories_column_functions', 10, 3 );

/**
 * Function that adds the new column data
 *
 * @access private
 * @since 3.0
 * @param array $column the column data
 * @return mixed the data for the column
 */
function _sp_faq_categories_column_functions( $empty, $column, $post_id ) {
	switch ( $column ) {

		case 'shortcode' :
			echo '[sp-faq category="' . $post_id . '"]';
			break;
	}
	
}

add_filter( 'manage_edit-sp-faq_columns', '_sp_add_faq_columns', 10, 3 );

/**
 * Function that adds new columns to the existing columns
 *
 * @access private
 * @since 3.0
 * @param array $columns the existing columns being displayed
 * @return array $columns the modified columns
 */
function _sp_add_faq_columns( $columns ) {

	foreach( $columns as $key => $value ) {
		if ( $key == 'taxonomy-sp-faq-categories' ) {
			$new_columns[$key] = $value;
			$new_columns['faq-sort-position'] = __( 'Sort Position', 'sp-theme' );
		}

		$new_columns[$key] = $value;
	}
	
	return $new_columns;
}

add_action( 'manage_sp-faq_posts_custom_column',  '_sp_faq_column_functions', 10, 2 );

/**
 * Function that adds the new column data
 *
 * @access private
 * @since 3.0
 * @param array $column the column data
 * @return mixed the data for the column
 */
function _sp_faq_column_functions( $column, $post_id ) {
	switch ( $column ) {

		case 'faq-sort-position' :
			echo get_post_meta( $post_id, '_sp_post_faq_order', true );
			break;
	}
}
