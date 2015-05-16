<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * Adapted from Christian "Kriesi" Budschedl's mega menu and modified to suit our needs.
 * Attribution goes out to Kriesi for his awesome work on this.
 * menus
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

class SP_Menu extends Walker_Nav_Menu {

	private $mega_menu_status = '';

	private $full_width = '';

	private $rows = 1;

	private $row_counter = array();

	private $columns = 0;

	private $max_columns = 0;

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);

		// add placeholder for later manipulation
		if ( $depth === 0 ) $output .= PHP_EOL . '{placeholder_column}' . PHP_EOL;

		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";

		// add placeholder for later manipulation
		if ( $depth === 0 ) {
			if ( $this->mega_menu_status === 'on' ) {

				$output .= PHP_EOL . '</div><!--close .sp-mega-menu-column-container-->' . PHP_EOL;
				$output = str_replace( '{placeholder_column}', '<div class="sp-mega-menu-column-container columns-' . $this->max_columns . '">', $output );
				
				foreach( $this->row_counter as $row => $columns ) {
					$output = str_replace( '{placeholder_current_row_' . $row . '}', 'sp-mega-menu-columns-' . $columns, $output );
				}
				
				// reset values
				$this->columns = 0;
				$this->max_columns = 0;
				$this->row_counter = array();
				
			} else {
				$output = str_replace( '{placeholder_column}', '', $output );
			}
		}		
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		// get show icon settings
		$show_icon = get_post_meta( $item->ID, '_menu-item-sp-show-icon', true );

		// get icon class
		$icon_class = get_post_meta( $item->ID, '_menu-item-sp-icon-class', true );

		// get image
		$image = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-image', true );	

		// build icon
		$icon = '';

		if ( $show_icon === 'on' && ! empty( $icon_class ) )
			$icon .= '<i class="menu-icon ' . esc_attr( $icon_class ) . '" aria-hidden="true"></i> ';

		// only get meta on depth 0
		if ( $depth === 0 ) {
			$this->mega_menu_status = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-enable', true );
			$this->full_width = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-full-width', true );
		}

		// set default maximum columns if none set
		if ( ! isset( $args->max_columns ) ) $args->max_columns = 5;

		$item_output = $item_textblock_class = $column_class = '';

		// column
		if ( $this->mega_menu_status === 'on' && $depth === 1 ) {
			// increment the columns by 1
			$this->columns++;
			
			// if number of columns is more than the default max or a new row is needed
			if ( $this->columns > $args->max_columns || ( get_post_meta( $item->ID, '_menu-item-sp-mega-menu-new-row', true ) === 'on' && $this->columns != 1 ) ) {
				// set column back to 1
				$this->columns = 1;

				// increment the rows by 1
				$this->rows++;

				// output a row divider element
				$output .= PHP_EOL . '<li class="sp-mega-menu-row-divider"></li>' . PHP_EOL;
			}
			
			// set the row counter to the current columns count
			$this->row_counter[$this->rows] = $this->columns;
			
			// if the max columns is less than the current column count, set max column to current columns count
			if ( $this->max_columns < $this->columns) $this->max_columns = $this->columns;
			
			// user filter for title
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			
			// show title if set and not a token
			if ( $title !== '===' ) $item_output .= '<h3>' . $icon . $title . '</h3>';
			
			// set the class of current row to be manipulated later
			$column_class = '{placeholder_current_row_' . $this->rows . '}';
			
			// set the class of first for first item in list
			if ( $this->columns == 1 ) $column_class .= ' sp-mega-menu-columns-first';

			// set the general class
			$column_class .= ' sp-mega-menu-column';
			
		} elseif ( $this->mega_menu_status === 'on' && $depth >= 2 && get_post_meta( $item->ID, '_menu-item-sp-mega-menu-use-text', true ) === 'on' ) {
			// set textblock class for styling
			$item_textblock_class = 'sp-mega-menu-textblock';
			
			// allow shortcode for the description box
			$item_output .= do_shortcode( $item->post_content );

			// if image is set
			if ( isset( $image ) && ! empty( $image ) )
				$item_output .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Menu Image', 'sp-theme' ) . '" />';
			
		} else {

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>' . $icon;
			
			if ( $this->mega_menu_status === 'on' && $depth > 2 ) {
				$item_output .= '<i class="menu-indicator-sub ' . esc_attr( apply_filters( 'sp_mega_menu_indicators_sub', 'icon-angle-right' ) ) . '" aria-hidden="true"></i> ' . PHP_EOL;
			}

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

			// check if any children items and is depth 0
			if ( $children = get_posts( array( 'post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID ) ) && $depth === 0 )
				$item_output .= ' <i class="menu-indicator-parent ' . esc_attr( apply_filters( 'sp_menu_indicators_parent', 'icon-angle-down' ) ) . '" aria-hidden="true"></i><span class="menu-arrow"></span>' . PHP_EOL;

			if ( $this->mega_menu_status !== 'on' ) {
				// check if any children items and is depth 1+
				if ( $children = get_posts( array( 'post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID ) ) && $depth > 0 )
					$item_output .= ' <i class="menu-indicator-sub ' . esc_attr( apply_filters( 'sp_menu_indicators_sub', 'icon-angle-right' ) ) . '" aria-hidden="true"></i>' . PHP_EOL;
			}

			$item_output .= '</a>';
			$item_output .= $args->after;
		}

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// add additional classes for mega menu
		if ( $this->mega_menu_status === 'on' ) {
			$classes[] = 'sp-mega-menu-active';
			$classes[] = $item_textblock_class;
			$classes[] = $column_class;

			// add full width class if set
			if ( isset( $this->full_width ) && $this->full_width === 'on' )
				$classes[] = 'sp-mega-menu-full-width';			
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		// check if any children items and is depth 0
		if ( $children = get_posts( array( 'post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID ) ) && $depth === 0 )
			$output .= '<span class="menu-arrow"></span>' . PHP_EOL;

		$output .= "</li>\n";
	}
}

class SP_Footer_Menu extends Walker {

	/**
	 * @see Walker::$tree_type
	 * @since 3.0.0
	 * @var string
	 */
	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * @see Walker::$db_fields
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );		
	}

	/**
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";

	}

	/**
	 * Display array of elements hierarchically.
	 *
	 * It is a generic function which does not assume any existing order of
	 * elements. max_depth = -1 means flatly display every element. max_depth =
	 * 0 means display all levels. max_depth > 0  specifies the number of
	 * display levels.
	 *
	 * @since 2.1.0
	 *
	 * @param array $elements
	 * @param int $max_depth
	 * @return string
	 */
	function walk( $elements, $max_depth) {

		$args = array_slice(func_get_args(), 2);
		$output = '';

		if ($max_depth < -1) //invalid parameter
			return $output;

		if (empty($elements)) //nothing to walk
			return $output;

		$id_field = $this->db_fields['id'];
		$parent_field = $this->db_fields['parent'];

		// flat display
		if ( -1 == $max_depth ) {
			$empty_array = array();
			foreach ( $elements as $e )
				$this->display_element( $e, $empty_array, 1, 0, $args, $output );
			return $output;
		}

		/*
		 * need to display in hierarchical order
		 * separate elements into two buckets: top level and children elements
		 * children_elements is two dimensional array, eg.
		 * children_elements[10][] contains all sub-elements whose parent is 10.
		 */
		$top_level_elements = array();
		$children_elements  = array();
		foreach ( $elements as $e) {
			if ( 0 == $e->$parent_field )
				$top_level_elements[] = $e;
			else
				$children_elements[ $e->$parent_field ][] = $e;
		}

		/*
		 * when none of the elements is top level
		 * assume the first one must be root of the sub elements
		 */
		if ( empty($top_level_elements) ) {

			$first = array_slice( $elements, 0, 1 );
			$root = $first[0];

			$top_level_elements = array();
			$children_elements  = array();
			foreach ( $elements as $e) {
				if ( $root->$parent_field == $e->$parent_field )
					$top_level_elements[] = $e;
				else
					$children_elements[ $e->$parent_field ][] = $e;
			}
		}

		// put the array in a temp variable
		$temp = $top_level_elements;

		// get the last array element
		$last_child = array_pop( $temp );

		foreach ( $top_level_elements as $e ) {
			$this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
		}

		/*
		 * if we are displaying all levels, and remaining children_elements is not empty,
		 * then we got orphans, which should be displayed regardless
		 */
		if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
			$empty_array = array();
			foreach ( $children_elements as $orphans )
				foreach( $orphans as $op )
					$this->display_element( $op, $empty_array, 1, 0, $args, $output );
		 }

		return $output;
	}	
}