<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * customizer
*/

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_action( 'customize_controls_init', '_sp_redirect_close_button' );

/** 
 * Function that redirects the close button URL to theme options page
 *
 * @access private 
 * @since 3.0
 * @return URL $return | theme options url
 */
function _sp_redirect_close_button() {
	global $return;

	return $return = admin_url( 'admin.php?page=sp' );
}

function _sp_generate_control( $wp_customize, $id, $control, $section, $label, $priority, $choices ) {
	if ( ! isset( $id ) )
		return;
	
	switch( $control ) {
		case 'text' :
			$wp_customize->add_control( new Customize_Text_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'type'		=> 'text',
					'priority'	=> (int)$priority
					)
				)
			); 
			break;

		case 'font' :
			$wp_customize->add_control( new Customize_Font_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);
			break;

		case 'font_variant' :
			$wp_customize->add_control( new Customize_Font_Variant_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);
			break;

		case 'font_subset' :
			$wp_customize->add_control( new Customize_Font_Subset_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);
			break;

		case 'upload' :
			$wp_customize->add_control( $upload_control = new WP_Customize_Image_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);

			$upload_control->add_tab( 'library', __( 'Media Library', 'sp-theme' ), '_sp_customizer_media_library_tab' );
			break;

		case 'colorpicker' :
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);
			break;

		case 'text_size' :
			$wp_customize->add_control( new Customize_Text_Size_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);
			break;

		case 'radio' :
			$choices = explode( ',', $choices );

			foreach( $choices as $choice ) {
				$choices_array[$choice] = $choice;
			}

			$wp_customize->add_control( new Customize_Radio_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'type'		=> 'radio',
					'priority'	=> (int)$priority,
					'choices'	=> $choices_array
					)
				)
			);
			break;                                                 

		case 'select' :
			$choices = explode( ',', $choices );

			$choices_array['none'] = __( '--Please Select--', 'sp-theme' );

			foreach( $choices as $choice ) {
				$choices_array[$choice] = $choice;
			}

			$wp_customize->add_control( new Customize_Select_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'type'		=> 'select',
					'priority'	=> (int)$priority,
					'choices'	=> $choices_array
					)
				)
			);
			break;

		case 'predefined_bg' :
			$wp_customize->add_control( new Customize_BG_Predefined_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);
			break; 

		case 'reset_default' :
			$wp_customize->add_control( new Customize_Reset_Default_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);
			break; 

		case 'divider' :
			$wp_customize->add_control( new Customize_Divider_Control( $wp_customize, $id, array( 
					'label'		=> sprintf( __( '%s', 'sp-theme' ), $label ),
					'section'	=> $section,
					'settings'	=> $id,
					'priority'	=> (int)$priority
					)
				)
			);
			break; 				                                                 
	}
}

function _sp_customizer_media_library_tab() {
	printf( '<a class="media-upload button customizer-media-library">%s</a>', __( 'Choose Media', 'sp-theme' ) );

	return true;
}

add_action( 'customize_register', '_sp_customize_register' );

/** 
 * Function that handles all sections, settings and controls of the customizer
 *
 * @access private 
 * @since 3.0
 * @param $wp_customize | object
 * @return boolean true
 */
function _sp_customize_register( $wp_customize ) { 

	/////////////////////////////////////////////////////
	// text control class
	/////////////////////////////////////////////////////   
	class Customize_Text_Control extends WP_Customize_Control {
		public $type = 'text';

		public function render_content() {
			$this_default = $this->setting->default;

			$output = ''; 
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<label>' . PHP_EOL;
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>' . PHP_EOL;
			$output .= '</label>' . PHP_EOL;
			$output .= '<input type="text" ' . $this->get_link() . ' value="' . esc_attr( $this->value() ) . '" />' . PHP_EOL;
			$output .= '<input type="hidden" data-default-setting="' . esc_attr( $this_default ) . '" class="default-setting" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	/////////////////////////////////////////////////////
	// text size control class
	/////////////////////////////////////////////////////   
	class Customize_Text_Size_Control extends WP_Customize_Control {
		public $type = 'text-size';

		public function render_content() {
			$this_default = $this->setting->default;

			$this_default = $this_default == '' ? '14px' : $this_default;
			 
			$output = '';
			$output .= '<label>' . PHP_EOL;
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>' . PHP_EOL;
			$output .= '</label>' . PHP_EOL;
			$output .= '<div class="size-slider">' . PHP_EOL;
			$output .= '<div class="values">' . PHP_EOL;
			$output .= '<span class="min">1px</span>' . PHP_EOL;
			$output .= '<span class="max">50px</span>' . PHP_EOL;
			$output .= '<span class="value">1px</span>' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;
			$output .= '<input type="text" ' . $this->get_link() . ' value="' . esc_attr( $this->value() ) . '" />' . PHP_EOL;
			$output .= '<div class="slider"></div>' . PHP_EOL;
			$output .= '<a href="#" title="' . esc_attr__( 'Default', 'sp-theme' ) . '" data-default="' . esc_attr( $this_default ) . '" class="default-size button button-small">' . __( 'Default', 'sp-theme' ) . '</a>' . PHP_EOL;
			$output .= '<input type="hidden" data-default-setting="' . esc_attr( $this_default ) . '" class="default-setting" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			 echo $output;
		}
   }   

	/////////////////////////////////////////////////////
	// font control class
	/////////////////////////////////////////////////////   
	class Customize_Font_Control extends WP_Customize_Control {
		public $type = 'select';

		public function render_content() {
			$this_default = $this->setting->default;

			$fonts = sp_get_google_fonts();

			$output = '';
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<label>' . PHP_EOL;
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>' . PHP_EOL;
			$output .= '</label>' . PHP_EOL;
			$output .= '<select ' . $this->get_link() . ' class="select2-select font-select" data-no_results_text="' . __( 'No results match', 'sp-theme' ) . '">' . PHP_EOL;
			$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

			foreach( $fonts as $font ) {
				$output .= '<option value="' . esc_attr( $font['family'] ) . '" ' . selected( $this_default, $font['family'], false ) . '>' . $font['family'] . '</option>' . PHP_EOL;
			}

			$output .= '</select>' . PHP_EOL;
			$output .= '<input type="hidden" data-default-setting="' . esc_attr( $this_default ) . '" class="default-setting" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	/////////////////////////////////////////////////////
	// font variant control class
	/////////////////////////////////////////////////////   
	class Customize_Font_Variant_Control extends WP_Customize_Control {
		public $type = 'select';

		public function render_content() {
			$this_default = $this->setting->default;

			$saved_font = get_theme_mod( str_replace( '_variant', '', $this->id ) );

			$variants = sp_get_font( $saved_font );

			$output = ''; 
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<label>' . PHP_EOL;
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>' . PHP_EOL;
			$output .= '</label>' . PHP_EOL;
			$output .= '<select ' . $this->get_link() . ' class="select2-select font-variant-select">' . PHP_EOL;
			$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

			if ( is_array( $variants ) && isset( $variants ) ) {
				foreach( $variants['variants'] as $variant ) {
					$output .= '<option value="' . esc_attr( $variant ) . '" ' . selected( $this_default, $variant, false ) . '>' . $variant . '</option>' . PHP_EOL;
				}
			}

			$output .= '</select>' . PHP_EOL;
			$output .= '<input type="hidden" data-default-setting="' . esc_attr( $this_default ) . '" class="default-setting" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	/////////////////////////////////////////////////////
	// font subset control class
	/////////////////////////////////////////////////////   
	class Customize_Font_Subset_Control extends WP_Customize_Control {
		public $type = 'select';

		public function render_content() {
			$this_default = $this->setting->default;

			$saved_font = get_theme_mod( str_replace( '_subset', '', $this->id ) );

			$subsets = sp_get_font( $saved_font );

			$output = ''; 
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<label>' . PHP_EOL;
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>' . PHP_EOL;
			$output .= '</label>' . PHP_EOL;
			$output .= '<select ' . $this->get_link() . ' class="select2-select font-subset-select" multiple="multiple" data-placeholder="' . __( '--Please Select--', 'sp-theme' ) . '">' . PHP_EOL;
			$output .= '<option value="none">' . __( '--Please Select--', 'sp-theme' ) . '</option>' . PHP_EOL;

			if ( is_array( $subsets ) && isset( $subsets ) ) {
				foreach( $subsets['subsets'] as $subset ) {
			   		$output .= '<option value="' . esc_attr( $subset ) . '" ' . selected( $this_default, $subset, false ) . '>' . $subset . '</option>' . PHP_EOL;
				}
			}

			$output .= '</select>' . PHP_EOL;
			$output .= '<input type="hidden" data-default-setting="' . esc_attr( $this_default ) . '" class="default-setting" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	/////////////////////////////////////////////////////
	// select control class
	/////////////////////////////////////////////////////   
	class Customize_Select_Control extends WP_Customize_Control {
		public $type = 'select';

		public function render_content() {
			$this_default = $this->setting->default;

			$output = '';
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<label>' . PHP_EOL;
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>' . PHP_EOL;
			$output .= '<select ' . $this->get_link() . ' class="select2-select">' . PHP_EOL;
			foreach ( $this->choices as $value => $label )
				$output .= '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>' . PHP_EOL;

			$output .= '</select>' . PHP_EOL;
			$output .= '</label>' .PHP_EOL;
			$output .= '<input type="hidden" data-default-setting="' . esc_attr( $this_default ) . '" class="default-setting" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	/////////////////////////////////////////////////////
	// predefined background image control class
	/////////////////////////////////////////////////////   
	class Customize_BG_Predefined_Control extends WP_Customize_Control {
		public $type = 'select';

		public function render_content() {
			$this_default = $this->setting->default;

			$options = sp_get_background_images();

			$output = '';
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<label>' . PHP_EOL;
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>' . PHP_EOL;
			$output .= '</label>' . PHP_EOL;
			$output .= '<select ' . $this->get_link() . ' class="select2-select predefined-bg">' . PHP_EOL;

			foreach( $options as $k => $v ) {
				$output .= '<option value="' . esc_attr( $k ) . '" ' . selected( $k, $this_default, false ) . '>' . str_replace( array( '.jpg', '.png' ), '', $v ) . '</option>' . PHP_EOL;
			}

			$output .= '</select>' . PHP_EOL;
			$output .= '<input type="hidden" data-default-setting="' . esc_attr( $this_default ) . '" class="default-setting" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	/////////////////////////////////////////////////////
	// radio control class
	/////////////////////////////////////////////////////   
	class Customize_Radio_Control extends WP_Customize_Control {
		public $type = 'radio';

		public function render_content() {
			$this_default = $this->setting->default;

			$name = '_customize-radio-' . $this->id;

			$output = '';
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<label>' . PHP_EOL;
			$output .= '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>' . PHP_EOL;
			$output .= '</label>' . PHP_EOL;

			foreach ( $this->choices as $value => $label ) {
				$output .= '<label>' . PHP_EOL;
				$output .= '<input type="radio" value="' . esc_attr( $value ) . '" name="' . esc_attr( $name ) . '" ' . $this->get_link() . ' ' . checked( $this->value(), $value, false ) . ' />' . PHP_EOL;
				$output .= esc_html( $label ) . '<br/>' . PHP_EOL;
				$output .= '</label>' . PHP_EOL;
			}

			$output .= '<input type="hidden" data-default-setting="' . esc_attr( $this_default ) . '" class="default-setting" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	/////////////////////////////////////////////////////
	// reset default control class
	/////////////////////////////////////////////////////   
	class Customize_Reset_Default_Control extends WP_Customize_Control {

		public function render_content() {

			$output = '';
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<a href="#" title="' . __( 'Reset Section to default settings', 'sp-theme' ) . '" class="customizer-reset-default button">' . __( 'Reset Default Settings', 'sp-theme' ) . '</a>' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	/////////////////////////////////////////////////////
	// divider control class
	/////////////////////////////////////////////////////   
	class Customize_Divider_Control extends WP_Customize_Control {

		public function render_content() {

			$output = '';
			$output .= '<div class="control-wrap">' . PHP_EOL;
			$output .= '<hr class="customize-divider" />' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;

			echo $output;
		}
	}

	global $sptheme_config;

	// remove section & controls
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_control( 'static_front_page' );
	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->remove_control( 'title_tagline' );
	$wp_customize->remove_section( 'nav' );
	$wp_customize->remove_control( 'nav' );

	// sections
	if ( is_array( $sptheme_config['init']['customizer_sections'] ) ) {
		$priority = 35;

		foreach ( $sptheme_config['init']['customizer_sections'] as $sections ) {
			// check for woo
			if ( $sections['_attr']['context'] === 'woo' && sp_woo_exists() ) {
				$wp_customize->add_panel( strtolower( str_replace( ' ', '_', $sections['_attr']['section'] ) ) . '_panel', array(
					'title' => sprintf( __( '%s', 'sp-theme' ), $sections['_attr']['section'] ),
					'priority' => $priority,
					'capability' => 'edit_theme_options',
					'description' => sprintf( __( '%s', 'sp-theme' ), $sections['_attr']['section'] . ' ' . __( 'Customization', 'sp-theme' ) )
					)
				);

				$wp_customize->add_section( strtolower( str_replace( ' ', '_', $sections['_attr']['section'] ) ), array(
					'title' => sprintf( __( '%s', 'sp-theme' ), $sections['_attr']['section'] ),
					'priority' => $priority,
					'capability' => 'edit_theme_options',
					'description' => sprintf( __( '%s', 'sp-theme' ), $sections['_attr']['section'] . ' ' . __( 'Customization', 'sp-theme' ) ),
					'panel' => strtolower( str_replace( ' ', '_', $sections['_attr']['section'] ) ) . '_panel'
					)
				);
			} elseif ( $sections['_attr']['context'] !== 'woo' ) {
				$wp_customize->add_panel( strtolower( str_replace( ' ', '_', $sections['_attr']['section'] ) ) . '_panel', array(
					'title' => sprintf( __( '%s', 'sp-theme' ), $sections['_attr']['section'] ),
					'priority' => $priority,
					'capability' => 'edit_theme_options',
					'description' => sprintf( __( '%s', 'sp-theme' ), $sections['_attr']['section'] . ' ' . __( 'Customization', 'sp-theme' ) )
					)
				);

				$wp_customize->add_section( strtolower( str_replace( ' ', '_', $sections['_attr']['section'] ) ), array(
					'title' => sprintf( __( '%s', 'sp-theme' ), $sections['_attr']['section'] ),
					'priority' => $priority,
					'capability' => 'edit_theme_options',
					'description' => sprintf( __( '%s', 'sp-theme' ), $sections['_attr']['section'] . ' ' . __( 'Customization', 'sp-theme' ) ),
					'panel' => strtolower( str_replace( ' ', '_', $sections['_attr']['section'] ) ) . '_panel'
					)
				);
			}

			$priority++;			
		}
	}

	// generate controls
	if ( is_array( $sptheme_config['init']['customizer'] ) ) {
		foreach ( $sptheme_config['init']['customizer'] as $setting ) {
			// Settings
			$wp_customize->add_setting( $setting['_attr']['id'], array(
				'default'     => $setting['_attr']['std'],
				'type'        => 'theme_mod',
				'capability'  => 'edit_theme_options',
				'transport'   => 'postMessage'
				)
			); 

			$choices = isset( $setting['_attr']['choices'] ) ? $setting['_attr']['choices'] : '';

			// generate the control
			_sp_generate_control( $wp_customize, $setting['_attr']['id'], $setting['_attr']['control'], $setting['_attr']['section'], $setting['_attr']['label'], $setting['_attr']['priority'], $choices );
		}
	}

	return true;           
}
