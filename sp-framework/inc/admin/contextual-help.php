<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * functions for all contextual help
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_filter( 'contextual_help', '_sp_contextual_help', 10, 3 );

/**
 * Function that handles the contextual help menu
 *
 * @access private
 * @since 3.0
 * @param html $contextual_help | existing help display if any
 * @param string $screen_id | the id of the screen currently visible
 * @param object $screen | current screen's object
 * @return html $contextual_help | modified html
 */
function _sp_contextual_help( $contextual_help, $screen_id, $screen ) {

	// check what screen we're on
	switch( $screen_id ) {
		case 'sp-contact-form' :
			$content = '';
			$content .= '<p>' . __( 'Here are some of the less obvious settings and explanations.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$content .= '<ul>' . PHP_EOL;
			$content .= '<li><strong>' . __( 'Form Redirect After Submission', 'sp-theme' ) . '</strong>' . PHP_EOL;
			$content .= __( 'This option is usually off and only used if you want the page to be redirected somewhere else after a form has been submitted.', 'sp-theme' ) . '</li>' . PHP_EOL;
			$content .= '</ul>' . PHP_EOL;

			$screen->add_help_tab( array( 
			   'id' => 'contact-form-settings',
			   'title' => __( 'Contact Form Settings', 'sp-theme' ),
			   'content' => $content
			) );

			$content = '';
			$content .= '<ul>' . PHP_EOL;
			$content .= '<li>' . __( 'You may drag and drop the order of each field to your liking.  You can drag the entire field.  Be sure to click save/update after any changes.', 'sp-theme' ) . '</li>' . PHP_EOL;
			$content .= '<li>' . __( 'You may drag and drop the order of each options row to your liking.  However, please click on save/update one time after you have added options for the drag and drop to initiate.', 'sp-theme' ) . '</li>' . PHP_EOL;
			$content .= '<li>' . __( 'When the page loads, your fields with option rows are hidden by default to prevent clutter.  Simply click on the "Toggle Options" butotn to hide/show them.', 'sp-theme' ) . '</li>' . PHP_EOL;
			$content .= '<li>' . __( 'For the options row, use the drag icon to drag and drop them.', 'sp-theme' ) . '</li>' . PHP_EOL;
			$content .= '</ul>' . PHP_EOL;

			$screen->add_help_tab( array( 
			   'id' => 'contact-form-content',
			   'title' => __( 'Contact Form Content', 'sp-theme' ),
			   'content' => $content
			) );

			$content = '';
			$content .= '<p>' . __( 'Here are some of the less obvious settings and explanations.', 'sp-theme' ) . '</p>' . PHP_EOL;			
			$content .= '<ul>' . PHP_EOL;
			$content .= '<li><strong>' . __( 'Form Header Text', 'sp-theme' ) . '</strong>' . PHP_EOL;
			$content .= __( 'This is what will be displayed to the user at the top of the form to indicate what form this is for.', 'sp-theme' ) . '</li>' . PHP_EOL;
			$content .= '<li><strong>' .__( 'Email Template', 'sp-theme' ) . '</strong>' . PHP_EOL;
			$content .= __( 'This is how the email will look when the user submits the form to the admin.  You can customize this to the structure you want.  Please only use plain text and no HTML.  You may use unique tag names with brackets to place a marker on where you want the user inputted value to be.  For example if your template has "First Name" and you put [firstname] under that as the unique tag name, when the form is submitted, the [firstname] tag will be replaced with "Robbin" if the user indeed entered that as the firstname on the contact form.', 'sp-theme' ) . '</li>' . PHP_EOL;
			$content .= '</ul>' . PHP_EOL;

			$screen->add_help_tab( array( 
			   'id' => 'contact-form-messages',
			   'title' => __( 'Contact Form Messages', 'sp-theme' ),
			   'content' => $content
			) );						
			break;

		case 'nav-menus' :
			$content = '';
			$content .= '<p>' . __( 'You will find the instructions on how to use the mega menu here.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$content .= '<p>' . __( 'To enable mega menu functions, check the box that says "Enable Mega Menu".  From here you will see the title bar will now show mega menu active and you will see additional options in the menu widget.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$content .= '<h3>' . __( 'COLUMNS', 'sp-theme' ) . '</h3>' . PHP_EOL;
			$content .= '<p>' . __( 'After you have enabled the mega menu for the menu widget, everything that is under this parent will be mega menu enabled.  The first level "depth-1" will be your columns in the mega menu.  "depth-1" means one level deeper than the parent.  Any items can be made to a column simply by dragging it into "depth-1" level.  You will know when the menu item has become a column when you see it in the title bar.  You can optionally leave a title for the column however if you want to have no title, don\'t leave the field blank but instead type three equals like so "===".  If you leave it blank WordPress will remove the menu item.', 'sp-theme' ) . '</p>' . PHP_EOL;

			$content .= '<p>' . __( 'For the column level, you can check the box that says "This column should start a new row" to make a new row for your columns.  For example you have 3 columns already and would like the 4th column to start from the beginning at the left, you would check this box.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$content .= '<p>' . __( 'Any items you drag under a column at depth-2 will show on the same column.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$content .= '<h3>' . __( 'TEXT BLOCKS', 'sp-theme' ) . '</h3>' . PHP_EOL;
			$content .= '<p>' . __( 'To make a menu item into a text block where you can enter your custom message or even an image, simply check that box that says "Use description box as a textblock...".  Once checked, you can confirm this by looking at the menu item title bar.  It will say "textblock".  You can now utilize the description input box for your text.  If you don\'t see the description box, it is probably hidden.  Go to the top right of your screen and click on "Screen Options".  From there just tick the box that says "description" to enable it.  Textblocks have no titles so the title field will not be used however do not leave this field blank as WordPress will remove the menu item. Enter three equals like so "===" instead of leaving the title blank.', 'sp-theme' ) . '</p>' . PHP_EOL;
			$content .= '<p>' . __( 'For textblocks, you can add images into the menu by either pasting your image URL into the add image field or choosing your image media from your library.  You can even leave the textblock content empty and just show an image or you can have both.', 'sp-theme' ) . '</p>' . PHP_EOL;

			$screen->add_help_tab( array( 
				'id' => 'mega-menu-help',
				'title' => __( 'Mega Menu', 'sp-theme' ),
				'content' => $content
			) );

			$content = '';

			$content .= '<p>' . __( 'To add an icon to any of your menu items, check the box that says "Show Menu Icon" and below that enter the icon class name you would like to use.  Please note that in order for the icon to show, you must have a menu label.', 'sp-theme' ) . '</p>' . PHP_EOL;

			$screen->add_help_tab( array( 
				'id' => 'menu-icon-help',
				'title' => __( 'Menu Icon', 'sp-theme' ),
				'content' => $content
			) );

			break;
	}
}