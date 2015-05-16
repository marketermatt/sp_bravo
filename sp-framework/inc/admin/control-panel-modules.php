<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * control panel functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * Function that displays the upload module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_upload_module( $module = array() ) {
	
	$attachment_id = '';
	$display = 'display:none;';	
	$media_url = '';
	$preview_media_url = '#';
	$width = '50';
	$height = '50';

	// check if width and height is set
	if ( isset( $module['_attr']['width'] ) && isset( $module['_attr']['height'] ) ) {
		$width = $module['_attr']['width'];
		$height = $module['_attr']['height'];
	}

	// check to see if we need to display the input and preview
	if ( sp_get_option( $module['_attr']['id'], 'isset' ) && sp_get_option( $module['_attr']['id'] ) != '' ) {
		$display = 'display:block;'; 
		$media_url = sp_get_option( $module['_attr']['id'] );

		// get the attachment id
		if ( sp_get_option( 'attachment_id_' . $module['_attr']['id'], 'isset' ) && sp_get_option( 'attachment_id_' . $module['_attr']['id'] ) != '' ) {
			$attachment_id =  sp_get_option( 'attachment_id_' . $module['_attr']['id'] );

			$preview_media_url = sp_get_image( $attachment_id, $width, $height, true );
			$preview_media_url = $preview_media_url['url'];
		}
	}

	$output = '<tr class="inner upload-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<a title="' . esc_attr( 'Media Upload', 'sp-theme' ) . '" class="button media-upload" data-uploader_button_text="' . esc_attr( 'Select File', 'sp-theme' ) . '" data-uploader_title="' . esc_attr( 'Choose a ' . $module['_attr']['title'], 'sp-theme' ) . '" data-id="' . $module['_attr']['id'] . '">' . __( 'Choose Media', 'sp-theme' ) . '</a>' . PHP_EOL;
	$output .= '<input type="text" value="' . $media_url . '" style="' . $display . '" class="media-file widefat" name="' . $module['_attr']['id'] . '" id="' . $module['_attr']['id'] . '" />' . PHP_EOL;	
	$output .= '</td><!--close .col2-->' . PHP_EOL;
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;	
	$output .= '<tr class="meta upload-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;
	$output .= '<label class="image-preview" style="' . $display . '">' . __( 'Preview:', 'sp-theme' ) . '<img src="' . $preview_media_url . '" alt="' . esc_attr( 'Image Preview', 'sp-theme' ) . '" width="' . $width . '" height="' . $height . '" /></label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<p class="remove-media" style="' . $display . '"><a href="#" title="' . esc_attr( 'Remove Image', 'sp-theme' ) . '" class="button" data-id="' . $module['_attr']['id'] . '">' . __( 'Remove Media', 'sp-theme' ) . '</a></p>' . PHP_EOL;
	$output .= '<input type="hidden" name="attachment_id_' . $module['_attr']['id'] . '" value="' . $attachment_id . '" class="attachment-id" />' . PHP_EOL;	
	$output .= '</td><!--close .col2-->' . PHP_EOL;
	$output .= '<td class="col3" colspan="4"></td>' . PHP_EOL;
	$output .= '</tr><!--close .meta-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the checkbox module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_checkbox_module( $module = array() ) {
	$checkbox_value = '';

	if ( sp_get_option( $module['_attr']['id'], 'isset' ) && sp_get_option( $module['_attr']['id'] ) != '')
		$checkbox_value = sp_get_option( $module['_attr']['id'] );

	$output = '<tr class="inner checkbox-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<input type="checkbox" value="on" ' . checked( sp_get_option( $module['_attr']['id'] ), 'on', false ) . ' name="' . $module['_attr']['id'] . '" id="checkbox-' . sp_a_clean( $module['_attr']['id'] ) . '" class="checkbox-button" data-id="' . $module['_attr']['id'] . '" />' . PHP_EOL;	
	$output .= '<input type="hidden" name="' . $module['_attr']['id'] . '" value="' . $checkbox_value . '" class="hidden-checkbox-value" />' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the radio module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_radio_module( $module = array() ) {

	$output = '<tr class="inner radio-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;

	// check if options were set
	if ( isset( $module['_attr']['option'] ) ) {
		$options = explode(',', $module['_attr']['option'] );
		
		foreach ( $options as $option ) {
			// check if setting is saved
			if ( ! sp_get_option( $module['_attr']['id'], 'isset' ) )
				$value = $module['_attr']['std'];
			else 
				$value = sp_get_option( $module['_attr']['id'] );

			$output .= '<label><input type="radio" value="' . strtolower( $option ) . '" name="' . $module['_attr']['id'] . '" id="radio-' . sp_a_clean( $module['_attr']['id'] . '-' . $option ) . '" ' . checked( strtolower( $value ), strtolower( $option ), false ) . ' />' . PHP_EOL;
			$output .= $option . '</label>' . PHP_EOL;
		}
	}

	$output .= '</td><!--close .col2-->' . PHP_EOL;
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the text module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_text_module( $module = array() ) {
	
	$output = '<tr class="inner text-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<input type="text" value="';

	// if nothing was set, get standard value
	if ( sp_get_option( $module['_attr']['id'], 'isset' ) ) 
		$output .= sp_get_option( $module['_attr']['id'] ); 

	$output .= '" name="' . $module['_attr']['id'] . '" id="text-' . sp_a_clean( $module['_attr']['id'] ) . '" class="text-input widefat" />' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the textarea module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_textarea_module( $module = array() ) {
	// check if row numbers set
	$rows = isset( $module['_attr']['rows'] ) ? $module['_attr']['rows'] : '';

	if ( ! isset( $rows ) || empty( $rows ) )
		$rows = '8';

	$output = '<tr class="inner textarea-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2" colspan="4">' . PHP_EOL;
	$output .= '<textarea name="' . $module['_attr']['id'] . '" id="textarea-' . sp_a_clean( $module['_attr']['id'] ) . '" rows="' . esc_attr( $rows ) . '" class="widefat">' . PHP_EOL;
	
	// if nothing was set, get standard value
	if ( sp_get_option( $module['_attr']['id'], 'isset' ) ) 
		$output .= stripslashes( sp_get_option( $module['_attr']['id'] ) );

	$output .= '</textarea>' . PHP_EOL;

	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the colorpicker module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_colorpicker_module( $module = array() ) {
	
	$output = '<tr class="inner colorpicker-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;

	// if nothing was set, get standard value
	if ( sp_get_option( $module['_attr']['id'], 'isset' ) && sp_get_option( $module['_attr']['id'] ) != '' )
		$color = sp_get_option( $module['_attr']['id'] );
	else 
		$color = $module['_attr']['std'] ;

	$output .= '<input type="text" value="' . esc_attr( $color ) . '" class="sp-colorpicker widefat" name="' . esc_attr( $module['_attr']['id'] ) . '" />' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;
	
	return $output;	
}

/**
 * Function that displays the datepicker module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_datepicker_module( $module = array() ) {
	
	$output = '<tr class="inner datepicker-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<input type="text" value="';
	
	// if nothing was set, get standard value
	if ( sp_get_option( $module['_attr']['id'], 'isset' ) && sp_get_option( $module['_attr']['id'] ) != '' ) 
		$output .= sp_get_option( $module['_attr']['id'] ); 
	else 
		$output .= $module['_attr']['std'];	

	$output .= '" name="' . $module['_attr']['id'] . '" id="text-' . sp_a_clean( $module['_attr']['id'] ) . '" class="datepicker widefat" />' . PHP_EOL;
	
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the info module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_info_module( $module = array() ) {
	$output = '<tr><td colspan="6">' . PHP_EOL;
	$output .= '<p class="info-text">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td></tr>' . PHP_EOL;

	return $output;
}

/**
 * Function that displays the link module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_link_module( $module = array() ) {
	$url = '';

	// check if link is passed in or a page slug
	if ( $module['_attr']['context'] == 'url' ) {
		$url = admin_url( $module['_attr']['link'] );

	} elseif ( $module['_attr']['context'] == 'slug' ) {
		// get the page url from slug
		$page_id = sp_get_page_id_from_slug( $module['_attr']['link'] );
		
		$url = admin_url( 'post.php?post=' . $page_id . '&action=edit' );
	}

	$output = '<tr><td colspan="6">' . PHP_EOL;
	$output .= '<p class="info-text">';

	// output text only if one is set
	if ( isset( $module['_attr']['desc'] ) ) 
		$output	 .= sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] );
	
	$output .= ' <a href="' . esc_url( $url ) . '" title="' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['title'] ) . '" >' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['title'] ) . '</a></p>' . PHP_EOL;
	
	$output .= '</td></tr>' . PHP_EOL;

	return $output;
}

/**
 * Function that displays the faq module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_faq_module( $module = array() ) {
	
	$output = '<tr class="faq">';
	$output .= '<td colspan="6">' . PHP_EOL;
	$output .= '<label class="sub-heading">' . $module['_attr']['title'] . '</label>' . PHP_EOL;
	$output .= '<p>' . $module['_attr']['answer'] . '</p>' . PHP_EOL;
	$output .= '</td>' . PHP_EOL;
	$output .= '</tr>';
	
	return $output;
}

/**
 * Function that displays the select module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_select_module( $module = array() ) {
	
	// check if is multiple select
	if ( isset( $module['_attr']['multiple'] ) )
		$multiple = 'multiple="multiple"';
	else
		$multiple = '';

	$output = '<tr class="inner select-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<select name="' . $module['_attr']['id'] . '" class="select2-select" ' . $multiple . '>' . PHP_EOL;
	
	// convert string to array
	if ( isset( $module['_attr']['option'] ) )
		$options = explode( ',', $module['_attr']['option'] );

	// check if parameter is passed
	if ( isset( $module['_attr']['func_param'] ) ) {
		$param = $module['_attr']['func_param'] ;

		if ( $param == 'false' )
			$param = false;
		else
			$param = true;

		// check to see if function is needed
		if ( isset( $module['_attr']['function'] ) )
			$function_return = call_user_func( 'sp_' . $module['_attr']['function'], $param );
	} else {
		// check to see if function is needed
		if ( isset( $module['_attr']['function'] ) )
			$function_return = call_user_func( 'sp_' . $module['_attr']['function'] );
	}

	// if function was called use options from function
	if ( isset( $function_return ) ) {
		// loop through all options
		foreach( $function_return as $value => $option ) {
			$option_value = $value;

			if ( $option == '--Please Select--' ) {
				$option_value = '0';
				$option = __( '--Please Select--', 'sp-theme' );
			} 

			// if no value passed, use option name as value
			if ( absint( $value ) )
				$option_value = $option;

			// check if settings saved
			if ( ! sp_get_option( $module['_attr']['id'], 'isset' ) )
				$saved_value = $module['_attr']['std'];
			else 
				$saved_value = sp_get_option( $module['_attr']['id'] );

			$output .= '<option value="' . esc_attr( $option_value ) . '" ' . selected( $saved_value, $option_value, false ) . '>' . $option . '</option>' . PHP_EOL;
		}
	} else {
		// loop through all options
		foreach( $options as $option ) {
			$option_value = $option;

			if ( $option == '--Please Select--' ) {
				$option_value = '0';
				$option = __( '--Please Select--', 'sp-theme' );
			}

			// check if settings saved
			if ( ! sp_get_option( $module['_attr']['id'], 'isset' ) )
				$saved_value = $module['_attr']['std'];
			else 
				$saved_value = sp_get_option( $module['_attr']['id'] );

			$output .= '<option value="' . esc_attr( $option_value ) . '" ' . selected( $saved_value, $option_value, false ) . '>' . $option . '</option>' . PHP_EOL;
		}
	}

	$output .= '</select>' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the font module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_font_module( $module = array() ) {

	$output = '<tr class="inner select-module ' . $module['_attr']['id'] . ' font-family">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<select name="' . $module['_attr']['id'] . '" class="select2-select font-select" data-no_results_text="' . __( 'No results match', 'sp-theme' ) . '">' . PHP_EOL;

	$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

	// check if settings saved
	if ( ! sp_get_option( $module['_attr']['id'], 'isset' ) )
		$saved_font = $module['_attr']['std'];
	else 
		$saved_font = sp_get_option( $module['_attr']['id'] );

	// get fonts
	$fonts = sp_get_google_fonts();

	foreach( $fonts as $font ) {
		$output .= '<option value="' . esc_attr( $font['family'] ) . '" ' . selected( $saved_font, $font['family'], false ) . '>' . $font['family'] . '</option>' . PHP_EOL;
	}

	$output .= '</select>' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	// variants
	$output .= '<tr class="inner select-module ' . $module['_attr']['id'] . '-variant font-variant">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), 'Font Variants' ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<select name="' . $module['_attr']['id'] . '-variant" class="select2-select font-variant-select" data-no_results_text="' . __( 'No results match', 'sp-theme' ) . '">' . PHP_EOL;

	$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

	$saved_variant = sp_get_option( $module['_attr']['id'] . '-variant' );
	
	if ( ! isset( $saved_variant ) )
		$saved_variant = '';

	$option = '';
	
	$font = sp_get_font( $saved_font );

	foreach( $font['variants'] as $variant ) {
		$option .= '<option value="' . esc_attr( $variant ) . '" ' . selected( $saved_variant, $variant, false ) . '>' . $variant . '</option>' . PHP_EOL;
	}

	$output .= $option . PHP_EOL;
	$output .= '</select>' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), 'Select the variant for this font.  If you are unsure, leave unselected.' ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;	

	// subsets
	$output .= '<tr class="inner select-module ' . $module['_attr']['id'] . '-subset font-subset">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), 'Font Subsets' ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<select name="' . $module['_attr']['id'] . '-subset[]" class="select2-select font-subset-select" multiple data-placeholder="' . __( '--Please Select--', 'sp-theme' ) . '">' . PHP_EOL;

	$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

	$saved_subset = sp_get_option( $module['_attr']['id'] . '-subset' );
	
	if ( ! isset( $saved_subset ) )
		$saved_subset = '';

	$option = '';
	
	$font = sp_get_font( $saved_font );

	foreach( $font['subsets'] as $subset ) {
		$option .= '<option value="' . esc_attr( $subset ) . '" ' . selected( $saved_subset, $subset, false ) . '>' . $subset . '</option>' . PHP_EOL;
	}

	$output .= $option . PHP_EOL;
	$output .= '</select>' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), 'Select the subset for this font.  If you are unsure, leave unselected.' ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;		
	
	return $output;	
}

/**
 * Function that displays the button module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_button_module( $module = array() ) {
	$url = '';

	// if link is self - set to control panel
	if ( $module['_attr']['link'] == 'self' )
		$url = admin_url( 'admin.php?page=sp' );

	$output = '<tr class="inner button-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) ) . '" class="' . esc_attr( $module['_attr']['class'] ) . ' button button-primary">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['link_text'] ) . '</a>' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;
}

/**
 * Function that displays the create page module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_create_page( $module = array() ) {
	
	$page_title = $module['_attr']['page_title'];

	$page_check = get_page_by_title( sprintf( __( '%s', 'sp-theme' ), $page_title ) );

	// display only if page is not set
	if ( ! isset( $page_check->ID ) ) {
		$output = '<tr class="inner ' . $module['_attr']['id'] . '">';
		$output .= '<td class="col1">' . PHP_EOL;
		$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;						
		$output .= '</td>' . PHP_EOL;
		$output .= '<td class="col2">' . PHP_EOL;
		$output .= '<span style="color:red;background-color:#fff;padding:2px;">' . $module['_attr']['msg'] . '</span>' . ' <a href="#" class="button button-primary create-page">' . __( 'Create Page', 'sp-theme' ) . '</a>' . PHP_EOL;
		$output .= '</td>' . PHP_EOL;
		$output .= '<td class="col3" colspan="4">' . PHP_EOL;
		$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;		
		$output .= '<input type="hidden" name="page_title" value="' . $module['_attr']['page_title'] . '" class="page-title" />' . PHP_EOL;
		$output .= '<input type="hidden" name="page_template" value="' . $module['_attr']['template'] . '" class="page-template" />' . PHP_EOL;
		$output .= '</td>' . PHP_EOL;
		$output .= '</tr>';
		
		return $output;
	}
}

/**
 * Function that displays the save configuration module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_save_configuration_module( $module = array() ) {
	
	$output = '<tr class="inner text-module">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . __( 'Configuration Name', 'sp-theme' ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<input type="text" value="" name="save_config" class="save-config-name text-input widefat" />' . PHP_EOL;
	$output .= '<a href="#" title="' . esc_attr( 'Save Config', 'sp-theme' ) . '" class="save-config button button-primary">' . __( 'Save Configuration', 'sp-theme' ) . '</a>' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . __( 'Enter a name for the current configuration settings you want to save.', 'sp-theme' ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	// get list of saved theme configurations
	$configs = sp_get_saved_configurations();

	$output .= '<tr class="inner select-module">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . __( 'Apply Configuration', 'sp-theme' ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<select name="apply_config" class="select2-select">' . PHP_EOL;
	$output .= '<option value="0">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

	if ( isset( $configs ) && is_array( $configs ) ) {
		foreach ( $configs as $name => $value ) {
			$output .= '<option value="' . esc_attr( $name ) . '">' . $name . '</option>' . PHP_EOL;
		}
	}

	$output .= '</select>' . PHP_EOL;
	$output .= '<a href="#" title="' . esc_attr( 'Apply Config', 'sp-theme' ) . '" class="apply-config button button-primary">' . __( 'Apply Configuration', 'sp-theme' ) . '</a>' . PHP_EOL;	
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . __( 'Select the configuration you want to apply.', 'sp-theme' ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	$output .= '<tr class="inner select-module">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . __( 'Delete Configuration', 'sp-theme' ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<select name="delete_config" class="select2-select">' . PHP_EOL;
	$output .= '<option value="0">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

	if ( isset( $configs ) && is_array( $configs ) ) {
		foreach ( $configs as $name => $value ) {
			$output .= '<option value="' . esc_attr( $name ) . '">' . $name . '</option>' . PHP_EOL;
		}
	}

	$output .= '</select>' . PHP_EOL;
	$output .= '<a href="#" title="' . esc_attr( 'Delete Config', 'sp-theme' ) . '" class="delete-config button button-primary">' . __( 'Delete Configuration', 'sp-theme' ) . '</a>' . PHP_EOL;	
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . __( 'Select the configuration you want to delete.  Each configuration will take up a little space in the database so if you are not using some of them, you can delete them.', 'sp-theme' ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;		
}

/**
 * Function that displays the export theme settings module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_export_theme_settings_module( $module = array() ) {
	
	$output = '<tr class="inner theme-settings-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2" colspan="4">' . PHP_EOL;
	$output .= '<textarea name="" id="textarea-' . sp_a_clean( $module['_attr']['id'] ) . '" rows="8" class="widefat export-box">' . PHP_EOL;
	
	// display the saved settings encoded
	$output .= get_option( THEME_NAME . "_sp_data" );

	$output .= '</textarea>' . PHP_EOL;

	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the import theme settings module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_import_theme_settings_module( $module = array() ) {
	
	$output = '<tr class="inner theme-settings-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2" colspan="4">' . PHP_EOL;
	$output .= '<textarea name="' . $module['_attr']['id'] . '" id="textarea-' . sp_a_clean( $module['_attr']['id'] ) . '" rows="8" class="widefat">' . PHP_EOL;
	$output .= '</textarea>' . PHP_EOL;
	$output .= '<a href="#" title="' . esc_attr__( 'Import', 'sp-theme' ) . '" class="import-theme-settings button button-primary">' . __( 'Import', 'sp-theme' ) . '</a>' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

/**
 * Function that displays the custom page widget module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_custom_page_widget_module( $module = array() ) {
	
	$widgets = ( sp_get_option( $module['_attr']['id'], 'isset' ) ) ? sp_get_option( $module['_attr']['id'] ) : '';

	$output = '';

	$pages = sp_list_pages( false );

	if ( isset( $widgets ) && is_array( $widgets ) ) {
		foreach( $widgets as $widget ) {
			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
			$output .= '<label class="sub-heading">' . __( 'Select Custom Widget Location', 'sp-theme' ) . '</label>' . PHP_EOL;
			$output .= '</td><!--close .col1-->' . PHP_EOL;	
			$output .= '<td class="col2">' . PHP_EOL;		
			$output .= '<select name="' . $module['_attr']['id'] . '[]" id="' . $module['_attr']['id'] . '_' . $widget . '" class="select2-select custom-widget-select">' . PHP_EOL;
			
			$output .= '<option value="0">' . __( 'Select a Page', 'sp-theme' ) . '</option>';
			
			foreach ( $pages as $page ) {
				if ( empty( $page->post_title ) )
					continue;

				$output .= '<option value="' . $page->ID . '" ' . selected( $widget, $page->ID, false ) . '>' . $page->post_title . '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Add', 'sp-theme' ) . '" class="add-widgets"><i class="icon-plus-sign" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Delete', 'sp-theme' ) . '" class="delete-widget"><i class="icon-remove-sign" aria-hidden="true"></i></a>';

			/////////////////////////////////////////////////////
			// widget locations
			/////////////////////////////////////////////////////			
			$output .= '<select name="' . $module['_attr']['id'] . '_' . $widget . '_locations[]" id="' . $module['_attr']['id'] . '_' . $widget . '_locations" class="select2-select custom-widget-location" multiple="multiple">' . PHP_EOL;
			
			$options = sp_get_widget_areas();

			// get the saved settings
			$saved_settings = sp_get_option( $module['_attr']['id'] . '_' . $widget . '_locations' );

			foreach ( $options as $option ) {
				$option_value = strtolower( str_replace( ' ', '-', $option ) );

				// if found in array
				if ( is_array( $saved_settings ) ) {
					if ( in_array( $option_value, $saved_settings ) )
						$setting = $option_value;
					else
						$setting = '';
				} elseif ( $saved_settings == $option_value ) {
					$setting = $saved_settings;
				} else {
					$setting = '';
				}

				$output .= '<option value="' . $option_value . '" ' . selected( $setting, $option_value, false ) . '>' . $option . '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;			
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;
			$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
			$output .= '<p class="info">' . __( 'Select the location where you want this custom page widget to appear.  Only select where you will want this widget area to display.  You may select multiple locations.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;				
		}
	} else {
			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
			$output .= '<label class="sub-heading">' . __( 'Select Custom Widget Location', 'sp-theme' ) . '</label>' . PHP_EOL;			
			$output .= '</td><!--close .col1-->' . PHP_EOL;
			$output .= '<td class="col2">' . PHP_EOL;		
			$output .= '<select name="' . $module['_attr']['id'] . '[]" id="' . $module['_attr']['id'] . '" class="select2-select custom-widget-select">' . PHP_EOL;

			$output .= '<option value="0">' . __( 'Select a Page', 'sp-theme' ) . '</option>';
			
			foreach ( $pages as $page ) {
				$output .= '<option value="' . $page->ID . '" ' . selected( sp_get_option( $module['_attr']['id'] ), $page->ID, false ) . '>' . $page->post_title . '</option>';
			}  
		
			$output .= '</select>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Add', 'sp-theme' ) . '" class="add-widgets"><i class="icon-plus-sign" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Delete', 'sp-theme' ) . '" class="delete-widget"><i class="icon-remove-sign" aria-hidden="true"></i></a>';

			/////////////////////////////////////////////////////
			// widget locations
			/////////////////////////////////////////////////////
			$output .= '<select name="' . $module['_attr']['id'] . '_0_locations[]" id="' . $module['_attr']['id'] . '_0_locations" class="select2-select custom-widget-location" multiple="multiple">' . PHP_EOL;
			
			$options = sp_get_widget_areas();

			foreach ( $options as $option ) {
				$option_value = strtolower( str_replace( ' ', '-', $option ) );

				$output .= '<option value="' . $option_value . '">' . $option . '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;						
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;
			$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
			$output .= '<p class="info">' . __( 'Select the location where you want this custom page widget to appear.  Only select where you will want this widget area to display.  You may select multiple locations.', 'sp-theme' ) . '</p>' . PHP_EOL;			
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;			
	}

	return $output;	
}

/**
 * Function that displays the custom blog category widget module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_custom_blog_category_widget_module( $module = array() ) {
	
	$widgets = ( sp_get_option( $module['_attr']['id'], 'isset' ) ) ? sp_get_option( $module['_attr']['id'] ) : '';
	
	$output = '';

	$cats = sp_list_blog_categories( false );

	if ( isset( $widgets ) && is_array( $widgets ) ) {
		foreach( $widgets as $widget ) {
			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
			$output .= '<label class="sub-heading">' . __( 'Select Custom Widget Location', 'sp-theme' ) . '</label>' . PHP_EOL;			
			$output .= '</td><!--close .col1-->' . PHP_EOL;	
			$output .= '<td class="col2">' . PHP_EOL;		
			$output .= '<select name="' . $module['_attr']['id'] . '[]" id="' . $module['_attr']['id'] . '_' . $widget . '" class="select2-select custom-widget-select">' . PHP_EOL;
			
			$output .= '<option value="0">' . __( 'Select a Category', 'sp-theme' ) . '</option>';
			
			foreach ( $cats as $cat ) {
				$output .= '<option value="' . $cat->term_id . '" ' . selected( $widget, $cat->term_id, false ) . '>' . $cat->name. '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Add', 'sp-theme' ) . '" class="add-widgets"><i class="icon-plus-sign" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Delete', 'sp-theme' ) . '" class="delete-widget"><i class="icon-remove-sign" aria-hidden="true"></i></a>';
			
			/////////////////////////////////////////////////////
			// widget locations
			/////////////////////////////////////////////////////			
			$output .= '<select name="' . $module['_attr']['id'] . '_' . $widget . '_locations[]" id="' . $module['_attr']['id'] . '_' . $widget . '_locations" class="select2-select custom-widget-location" multiple="multiple">' . PHP_EOL;
			
			$options = sp_get_widget_areas();

			// get the saved settings
			$saved_settings = sp_get_option( $module['_attr']['id'] . '_' . $widget . '_locations' );

			foreach ( $options as $option ) {
				$option_value = strtolower( str_replace( ' ', '-', $option ) );

				// if found in array
				if ( is_array( $saved_settings ) ) {
					if ( in_array( $option_value, $saved_settings ) )
						$setting = $option_value;
					else
						$setting = '';
				} elseif ( $saved_settings == $option_value ) {
					$setting = $saved_settings;
				} else {
					$setting = '';
				}

				$output .= '<option value="' . $option_value . '" ' . selected( $setting, $option_value, false ) . '>' . $option . '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;			
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;
			$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
			$output .= '<p class="info">' . __( 'Select the location where you want this custom blog category widget to appear.  Only select where you will want this widget area to display.  You may select multiple locations.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;			
		}
	} else {
			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
			$output .= '<label class="sub-heading">' . __( 'Select Custom Widget Location', 'sp-theme' ) . '</label>' . PHP_EOL;						
			$output .= '</td><!--close .col1-->' . PHP_EOL;
			$output .= '<td class="col2">' . PHP_EOL;		
			$output .= '<select name="' . $module['_attr']['id'] . '[]" id="' . $module['_attr']['id'] . '" class="select2-select custom-widget-select">' . PHP_EOL;

			$output .= '<option value="0">' . __( 'Select a Category', 'sp-theme' ) . '</option>';
			
			foreach ( $cats as $cat ) {
				$output .= '<option value="' . $cat->term_id . '" ' . selected( sp_get_option( $module['_attr']['id'] ), $cat->term_id, false ) . '>' . $cat->name . '</option>';
			}  
		
			$output .= '</select>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Add', 'sp-theme' ) . '" class="add-widgets"><i class="icon-plus-sign" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Delete', 'sp-theme' ) . '" class="delete-widget"><i class="icon-remove-sign" aria-hidden="true"></i></a>';

			/////////////////////////////////////////////////////
			// widget locations
			/////////////////////////////////////////////////////
			$output .= '<select name="' . $module['_attr']['id'] . '_0_locations[]" id="' . $module['_attr']['id'] . '_0_locations" class="select2-select custom-widget-location" multiple="multiple">' . PHP_EOL;
			
			$options = sp_get_widget_areas();

			foreach ( $options as $option ) {
				$option_value = strtolower( str_replace( ' ', '-', $option ) );

				$output .= '<option value="' . $option_value . '">' . $option . '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;						
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;
			$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
			$output .= '<p class="info">' . __( 'Select the location where you want this custom blog category widget to appear.  Only select where you will want this widget area to display.  You may select multiple locations.', 'sp-theme' ) . '</p>' . PHP_EOL;			
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;			
	}

	return $output;	
}

/**
 * Function that displays the custom product category widget module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_custom_product_category_widget_module( $module = array() ) {
	
	$widgets = ( sp_get_option( $module['_attr']['id'], 'isset' ) ) ? sp_get_option( $module['_attr']['id'] ) : '';
	
	$output = '';

	if ( sp_woo_exists() )
		$cats = sp_list_woo_product_categories( false );

	if ( isset( $widgets ) && is_array( $widgets ) ) {
		foreach( $widgets as $widget ) {
			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
			$output .= '<label class="sub-heading">' . __( 'Select Custom Widget Location', 'sp-theme' ) . '</label>' . PHP_EOL;				
			$output .= '</td><!--close .col1-->' . PHP_EOL;	
			$output .= '<td class="col2">' . PHP_EOL;		
			$output .= '<select name="' . $module['_attr']['id'] . '[]" id="' . $module['_attr']['id'] . '_' . $widget . '" class="select2-select custom-widget-select">' . PHP_EOL;
			
			$output .= '<option value="0">' . __( 'Select a Category', 'sp-theme' ) . '</option>';
			
			foreach ( $cats as $cat ) {
				$output .= '<option value="' . $cat->term_id . '" ' . selected( $widget, $cat->term_id, false ) . '>' . $cat->name . '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Add', 'sp-theme' ) . '" class="add-widgets"><i class="icon-plus-sign" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Delete', 'sp-theme' ) . '" class="delete-widget"><i class="icon-remove-sign" aria-hidden="true"></i></a>';

			/////////////////////////////////////////////////////
			// widget locations
			/////////////////////////////////////////////////////			
			$output .= '<select name="' . $module['_attr']['id'] . '_' . $widget . '_locations[]" id="' . $module['_attr']['id'] . '_' . $widget . '_locations" class="select2-select custom-widget-location" multiple="multiple">' . PHP_EOL;
			
			$options = sp_get_widget_areas();

			// get the saved settings
			$saved_settings = sp_get_option( $module['_attr']['id'] . '_' . $widget . '_locations' );

			foreach ( $options as $option ) {
				$option_value = strtolower( str_replace( ' ', '-', $option ) );

				// if found in array
				if ( is_array( $saved_settings ) ) {
					if ( in_array( $option_value, $saved_settings ) )
						$setting = $option_value;
					else
						$setting = '';
				} elseif ( $saved_settings == $option_value ) {
					$setting = $saved_settings;
				} else {
					$setting = '';
				}

				$output .= '<option value="' . $option_value . '" ' . selected( $setting, $option_value, false ) . '>' . $option . '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;			
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;
			$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
			$output .= '<p class="info">' . __( 'Select the location where you want this custom product category widget to appear.  Only select where you will want this widget area to display.  You may select multiple locations.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;			
		}
	} else {
			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
			$output .= '<label class="sub-heading">' . __( 'Select Custom Widget Location', 'sp-theme' ) . '</label>' . PHP_EOL;				
			$output .= '</td><!--close .col1-->' . PHP_EOL;
			$output .= '<td class="col2">' . PHP_EOL;		
			$output .= '<select name="' . $module['_attr']['id'] . '[]" id="' . $module['_attr']['id'] . '" class="select2-select custom-widget-select">' . PHP_EOL;

			$output .= '<option value="0">' . __( 'Select a Category', 'sp-theme' ) . '</option>';
			
			foreach ( $cats as $cat ) {
				$output .= '<option value="' . $cat->term_id . '" ' . selected( sp_get_option( $module['_attr']['id'] ), $cat->term_id, false ) . '>' . $cat->name . '</option>';
			}  
		
			$output .= '</select>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Add', 'sp-theme' ) . '" class="add-widgets"><i class="icon-plus-sign" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Delete', 'sp-theme' ) . '" class="delete-widget"><i class="icon-remove-sign" aria-hidden="true"></i></a>';

			/////////////////////////////////////////////////////
			// widget locations
			/////////////////////////////////////////////////////
			$output .= '<select name="' . $module['_attr']['id'] . '_0_locations[]" id="' . $module['_attr']['id'] . '_0_locations" class="select2-select custom-widget-location" multiple="multiple">' . PHP_EOL;
			
			$options = sp_get_widget_areas();

			foreach ( $options as $option ) {
				$option_value = strtolower( str_replace( ' ', '-', $option ) );

				$output .= '<option value="' . $option_value . '">' . $option . '</option>';
			} 
		
			$output .= '</select>' . PHP_EOL;						
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;
			$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
			$output .= '<p class="info">' . __( 'Select the location where you want this custom product category widget to appear.  Only select where you will want this widget area to display.  You may select multiple locations.', 'sp-theme' ) . '</p>' . PHP_EOL;			
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;			
	}

	return $output;	
}

/**
 * Function that displays the custom styles module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_custom_styles_module( $module = array() ) {
	// if child theme is used	
	if ( is_child_theme() )
		$path = get_stylesheet_directory() . '/css/custom-styles.css';
	else
		$path = get_template_directory() . '/css/custom-styles.css';
	
	$contents = '';

	// if file is found get contents
	if ( file_exists( $path ) ) { 
		$contents = file_get_contents( $path );
	}

	$args = array(
		'wpautop'		=> false,
		'textarea_name'	=> $module['_attr']['id'],
		'tinymce'		=> false,
		'media_buttons'	=> false,
		'quicktags'		=> false
	);

	return wp_editor( $contents, 'custom-styles', $args );
}

/**
 * Function that displays various system statuses
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_system_module( $module = array() ) {
	$output = '';

	$output .= '<p class="howto">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td class="col1">' . __( 'SP Framework Version', 'sp-theme' ) . ':</td>' . PHP_EOL;
    $output .= '<td class="col2">' . FRAMEWORK_VERSION . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;

	if ( is_child_theme() ) {
    	$output .= '<td class="col1">' . __( 'Parent Theme Version', 'sp-theme' ) . ':</td>' . PHP_EOL;
	} else {
		$output .= '<td class="col1">' . __( 'Theme Version', 'sp-theme' ) . ':</td>' . PHP_EOL;
	}

    $output .= '<td class="col2">' . THEME_VERSION . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td class="col1">' . __( 'WordPress Version', 'sp-theme' ) . ':</td>' . PHP_EOL;
    $output .= '<td class="col2">' . get_bloginfo( 'version' ) . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td class="col1">' . __( 'Server Environment', 'sp-theme' ) . ':</td>' . PHP_EOL;
    $output .= '<td class="col2">' . esc_html( $_SERVER['SERVER_SOFTWARE'] ) . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td class="col1">' . __( 'PHP Version', 'sp-theme' ) . ':</td>' . PHP_EOL;
    
    $phpversion = ( function_exists( 'phpversion' ) ) ? esc_html( phpversion() ) : __( 'N/A', 'sp-theme' );

    $output .= '<td class="col2">' . $phpversion . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td class="col1">' . __( 'MySQL Version', 'sp-theme' ) . ':</td>' . PHP_EOL;

    global $wpdb;
    
    $mysqlversion = $wpdb->db_version();

    $output .= '<td class="col2">' . $mysqlversion . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td class="col1">' . __( 'WordPress Memory Limit', 'sp-theme' ) . ':</td>' . PHP_EOL;

    // get the memory limit
    $memory = absint( WP_MEMORY_LIMIT );

    if ( $memory < 64 )
    	$output .= '<td class="warning col2">' . $memory . 'M' . ' - <p>' . __( 'It is highly recommended that you increase your PHP memory for WordPress to 64M(B) or higher.  You can follow this article to increase that limit', 'sp-theme' ) . ' <a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" title="' . esc_attr__( 'Memory', 'sp-theme' ) . '" target="_blank">http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP</a></p></td>' . PHP_EOL;
    else 
    	$output .= '<td class="col2">' . $memory . 'M</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td class="col1">' . __( 'WordPress Debug Mode', 'sp-theme' ) . ':</td>' . PHP_EOL;

    $debug = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? __( 'ON', 'sp-theme' ) : __( 'OFF', 'sp-theme' );

    $output .= '<td class="col2">' . $debug . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td class="col1">' . __( 'WordPress Script Debug Mode', 'sp-theme' ) . ':</td>' . PHP_EOL;

    $debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? __( 'ON', 'sp-theme' ) : __( 'OFF', 'sp-theme' );

    $output .= '<td class="col2">' . $debug . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	$output .= '<tr class="inner">' . PHP_EOL;
    $output .= '<td>' . __( 'CSS Directory Writable', 'sp-theme' ) . ':</td>' . PHP_EOL;
    
    if ( @fopen( THEME_PATH . 'css/custom-styles.css', 'a' ) )
    	$output .= '<td class="col2">' . __( 'Directory is writable.', 'sp-theme' ) . '</td>' . PHP_EOL;
    else
    	$output .= '<td class="warning col2">' . __( 'Directory is not writable.  Please check your directory permissions.', 'sp-theme' ) . '</td>' . PHP_EOL;
    $output .= '</tr>' . PHP_EOL;

	return $output;
}

/**
 * Function that displays a list of pages module
 *
 * @access public
 * @since 3.0
 * @param array $module - the module array items
 * @return html $output
 */
function sp_list_page_module( $module = array() ) {
	
	$pages = get_pages();

	$output = '<tr class="inner select-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<select name="' . $module['_attr']['id'] . '" class="select2-select">' . PHP_EOL;
	$output .= '<option value="0">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

	// check if settings saved
	if ( ! sp_get_option( $module['_attr']['id'], 'isset' ) )
		$saved_value = $module['_attr']['std'];
	else 
		$saved_value = sp_get_option( $module['_attr']['id'] );

	foreach( $pages as $page ) {
		if ( empty( $page->post_title ) )
			continue;
					
		$output .= '<option value="' . $page->ID . '" ' . selected( $page->ID, $saved_value, false ) . '>' . $page->post_title . '</option>' . PHP_EOL;
	}

	$output .= '</select>' . PHP_EOL;
	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	return $output;	
}

function sp_custom_background_module( $module = array() ) {
	// generate a list of custom backgrounds from the backgrounds folder
	$dir = get_template_directory() . '/images/backgrounds';

	if ( is_dir( $dir ) ) 
		$files = array_diff( scandir( $dir ), array( '.', '..' ) );

	$option_defaults = array( 'none' => __( 'No Custom Background', 'sp-theme' ), 'custom' => __( 'Upload Custom Background', 'sp-theme' ) );

	// rebuild the files array to set value same as key
	$rebuilt_files = array();

	foreach ( $files as $file ) {
		$rebuilt_files[get_template_directory_uri() . '/images/backgrounds/' . $file] = $file;	
	}

	$options = @array_merge( $option_defaults, $rebuilt_files );

	// check if is multiple select
	if ( isset( $module['_attr']['multiple'] ) )
		$multiple = 'multiple="multiple"';
	else
		$multiple = '';

	$attachment_id = '';
	$display = 'display:none;';
	$visibility = 'visibility:hidden;';
	$media_url = '';
	$preview_media_url = '#';
	$width = '50';
	$height = '50';

	// check if width and height is set
	if ( isset( $module['_attr']['width'] ) && isset( $module['_attr']['height'] ) ) {
		$width = $module['_attr']['width'];
		$height = $module['_attr']['height'];
	}

	// check to see if we need to display the input and preview
	if ( sp_get_option( $module['_attr']['id'] . '_custom', 'isset' ) && sp_get_option( $module['_attr']['id'] . '_custom' ) != '' ) {
		if ( sp_get_option( $module['_attr']['id'], 'isset' ) && sp_get_option( $module['_attr']['id'], 'is', 'custom' ) ) {
			$display = 'display:block;';
			$visibility = 'visibility:visible;';
		}

		$media_url = sp_get_option( $module['_attr']['id'] . '_custom' );

		// get the attachment id
		if ( sp_get_option( 'attachment_id_' . $module['_attr']['id'], 'isset' ) && sp_get_option( 'attachment_id_' . $module['_attr']['id'] ) != '' ) {
			$attachment_id =  sp_get_option( 'attachment_id_' . $module['_attr']['id'] );

			$preview_media_url = sp_get_image( $attachment_id, $width, $height, true );
			$preview_media_url = $preview_media_url['url'];
		}
	}

	$output = '<tr class="inner select-module ' . $module['_attr']['id'] . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;	
	$output .= '<label class="sub-heading">' . sprintf( __( '%s', 'sp-theme' ), $module['_attr']['title'] ) . '</label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<select name="' . $module['_attr']['id'] . '" class="select2-select" ' . $multiple . '>' . PHP_EOL;

	// loop through all options
	foreach( $options as $option_value => $option_name ) {

		// check if settings saved
		if ( ! sp_get_option( $module['_attr']['id'], 'isset' ) )
			$saved_value = $module['_attr']['std'];
		else 
			$saved_value = sp_get_option( $module['_attr']['id'] );

		$output .= '<option value="' . esc_attr( $option_value ) . '" ' . selected( $saved_value, $option_value, false ) . '>' . $option_name . '</option>' . PHP_EOL;
	}

	$output .= '</select>' . PHP_EOL;

	$output .= '</td><!--close .col2-->' . PHP_EOL;	
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '<p class="info">' . sprintf( __( stripslashes( '%s' ), 'sp-theme' ), $module['_attr']['desc'] ) . '</p>' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	$output .= '<tr class="inner upload-module ' . $module['_attr']['id'] . '" style="' . esc_attr( $visibility ) . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<a title="' . esc_attr( 'Media Upload', 'sp-theme' ) . '" class="button media-upload" data-uploader_button_text="' . esc_attr( 'Select File', 'sp-theme' ) . '" data-uploader_title="' . esc_attr( 'Choose a ' . $module['_attr']['title'], 'sp-theme' ) . '" data-id="' . $module['_attr']['id'] . '" style="' . esc_attr( $visibility ) . '">' . __( 'Choose Media', 'sp-theme' ) . '</a>' . PHP_EOL;
	$output .= '<input type="text" value="' . $media_url . '" class="media-file widefat" name="' . $module['_attr']['id'] . '_custom" id="' . $module['_attr']['id'] . '_custom" />' . PHP_EOL;	
	$output .= '</td><!--close .col2-->' . PHP_EOL;
	$output .= '<td class="col3" colspan="4">' . PHP_EOL;
	$output .= '</td><!--close .col3-->' . PHP_EOL;
	$output .= '</tr><!--close .inner-->' . PHP_EOL;

	$output .= '<tr class="inner meta upload-module ' . $module['_attr']['id'] . '" style="' . esc_attr( $visibility) . '">' . PHP_EOL;
	$output .= '<td class="col1">' . PHP_EOL;
	$output .= '<label class="image-preview" style="' . $display . '">' . __( 'Preview:', 'sp-theme' ) . '<img src="' . $preview_media_url . '" alt="' . esc_attr( 'Image Preview', 'sp-theme' ) . '" width="' . $width . '" height="' . $height . '" /></label>' . PHP_EOL;
	$output .= '</td><!--close .col1-->' . PHP_EOL;
	$output .= '<td class="col2">' . PHP_EOL;
	$output .= '<p class="remove-media" style="' . $display . '"><a href="#" title="' . esc_attr( 'Remove Image', 'sp-theme' ) . '" class="button" data-id="' . $module['_attr']['id'] . '">' . __( 'Remove Media', 'sp-theme' ) . '</a></p>' . PHP_EOL;
	$output .= '<input type="hidden" name="attachment_id_' . $module['_attr']['id'] . '" value="' . $attachment_id . '" class="attachment-id" />' . PHP_EOL;	
	$output .= '</td><!--close .col2-->' . PHP_EOL;
	$output .= '<td class="col3" colspan="4"></td>' . PHP_EOL;
	$output .= '</tr><!--close .meta-->' . PHP_EOL;

	return $output;		
}

/**
 * Function that displays the upload module
 *
 * @access public
 * @since 3.0
 * @todo fix the double stripslashes
 * @param array $module - the module array items
 * @return html $output
 */
function sp_add_links_module( $module = array() ) {
	$links = ( sp_get_option( $module['_attr']['id'], 'isset' ) ) ? sp_get_option( $module['_attr']['id'] ) : '';

	$output = '';

	if ( isset( $links ) && is_array( $links ) ) {
		$i = 0;

		foreach( $links['link_name'] as $link ) {
			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . __( 'Link Title', 'sp-theme' ) . '</label>' . PHP_EOL;
			$output .= '</td><!--close .col1-->' . PHP_EOL;
			$output .= '<td class="col2">' . PHP_EOL;		
			$output .= '<input type="text" value="' . esc_attr( stripslashes( stripslashes( $link ) ) ) . '" name="' . $module['_attr']['id'] . '[link_name][]" id="link-' . sp_a_clean( $module['_attr']['id'] ) . '" class="text-input widefat" />' . PHP_EOL;
					
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;		
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;			

			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . __( 'Link Content', 'sp-theme' ) . '</label>' . PHP_EOL;
			$output .= '</td><!--close .col1-->' . PHP_EOL;
			$output .= '<td class="col2" colspan="4">' . PHP_EOL;	

			$output .= '<textarea name="' . $module['_attr']['id'] . '[link_content][]" id="textarea-' . sp_a_clean( $module['_attr']['id'] ) . '" rows="8" class="widefat">' . PHP_EOL;

			$output .= stripslashes( stripslashes( $links['link_content'][ $i ] ) );

			$output .= '</textarea>' . PHP_EOL;

			$output .= '<a href="#" title="' . esc_attr__( 'Add', 'sp-theme' ) . '" class="add-link"><i class="icon-plus-sign" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Delete', 'sp-theme' ) . '" class="delete-link"><i class="icon-remove-sign" aria-hidden="true"></i></a>';	
			
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;
			$output .= '<p class="info">' . __( 'Enter the content for this link. You may use shortcodes in the content.', 'sp-theme' ) . '</p>' . PHP_EOL;			
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;

			$i++;		
		}
	} else {
			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . __( 'Link Title', 'sp-theme' ) . '</label>' . PHP_EOL;
			$output .= '</td><!--close .col1-->' . PHP_EOL;
			$output .= '<td class="col2">' . PHP_EOL;		
			$output .= '<input type="text" value="" name="' . $module['_attr']['id'] . '[link_name][]" id="link-' . sp_a_clean( $module['_attr']['id'] ) . '" class="text-input widefat" />' . PHP_EOL;
					
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;		
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;			

			$output .= '<tr class="inner ' . $module['_attr']['id'] . '">' . PHP_EOL;
			$output .= '<td class="col1">' . PHP_EOL;	
			$output .= '<label class="sub-heading">' . __( 'Link Content', 'sp-theme' ) . '</label>' . PHP_EOL;
			$output .= '</td><!--close .col1-->' . PHP_EOL;
			$output .= '<td class="col2" colspan="4">' . PHP_EOL;	

			$output .= '<textarea name="' . $module['_attr']['id'] . '[link_content][]" id="textarea-' . sp_a_clean( $module['_attr']['id'] ) . '" rows="8" class="widefat">' . PHP_EOL;
			
			// if nothing was set, get standard value
			if ( sp_get_option( $module['_attr']['id'], 'isset' ) && sp_get_option( $module['_attr']['id'] ) != '' ) 
				$output .= stripslashes( sp_get_option( $module['_attr']['id'] ) );

			$output .= '</textarea>' . PHP_EOL;

			$output .= '<a href="#" title="' . esc_attr__( 'Add', 'sp-theme' ) . '" class="add-link"><i class="icon-plus-sign" aria-hidden="true"></i></a><a href="#" title="' . esc_attr__( 'Delete', 'sp-theme' ) . '" class="delete-link"><i class="icon-remove-sign" aria-hidden="true"></i></a>';	
			
			$output .= '</td><!--close .col2-->' . PHP_EOL;	
			$output .= '<td class="col3" colspan="4">' . PHP_EOL;
			$output .= '<p class="info">' . __( 'Enter the content for this link. You may use shortcodes in the content.', 'sp-theme' ) . '</p>' . PHP_EOL;			
			$output .= '</td><!--close .col3-->' . PHP_EOL;
			$output .= '</tr><!--close .inner-->' . PHP_EOL;					
	}

	return $output;
}