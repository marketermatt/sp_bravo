<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * admin mega menu functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

// menu backend edit page
add_filter( 'wp_edit_nav_menu_walker', '_sp_custom_backend_walker' );

/**
 * Function that returns the custom backend class
 * 
 * @access private
 * @since 3.0
 * @return class name
 *
 */
function _sp_custom_backend_walker() {
	return '_sp_custom_backend_walker';
}

/**
 * Class that extends the walker for the backend menu
 * 
 * @access private
 * @since 3.0
 * @return class name
 *
 */
class _sp_custom_backend_walker extends Walker_Nav_Menu {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;

		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);
		
		// get meta
		$menu_enable = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-enable', true );
		$full_width = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-full-width', true );
		$new_row = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-new-row', true );
		$use_text = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-use-text', true );
		$show_menu_icon = get_post_meta( $item->ID, '_menu-item-sp-show-icon', true );
		$icon_class = get_post_meta( $item->ID, '_menu-item-sp-icon-class', true );				
		$image = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-image', true );	
		
		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );

			if ( is_object( $original_object ) )
				$original_title = $original_object->post_title;
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)', 'sp-theme' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)', 'sp-theme' ), $item->title );
		}

		// if text block
		if ( $use_text === 'on' && $depth === 2 )
			$classes[] = 'is-text-block';

		// if depth is 1
		if ( $depth === 1 )
			$classes[] = 'is-column';

		$title = empty( $item->label ) ? $title : $item->label;

		$active_class = '';
		
		// only check on first parent level menu item
		if ( $depth === 0 ) {
			// get the meta
			$active_class = get_post_meta( $item->ID, '_menu-item-sp-mega-menu-enable', true );

			// set the class
			$active_class === 'on' ? $active_class = 'sp-mega-menu-enable' : $active_class = '';
		}
		?>
		<li id="menu-item-<?php echo $item_id; ?>" class="sp-mega-menu-item <?php echo esc_attr( $active_class ) . ' ' . implode( ' ', $classes ); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><?php echo esc_html( $title ); ?></span>
					<span class="item-controls">
						<span class="item-type item-type-sp-default-text"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-type item-type-sp-column-text"><?php _e( 'Column', 'sp-theme' ); ?></span>
						<span class="item-type item-type-sp-textblock-text"><?php _e( 'Textblock', 'sp-theme' ); ?></span>
						<span class="item-type item-type-sp-mega-menu-text"><?php _e( '(Mega Menu Active)', 'sp-theme' ); ?></span>						
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e( 'Move up', 'sp-theme' ); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e( 'Move down', 'sp-theme' ); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e( 'Edit Menu Item', 'sp-theme' ); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php _e( 'Edit Menu Item', 'sp-theme' ); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo $item_id; ?>">
							<?php _e( 'URL', 'sp-theme' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin description-label">
					<label for="edit-menu-item-title-<?php echo $item_id; ?>">
						<span class="sp-default-menu-label"><?php _e( 'Navigation Label', 'sp-theme' ); ?></span>
						<span class="sp-mega-menu-column-label"><?php _e( 'Mega Menu Column Title', 'sp-theme' ); ?></span>
					
						<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>				
				<p class="description description-thin description-title">
					<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
						<?php _e( 'Title Attribute', 'sp-theme' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo $item_id; ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php _e( 'Open link in a new window/tab', 'sp-theme' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
						<?php _e( 'CSS Classes (optional)', 'sp-theme' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
						<?php _e( 'Link Relationship (XFN)', 'sp-theme' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>

				<p class="show-icon description">
					<label for="edit-menu-item-sp-show-icon-<?php echo $item_id; ?>">
						<input type="checkbox" id="edit-menu-item-sp-show-icon-<?php echo $item_id; ?>" value="on" name="menu-item-sp-show-icon[<?php echo $item_id; ?>]"<?php checked( $show_menu_icon, 'on' ); ?> class="show-menu-icon" />
						<?php _e( 'Show Menu Icon', 'sp-theme' ); ?>
					</label>
				</p>
				<p class="icon-class description description-thin">
					<label for="edit-menu-item-icon-class-<?php echo $item_id; ?>">
						<?php _e( 'Menu Icon Class', 'sp-theme' ); ?><br />
						<input type="text" id="edit-menu-item-icon-class-<?php echo $item_id; ?>" class="widefat code edit-menu-item-icon-class" name="menu-item-sp-icon-class[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $icon_class ); ?>" />
					</label>
				</p>								
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo $item_id; ?>">
						<?php _e( 'Description', 'sp-theme' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
					</label>
				</p>

				<?php // add custom options for the mega menu ?>
				<div class="sp-mega-menu-options">

					<p class="field-sp-mega-menu-enable description description-wide">
						<label for="edit-menu-item-mega-menu-enable-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-mega-menu-enable-<?php echo $item_id; ?>" value="on" name="menu-item-sp-mega-menu-enable[<?php echo $item_id; ?>]"<?php checked( $menu_enable, 'on' ); ?> class="enable-mega-menu" />
							<?php _e( 'Enable Mega Menu', 'sp-theme' ); ?>
						</label>
					</p>
					<p class="field-sp-mega-menu-full-width description description-wide">
						<label for="edit-menu-item-mega-menu-full-width-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-mega-menu-full-width-<?php echo $item_id; ?>" value="on" name="menu-item-sp-mega-menu-full-width[<?php echo $item_id; ?>]"<?php checked( $full_width, 'on' ); ?>  />
							<?php _e( 'Show Full Width Menu', 'sp-theme' ); ?>
						</label>
					</p>					
					<p class="field-sp-mega-menu-new-row description description-wide">
						<label for="edit-menu-item-mega-menu-new-row-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-mega-menu-new-row-<?php echo $item_id; ?>" value="on" name="menu-item-sp-mega-menu-new-row[<?php echo $item_id; ?>]"<?php checked( $new_row, 'on' ); ?> />
							<?php _e( 'This column should start a new row', 'sp-theme' ); ?>
						</label>
					</p>
					<p class="field-sp-mega-menu-use-text description description-wide">
						<label for="edit-menu-item-mega-menu-use-text-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-mega-menu-use-text-<?php echo $item_id; ?>" value="on" name="menu-item-sp-mega-menu-use-text[<?php echo $item_id; ?>]"<?php checked( $use_text, 'on' ); ?> class="use-textblock" />
							<?php _e( 'Use description box as a textblock and disable menu link function for this widget item.  This will convert to a text block.', 'sp-theme' ); ?>
						</label>
					</p>	

					<p class="field-sp-mega-menu-image description description-wide">
						<label for="edit-menu-item-mega-menu-image-<?php echo $item_id; ?>">
							<span class="sp-image-menu-label"><?php _e( 'Add Image', 'sp-theme' ); ?></span>
							<input type="text" id="edit-menu-item-mega-menu-image-<?php echo $item_id; ?>" value="<?php echo esc_attr( $image ); ?>" name="menu-item-sp-mega-menu-image[<?php echo $item_id; ?>]" class="image media-file" />
						</label>
						<a class="button media-upload" title="<?php esc_attr_e( 'Image Upload', 'sp-theme' ); ?>"><?php _e( 'Choose Media', 'sp-theme' ); ?></a>
					</p>																				
				</div><!--close .sp-mega-menu-options-->
				
				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __( 'Original: %s', 'sp-theme' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<p class="howto hide-label-text"><?php _e( 'If you want to hide the label/title, simply type 3 equal signs like so "===".  This prevents WordPress from deleting  your menu item.', 'sp-theme' ); ?></p>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php _e( 'Remove', 'sp-theme' ); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php	echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
						?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e( 'Cancel', 'sp-theme' ); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}
}

// menu backend save function
add_action( 'wp_update_nav_menu_item', '_sp_custom_backend_walker_update', 100, 3 );

/**
 * Function that handles the custom walker update
 * 
 * @access private
 * @since 3.0
 * @param int $menu_id | the id of the menu
 * @param int $menu_item_db_id | id of the menu item
 * @return boolean true
 *
 */
function _sp_custom_backend_walker_update( $menu_id, $menu_item_db_id, $args ) {
	$field_names = array( 'enable', 'new-row', 'use-text', 'full-width' );

	foreach ( $field_names as $field ) {
		if ( isset( $_POST['menu-item-sp-mega-menu-' . $field][$menu_item_db_id] ) )
			$value = sanitize_text_field( $_POST['menu-item-sp-mega-menu-' . $field][$menu_item_db_id] );
		else
			$value = 'off';
		
		update_post_meta( $menu_item_db_id, '_menu-item-sp-mega-menu-' . $field, $value );
	}

	// show menu icon
	if ( isset( $_POST['menu-item-sp-show-icon'][$menu_item_db_id] ) )
		update_post_meta( $menu_item_db_id, '_menu-item-sp-show-icon', 'on' );
	else
		update_post_meta( $menu_item_db_id, '_menu-item-sp-show-icon', 'off' );

	// icon class
	if ( isset( $_POST['menu-item-sp-icon-class'][$menu_item_db_id] ) )
		update_post_meta( $menu_item_db_id, '_menu-item-sp-icon-class', sanitize_text_field( $_POST['menu-item-sp-icon-class'][$menu_item_db_id] ) );

	// image
	if ( isset( $_POST['menu-item-sp-mega-menu-image'][$menu_item_db_id] ) )
		update_post_meta( $menu_item_db_id, '_menu-item-sp-mega-menu-image', sanitize_text_field( $_POST['menu-item-sp-mega-menu-image'][$menu_item_db_id] ) );

	return true;
}

/* for future use
add_action( 'admin_init', '_sp_admin_menu_meta_box' );

function _sp_admin_menu_meta_box() {

}

function _sp_admin_menu_image_item_display() {
?> 

	<div id="imageitemdiv" class="imageitemdiv">
		<div id="tabs-panel-imageitem" class="tabs-panel tabs-panel-active">
			<ul id="imageitem-checklist" class="categorychecklist form-no-clear">
				<li>
					<input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="custom">
					<input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]" value="<?php esc_attr_e( 'Image Item', 'sp-theme' ); ?>">
					<input type="hidden" class="menu-item-classes" name="menu-item[-1][menu-item-classes]" value="image-item">

					<p id="menu-item-image-wrap">
						<label class="menu-item-title">
							<input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]" value="-1">
							<?php _e( 'Image Item', 'sp-theme' ); ?>
						</label>
					</p>
				</li>
			</ul>
		</div>

		<p class="button-controls">
			<span class="add-to-menu">
				<input id="submit-imageitemdiv" class="button-secondary submit-add-to-menu right" type="submit" name="add-custom-menu-item" value="<?php esc_attr_e( 'Add to Menu', 'sp-theme' ); ?>">
				<span class="spinner"></span>
			</span>
		</p>
	</div>

<?php
}
*/