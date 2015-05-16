<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * control panel display
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

// add the sp menu
if ( current_user_can( 'manage_options' ) ) 
	add_action( 'admin_menu', 'sp_admin_menu' );

/**
 * Function that adds the menu pages
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_admin_menu() {
		global $spthemeinfo;		
		
		add_menu_page( 'sp', THEME_NAME, 'manage_options', 'sp', 'sp_panel', apply_filters( 'sp_backend_panel_menu_icon', 'none' ), '56.777');
		add_submenu_page( 'sp', THEME_NAME, 'Theme Settings', 'manage_options', 'sp', 'sp_panel' );			

		return true;
}

/**
 * Function that displays the control panel
 *
 * @access public
 * @since 3.0
 * @return boolean true
 */
function sp_panel() { 
	global $sptheme_config, $notification;	 

	// if form is submitted with JS turned off do nothing
	if ( isset( $_POST['save'] ) ) {
		continue;
	}
?>
    <div class="wrap sp-panel"><h2 class="notice-hack"></h2>
    	<?php 
    	// check if any notification is set
    	if ( isset( $notification ) && $notification != '' ) {
	    	// show theme notification if hide message is not set
	    	if ( ! sp_get_option( 'hide_msg', 'isset' ) || sp_get_option( 'hide_msg', 'is', '' ) || sp_get_option( 'hide_msg', 'is', 'false' ) ) { 
	    		echo '<div class="updated">' . $notification . '</div>';
	    	} 
		}
    	?>

		<form method="post" enctype="multipart/form-data" id="sp-panel-form">	
        	<?php wp_nonce_field( 'sp-theme-options' ); ?>
            <div id="sp-main-tabs">
            	<div id="header" class="clearfix">
            		<div class="top clearfix">
                    	<h1><?php echo THEME_NAME; ?></h1>
                    	<?php echo apply_filters( 'sp-control-panel-top-logo', '<a href="http://splashingpixels.com" title="Splashing Pixels" target="_blank" class="logo"><img src="' . THEME_URL . 'images/admin/logo.png' . '" alt="Logo" width="125" height="30" /></a>' );
                    	?>                        
                	</div><!--close .top-->
                    
                    <div class="bottom clearfix">
                        <input name="save" type="submit" value="<?php esc_attr_e( 'SAVE ALL', 'sp-theme' ); ?>" class="save button button-primary button-large" disabled="disabled" />
                        <?php
                        if ( is_child_theme() ) {
	                        echo apply_filters( 'sp-control-panel-versions',
	                    	'<div class="version-meta">' . PHP_EOL
	                    		. '<small>Parent Theme Version: ' . THEME_VERSION . '</small>' . PHP_EOL
	                    		. '<small>Framework Version: ' . FRAMEWORK_VERSION . '</small>' . PHP_EOL
	                    	. '</div><!--close .version-meta-->' );
                    	} else {
	                        echo apply_filters( 'sp-control-panel-versions',
	                    	'<div class="version-meta">' . PHP_EOL
	                    		. '<small>Theme Version: ' . THEME_VERSION . '</small>' . PHP_EOL
	                    		. '<small>Framework Version: ' . FRAMEWORK_VERSION . '</small>' . PHP_EOL
	                    	. '</div><!--close .version-meta-->' );
	                    }
                    	?>
                	</div><!--close .bottom-->
                </div><!--close #header-->

                <div class="top-nav">
                    <ul class="tabs clearfix">
                        <li class="general"><a href="#general" title="<?php esc_attr_e( 'General Settings', 'sp-theme' ); ?>"><?php _e( 'GENERAL', 'sp-theme' ); ?><br /><span><?php _e( 'settings', 'sp-theme' ); ?></span></a></li>
                        <li class="customize"><a href="#customize" title="<?php esc_attr_e( 'Customize Options', 'sp-theme' ); ?>"><?php _e( 'CUSTOMIZE', 'sp-theme' ); ?><br /><span><?php _e( 'options', 'sp-theme' ); ?></span></a></li>
                        <?php 

						// check if WOO Commerce is active
						if ( sp_woo_exists() ) { 
						?>
                        	<li class="woo"><a href="#woo" title="<?php esc_attr_e( 'eCommerce Settings', 'sp-theme' ); ?>">eCOMMERCE<br /><span><?php _e( 'settings', 'sp-theme' ); ?></span></a></li>
                        <?php
                        } 
                        ?>
                        <li class="help"><a href="#help" title="<?php esc_attr_e( 'Help', 'sp-theme' ); ?>"><?php _e( 'HELP?', 'sp-theme' ); ?><br /><span><?php _e( 'faq', 'sp-theme' ); ?></span></a></li>
                    </ul>
                </div><!--close .top-nav-->

                <div id="general" class="panel sp-sub-tabs clearfix">
                	<h2 class="panel-title clear"><?php _e( 'General Settings', 'sp-theme' ); ?><a href="#" title="<?php _e( 'Toggle Open/Close All Sections', 'sp-theme' ); ?>" class="slide-toggle">[ + ]</a></h2>
                	<div class="side-nav-bg"></div>
                	<div class="side-nav">

                		<ul class="tabs">
                    		<?php 
							foreach ( $sptheme_config['tab']['general']['panel'] as $panel ) {
								echo '<li><a href="#general-' . sp_a_clean( $panel['_attr']['title'] ) . '" title="' . sp_a_clean( $panel['_attr']['title'] ) . '">' . $panel['_attr']['title'] . '</a></li>';	
							}
							?>
                    	</ul>
                	</div><!--close .side-nav-->
                    
                    <?php
					foreach ( $sptheme_config['tab']['general']['panel'] as $panel ) {
						echo '<div id="general-' . sp_a_clean( $panel['_attr']['title'] ) . '" class="option accordion">' . PHP_EOL;

						if ( is_array( $panel['wrapper'] ) ) {
							foreach ( $panel['wrapper'] as $wrapper ) {
								// check to see the context of the options if it is woo plugin
								$context = isset( $wrapper['_attr']['context'] ) ? $wrapper['_attr']['context'] : '';

								if ( $context === 'woo' && ! sp_woo_exists() ) {
									// do nothing
								} else {
									if ( isset( $wrapper['_attr']['title'] ) ) {
										echo '<h3 class="header button-primary button"><span class="caret-closed"></span>' . $wrapper['_attr']['title'] . '</h3>' . PHP_EOL;
										echo '<div class="accordion-container"><table>' . PHP_EOL;
										echo '<tr class="layout"><td class="col1"></td><td class="col2"></td><td class="col3"></td><td></td><td></td><td></td></tr>' . PHP_EOL;
									}
									
									if ( isset( $wrapper['module'] ) ) {
										if ( is_array( $wrapper['module'] ) ) {
											foreach ( $wrapper['module'] as $module ) {
												if ( isset( $module['_attr'] ) ) {
													if ( $module['_attr']['type'] != '' ) {
														echo call_user_func( 'sp_' . $module['_attr']['type'], $module );
													}
												}
											} // end 3rd foreach loop
										}
									}
									
									if ( isset( $wrapper['_attr']['title'] ) ) {
										echo '</table>' . PHP_EOL;
										echo '</div><!--close .accordion-container-->' . PHP_EOL;
									}									
								}																		
							} // end 2nd foreach loop
						}
						echo '</div><!--close option-->';
					} // end 1st foreach loop
					?>
                </div><!--close general-->
                
                <div id="customize" class="panel sp-sub-tabs clearfix">
                	<h2 class="panel-title"><?php _e( 'Customize Options', 'sp-theme' ); ?></h2>
                	<p class="customize-info"><?php _e( 'In customization mode, you can adjust different site settings and preview them LIVE without committing to the changes until you\'re ready.', 'sp-theme' ); ?></p>
                	<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" title="<?php _e( 'Enter Customization Mode', 'sp-theme' ); ?>" class="enter-customize button-primary"><?php _e( 'Enter Customization Mode', 'sp-theme' ); ?></a>
                </div><!--close customize-->
                
                <?php 

				// check to see if WOO is active
				if ( sp_woo_exists() ) { 
				?>
                <div id="woo" class="panel sp-sub-tabs clearfix">
                	<h2 class="panel-title"><?php _e( 'eCommerce Settings', 'sp-theme' ); ?><a href="#" title="<?php _e( 'Toggle Open/Close All Sections', 'sp-theme' ); ?>" class="slide-toggle">[ + ]</a></h2>
                	<div class="side-nav-bg"></div>
                	<div class="side-nav">
	                	<ul class="tabs">
	                    	<?php 
							foreach ( $sptheme_config['tab']['woo']['panel'] as $panel ) {
								echo '<li><a href="#woo-' . sp_a_clean( $panel['_attr']['title'] ) . '" title="">' . $panel['_attr']['title'] . '</a></li>';	
							}
							?>
	                    </ul><!--side-nav-->
                    </div><!--close .side-nav-->
                    <?php
					foreach ( $sptheme_config['tab']['woo']['panel'] as $panel ) {
						echo '<div id="woo-' . sp_a_clean( $panel['_attr']['title'] ) . '" class="option accordion">';
						if ( is_array( $panel['wrapper'] ) ) {
							foreach ( $panel['wrapper'] as $wrapper ) {
								if ( isset( $wrapper['_attr']['title'] ) ) {
									echo '<h3 class="header button-primary button"><span class="caret-closed"></span>' . $wrapper['_attr']['title'] . '</h3>' . PHP_EOL;
									echo '<div class="accordion-container"><table>' . PHP_EOL;
										echo '<tr class="layout"><td class="col1"></td><td class="col2"></td><td class="col3"></td><td></td><td></td><td></td></tr>' . PHP_EOL;

								}
								
								if ( isset( $wrapper['module'] ) ) {
									if ( is_array( $wrapper['module'] ) ) {
										foreach ( $wrapper['module'] as $module ) {
											if ( isset( $module['_attr'] ) ) {
												if ( $module['_attr']['type'] != '' ) {
													echo call_user_func( 'sp_' . $module['_attr']['type'], $module );
												}
											}
										} // end 3rd foreach loop
									}
								}
								
								if ( isset( $wrapper['_attr']['title'] ) ) {
									echo '</table>' . PHP_EOL;
									echo '</div><!--close .accordion-container-->' . PHP_EOL;
								}														
							} // end 2nd foreach loop
						}
						echo '</div><!--close option-->';
					} // end 1st foreach loop
					?>
                </div><!--close woo-->
				<?php 
				} // close WOO check ?>

                <div id="help" class="panel sp-sub-tabs clearfix">
                	<h2 class="panel-title"><?php _e( 'Help &amp; FAQs', 'sp-theme' ); ?><a href="#" title="<?php _e( 'Toggle Open/Close All Sections', 'sp-theme' ); ?>" class="slide-toggle">[ + ]</a></h2>
                	<div class="side-nav-bg"></div>
                	<div class="side-nav">
	                	<ul class="tabs">
	                    	<?php 
							foreach ( $sptheme_config['tab']['help']['panel'] as $panel ) {
								if ( isset( $panel['_attr'] ) ) {
									echo '<li><a href="#help-' . sp_a_clean( $panel['_attr']['title'] ) . '" title="">' . $panel['_attr']['title'] . '</a></li>';	
								}
							}
							?>
	                    </ul><!--side-nav-->
                    </div><!--close .side-nav-->
                    <?php
					foreach ( $sptheme_config['tab']['help']['panel'] as $panel ) {
						if ( isset( $panel['_attr']['title'] ) ) {
							echo '<div id="help-' . sp_a_clean( $panel['_attr']['title'] ) . '" class="option accordion">';
						}

						if ( isset( $panel['wrapper'] ) ) {
							if ( is_array( $panel['wrapper'] ) ) {							
								foreach ( $panel['wrapper'] as $wrapper ) {
									if ( isset( $wrapper['_attr']['title'] ) ) {
										echo '<h3 class="header button-primary button"><span class="caret-closed"></span>' . $wrapper['_attr']['title'] . '</h3>' . PHP_EOL;
										echo '<div class="accordion-container"><table>' . PHP_EOL;
										echo '<tr class="layout"><td class="col1"></td><td class="col2"></td><td class="col3"></td><td></td><td></td><td></td></tr>' . PHP_EOL;
										
									}
									
									if ( isset( $wrapper['module'] ) ) {
										if ( is_array( $wrapper['module'] ) ) {
											foreach ( $wrapper['module'] as $module ) {
												if ( isset( $module['_attr'] ) ) {
													if ( $module['_attr']['type'] != '' ) {
														echo call_user_func( 'sp_' . $module['_attr']['type'], $module );
													}
												}
											} // end 3rd foreach loop
										}
									}
									
									if ( isset( $wrapper['_attr']['title'] ) ) {
										echo '</table>' . PHP_EOL;
										echo '</div><!--close .accordion-container-->' . PHP_EOL;
									}							
								} // end 2nd foreach loop
							} 
						}
						if ( isset( $panel['_attr']['title'] ) ) {
							echo '</div><!--close option-->';
						}
					} // end 1st foreach loop
					?>
                </div><!--close help-->
            </div><!--close content-->

            <div id="footer-meta" class="clearfix">
            	<input name="save" type="submit" value="<?php esc_attr_e( 'SAVE ALL', 'sp-theme' ); ?>" class="save button button-primary button-large" disabled="disabled" />
                <?php
                echo apply_filters( 'sp-control-panel-bottom-logo', '<a href="http://splashingpixels.com" title="Splashing Pixels" target="_blank" class="logo"><img src="' . THEME_URL . 'images/admin/logo.png' . '" alt="Logo" width="125" height="30" /></a>' ); 
                ?>
            </div><!--close footer-meta-->
            <div class="alert"><i class="icon-ok"></i><i class="icon-ban-circle" aria-hidden="true"></i></div>
        </form>
    </div><!--close wrap-->	
<?php
}