( function() {
	'use strict';
	
	var $ = jQuery,
		shortcodesModule = $.parseJSON( sp_theme.shortcodes_module );

	function getShortcode( id ) {
		// close any opened dialog first
		$( '.shortcodes-module-container' ).each( function() { 
			$( this ).dialog( 'close' );
		} );

		var	shortcode_id = id,
			data = {
				action: 'sp_shortcode_input_form_ajax',
				ajaxCustomNonce: sp_theme.ajaxCustomNonce,
				module: shortcode_id
			},
			content,
			originalValues = [],
			originalRadioValues = [];

		$.post( sp_theme.ajaxurl, data, function( response ) {
			response = $.parseJSON( response );

			content = $( '<div class="shortcodes-module-container" data-id="' + shortcode_id + '">' + response.form + '<button class="button button-primary add-shortcode">' + sp_theme.shortcodes_add_shortcode_button_text + '</button><button class="toggle-options button">' + sp_theme.shortcodes_more_options_button_text + '</button></div>' );
			
			// check if we need to display option toggle button
			if ( $( content ).find( 'div.optional' ).length ) {
				$( content ).find( '.toggle-options' ).show();
			} else {
				$( content ).find( '.toggle-options' ).hide();
			}

			// append the content to body
			$( 'body' ).append( content );

			// hide the content first
			content.hide();

			// fire the dialog box
			$( '.shortcodes-module-container' ).dialog( {
				title: shortcode_id,
				width: 600,
				height: 600,
				dialogClass: 'shortcode-modules-dialog',
				close: function() {
					content.remove();	

					// show the popup
					$( '.mfp-wrap.page-builder-modal' ).show();
				},
				open: function() {
					// sets the scrollbar back up at the top
					$( '.shortcodes-module-container' ).scrollTop( 0 );

					// hide the popup
					$( '.mfp-wrap.page-builder-modal' ).hide();
				}
			} ).dialog( 'open' );

			// get original values
			$( 'input[type=text], textarea, select', content ).not( 'textarea[data-set-name="inner_wrap_content"], input[data-set-name="inner_wrap_content"]' ).each( function() {
				originalValues.push( $( this ).val() );
			} );

			// get original values for type radio
			$( 'input[type=radio]:checked', content ).each( function() {
				originalRadioValues.push( $( this ).val() );
			} );

			$( '.shortcodes-module-container' ).on( 'click', '.add-shortcode', function( e ) {
				// prevent default behavior
				e.preventDefault();
				
				var container = $( this ).parents( '.shortcodes-module-container' ),
					shortcode;

				shortcode = '[' + shortcodesModule[shortcode_id].shortcode_name;

				// loop through input fields
				$( 'input[type=text], textarea, select', container ).not( 'textarea[data-set-name="inner_wrap_content"], input[data-set-name="inner_wrap_content"]' ).each( function( index ) {
					var required = $( this ).parents( '.form-group' ).eq( 0 ).hasClass( 'required' );

					// check if any changes to the value
					if ( $( this ).val() !== originalValues[index] || required ) {
						shortcode += ' ' + $( this ).data( 'set-name' ) + '="' + $( this ).val() + '"';
					}
				} );

				// loop through input radio fields
				$( 'input[type=radio]:checked', container ).each( function( index ) {
					var required = $( this ).parents( '.form-group' ).eq( 0 ).hasClass( 'required' );

					// check if optional is displayed
					if ( $( this ).val() !== originalRadioValues[index] || required ) {							
						shortcode += ' ' + $( this ).data( 'set-name' ) + '="' + $( this ).val() + '"';
					}
				} );

				shortcode += ']';

				// check if there needs to be a wrapping container
				if ( shortcode_id === 'tabs' ) {
					shortcode += sp_theme.shortcodes_tinymce_shortcode_tab_content_msg + '[/' + shortcodesModule[shortcode_id].shortcode_name + ']';
				}

				// check if there needs to be a wrapping container
				if ( shortcode_id === 'tab_content' ) {
					shortcode += sp_theme.shortcodes_tinymce_shortcode_content_msg + '[/' + shortcodesModule[shortcode_id].shortcode_name + ']';
				}

				// check if there needs to be a wrapping container
				if ( shortcode_id === 'accordion' ) {
					shortcode += '[sp-accordion-content]' + sp_theme.shortcodes_tinymce_shortcode_content_msg + '[/sp-accordion-content][/' + shortcodesModule[shortcode_id].shortcode_name + ']';
				}

				// check if there needs to be a wrapping container
				if ( shortcode_id === 'code' ) {
					shortcode += sp_theme.shortcodes_tinymce_shortcode_content_msg + '[/sp-code]';
				}

				// check if there needs to be a wrapping container
				if ( shortcode_id === 'check_login' ) {
					shortcode += sp_theme.shortcodes_tinymce_shortcode_content_msg + '[/sp-check-login]';
				}

				// check if there needs to be a wrapping container
				if ( shortcode_id === 'grid' ) {
					shortcode += sp_theme.shortcodes_tinymce_shortcode_content_msg + '[/sp-grid]';
				}

				// textarea
				if ( $( 'textarea[data-set-name="inner_wrap_content"]', container ).length && $( 'textarea[data-set-name="inner_wrap_content"]', container ).val().length > 0 ) {
					shortcode += $( 'textarea[data-set-name="inner_wrap_content"]', container ).val() + '[/' + shortcodesModule[shortcode_id].shortcode_name + ']';
				}

				// text
				if ( $( 'input[data-set-name="inner_wrap_content"]', container ).length && $( 'input[data-set-name="inner_wrap_content"]', container ).val().length > 0 ) {
					shortcode += $( 'input[data-set-name="inner_wrap_content"]', container ).val() + '[/' + shortcodesModule[shortcode_id].shortcode_name + ']';
				}

				window.tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, shortcode );

				// close the dialog
				$( '.shortcodes-module-container' ).dialog( 'close' );						
			} );

			$( '.shortcodes-module-container' ).on( 'click', '.toggle-options', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var button = $( this ),
					container = $( this ).parents( '.shortcodes-module-container' );

				container.find( 'div.optional' ).slideToggle( 300 );
				
				button.text( function( i, text ) {
					return text === sp_theme.shortcodes_more_options_button_text ? sp_theme.shortcodes_less_options_button_text : sp_theme.shortcodes_more_options_button_text;
				} );						
			} );
		} );			
	}

	// test version for backwards compat
	if ( tinymce.majorVersion === '4' ) {

		tinymce.PluginManager.add( 'sp_shortcodes', function( editor, url ) {
			editor.addButton( 'sp_shortcodes', {
				icon: 'sp-shortcode-button',
				type: 'menubutton',
				classes: 'sp-shortcode-menu-button, btn',
				menu: [
					{
						text: sp_theme.shortcodes_tinymce_section_social_media,
						menu: [
							{
								text: shortcodesModule.social_media_fb.title,
								onclick: function() {
									getShortcode( 'social_media_fb' );
								}
							},

							{
								text: shortcodesModule.social_media_gplusone.title,
								onclick: function() {
									getShortcode( 'social_media_gplusone' );
								}
							},

							{
								text: shortcodesModule.social_media_tweet.title,
								onclick: function() {
									getShortcode( 'social_media_tweet' );
								}
							},

							{
								text: shortcodesModule.social_media_twitter_follow.title,
								onclick: function() {
									getShortcode( 'social_media_twiiter_follow' );
								}
							},

							{
								text: shortcodesModule.social_media_pinit.title,
								onclick: function() {
									getShortcode( 'social_media_pinit' );
								}
							}
						]
					},

					{
						text: sp_theme.shortcodes_tinymce_section_products,
						menu: [
							{
								text: shortcodesModule.product_slider.title,
								onclick: function() {
									getShortcode( 'product_slider' );
								}
							}
						]
					},

					{
						text: shortcodesModule.tabs.title,
						onclick: function() {
							getShortcode( 'tabs' );
						}
					},

					{
						text: shortcodesModule.tab_content.title,
						onclick: function() {
							getShortcode( 'tab_content' );
						}
					},

					{
						text: sp_theme.shortcodes_tinymce_section_sliders,
						menu: [
							{
								text: shortcodesModule.carousel_slider.title,
								onclick: function() {
									getShortcode( 'carousel_slider' );
								}
							},

							{
								text: shortcodesModule.layer_slider.title,
								onclick: function() {
									getShortcode( 'layer_slider' );
								}
							}
						]
					},

					{
						text: sp_theme.shortcodes_tinymce_section_boxes,
						menu: [
							{
								text: shortcodesModule.callout.title,
								onclick: function() {
									getShortcode( 'callout' );
								}
							},

							{
								text: shortcodesModule.imagelinkbox.title,
								onclick: function() {
									getShortcode( 'imagelinkbox' );
								}
							},

							{
								text: shortcodesModule.lightbox.title,
								onclick: function() {
									getShortcode( 'lightbox' );
								}
							}
						]
					},

					{
						text: shortcodesModule.accordion.title,
						onclick: function() {
							getShortcode( 'accordion' );
						}
					},

					{
						text: shortcodesModule.accordion_content.title,
						onclick: function() {
							getShortcode( 'accordion_content' );
						}
					},

					{
						text: sp_theme.shortcodes_tinymce_section_formatting,
						menu: [
							{
								text: shortcodesModule.grid.title,
								onclick: function() {
									getShortcode( 'grid' );
								}
							},

							{
								text: shortcodesModule.hr.title,
								onclick: function() {
									getShortcode( 'hr' );
								}
							},

							{
								text: shortcodesModule.dropcap.title,
								onclick: function() {
									getShortcode( 'dropcap' );
								}
							},

							{
								text: shortcodesModule.blockquote.title,
								onclick: function() {
									getShortcode( 'blockquote' );
								}
							},

							{
								text: shortcodesModule.code.title,
								onclick: function() {
									getShortcode( 'code' );
								}
							}
						]
					},

					{
						text: shortcodesModule.btt.title,
						onclick: function() {
							getShortcode( 'btt' );
						}
					},

					{
						text: shortcodesModule.image_link.title,
						onclick: function() {
							getShortcode( 'image_link' );
						}
					},

					{
						text: shortcodesModule.tooltip.title,
						onclick: function() {
							getShortcode( 'tooltip' );
						}
					},

					{
						text: shortcodesModule.map.title,
						onclick: function() {
							getShortcode( 'map' );
						}
					},

					{
						text: shortcodesModule.check_login.title,
						onclick: function() {
							getShortcode( 'check_login' );
						}
					},

					{
						text: sp_theme.shortcodes_tinymce_section_forms,
						menu: [
							{
								text: shortcodesModule.login.title,
								onclick: function() {
									getShortcode( 'login' );
								}
							},

							{
								text: shortcodesModule.register.title,
								onclick: function() {
									getShortcode( 'register' );
								}
							},

							{
								text: shortcodesModule.change_password.title,
								onclick: function() {
									getShortcode( 'change_password' );
								}
							},

							{
								text: shortcodesModule.contactform.title,
								onclick: function() {
									getShortcode( 'contactform' );
								}
							}
						]
					},

					{
						text: shortcodesModule.button.title,
						onclick: function() {
							getShortcode( 'button' );
						}
					},

					{
						text: shortcodesModule.portfolio.title,
						onclick: function() {
							getShortcode( 'portfolio' );
						}
					},

					{
						text: shortcodesModule.bio_card.title,
						onclick: function() {
							getShortcode( 'bio_card' );
						}
					},

					{
						text: shortcodesModule.testimonial.title,
						onclick: function() {
							getShortcode( 'testimonial' );
						}
					},

					{
						text: shortcodesModule.faq.title,
						onclick: function() {
							getShortcode( 'faq' );
						}
					},

					{
						text: sp_theme.shortcodes_tinymce_section_paths,
						menu: [
							{
								text: shortcodesModule.homeurl.title,
								onclick: function() {
									getShortcode( 'homeurl' );
								}
							},

							{
								text: shortcodesModule.themeurl.title,
								onclick: function() {
									getShortcode( 'themeurl' );
								}
							},

							{
								text: shortcodesModule.themepath.title,
								onclick: function() {
									getShortcode( 'themepath' );
								}
							}
						]
					}
				]
			});
		});
	} else {

		tinymce.create( 'tinymce.plugins.sp_shortcodes', {
			init: function( n ) {
	            n.addCommand( 'spOpenDialog', function( a, c ) {    
					getShortcode( c.id );								
	            } );
			},

			createControl: function( n, cm ) {
				// check if control is sp_shortcodes
				if ( n === 'sp_shortcodes' ) {
					var a = this;

					n = cm.createMenuButton( 'sp_shortcodes_button', {
						title: sp_theme.shortcodes_tinymce_title,
						image: sp_theme.shortcodes_tinymce_icon,
						icons: false
					} );

					n.onRenderMenu.add( function( c, m ) {

						// social media
						c = m.addMenu( { title: sp_theme.shortcodes_tinymce_section_social_media } );
						a.addImmediate( c, shortcodesModule.social_media_fb.title, shortcodesModule.social_media_fb.shortcode, 'social_media_fb' );
						a.addImmediate( c, shortcodesModule.social_media_gplusone.title, shortcodesModule.social_media_gplusone.shortcode, 'social_media_gplusone' );
						a.addImmediate( c, shortcodesModule.social_media_tweet.title, shortcodesModule.social_media_tweet.shortcode, 'social_media_tweet' );
						a.addImmediate( c, shortcodesModule.social_media_twitter_follow.title, shortcodesModule.social_media_twitter_follow.shortcode, 'social_media_twitter_follow' );
						a.addImmediate( c, shortcodesModule.social_media_pinit.title, shortcodesModule.social_media_pinit.shortcode, 'social_media_pinit' );

						// products
						c = m.addMenu( { title: sp_theme.shortcodes_tinymce_section_products } );
						a.addImmediate( c, shortcodesModule.product_slider.title, shortcodesModule.product_slider.shortcode, 'product_slider' );

						// tabs
						a.addImmediate( m, shortcodesModule.tabs.title, shortcodesModule.tabs.shortcode, 'tabs' );
						a.addImmediate( m, shortcodesModule.tab_content.title, shortcodesModule.tab_content.shortcode, 'tab_content' );

						// sliders
						c = m.addMenu( { title: sp_theme.shortcodes_tinymce_section_sliders } );
						a.addImmediate( c, shortcodesModule.carousel_slider.title, shortcodesModule.carousel_slider.shortcode, 'carousel_slider' );
						a.addImmediate( c, shortcodesModule.layer_slider.title, shortcodesModule.layer_slider.shortcode, 'layer_slider' );

						// boxes
						c = m.addMenu( { title: sp_theme.shortcodes_tinymce_section_boxes } );
						a.addImmediate( c, shortcodesModule.callout.title, shortcodesModule.callout.shortcode, 'callout' );
						a.addImmediate( c, shortcodesModule.imagelinkbox.title, shortcodesModule.imagelinkbox.shortcode, 'imagelinkbox' );
						a.addImmediate( c, shortcodesModule.lightbox.title, shortcodesModule.lightbox.shortcode, 'lightbox' );

						// accordion
						a.addImmediate( m, shortcodesModule.accordion.title, shortcodesModule.accordion.shortcode, 'accordion' );
						a.addImmediate( m, shortcodesModule.accordion_content.title, shortcodesModule.accordion_content.shortcode, 'accordion_content' );

						// formatting
						c = m.addMenu( { title: sp_theme.shortcodes_tinymce_section_formatting } );
						a.addImmediate( c, shortcodesModule.grid.title, shortcodesModule.grid.shortcode, 'grid' );
						a.addImmediate( c, shortcodesModule.hr.title, shortcodesModule.hr.shortcode, 'hr' );
						a.addImmediate( c, shortcodesModule.dropcap.title, shortcodesModule.dropcap.shortcode, 'dropcap' );
						a.addImmediate( c, shortcodesModule.blockquote.title, shortcodesModule.blockquote.shortcode, 'blockquote' );
						a.addImmediate( c, shortcodesModule.code.title, shortcodesModule.code.shortcode, 'code' );

						// back to top
						a.addImmediate( m, shortcodesModule.btt.title, shortcodesModule.btt.shortcode, 'btt' );

						// image link
						a.addImmediate( m, shortcodesModule.image_link.title, shortcodesModule.image_link.shortcode, 'image_link' );

						// tooltip link
						a.addImmediate( m, shortcodesModule.tooltip.title, shortcodesModule.tooltip.shortcode, 'tooltip' );

						// google map
						a.addImmediate( m, shortcodesModule.map.title, shortcodesModule.map.shortcode, 'map' );

						// check login
						a.addImmediate( m, shortcodesModule.check_login.title, shortcodesModule.check_login.shortcode, 'check_login' );

						// forms
						c = m.addMenu( { title: sp_theme.shortcodes_tinymce_section_forms } );
						a.addImmediate( c, shortcodesModule.login.title, shortcodesModule.login.shortcode, 'login' );
						a.addImmediate( c, shortcodesModule.register.title, shortcodesModule.register.shortcode, 'register' );
						a.addImmediate( c, shortcodesModule.change_password.title, shortcodesModule.change_password.shortcode, 'change_password' );
						a.addImmediate( c, shortcodesModule.contactform.title, shortcodesModule.contactform.shortcode, 'contactform' );

						// buttons
						a.addImmediate( m, shortcodesModule.button.title, shortcodesModule.button.shortcode, 'button' );

						// portfolio
						a.addImmediate( m, shortcodesModule.portfolio.title, shortcodesModule.portfolio.shortcode, 'portfolio' );

						// bio card
						a.addImmediate( m, shortcodesModule.bio_card.title, shortcodesModule.bio_card.shortcode, 'bio_card' );

						// testimonial
						a.addImmediate( m, shortcodesModule.testimonial.title, shortcodesModule.testimonial.shortcode, 'testimonial' );

						// faq
						a.addImmediate( m, shortcodesModule.faq.title, shortcodesModule.faq.shortcode, 'faq' );

						// paths and urls
						c = m.addMenu( { title: sp_theme.shortcodes_tinymce_section_paths } );
						a.addImmediate( c, shortcodesModule.homeurl.title, shortcodesModule.homeurl.shortcode, 'homeurl' );
						a.addImmediate( c, shortcodesModule.themeurl.title, shortcodesModule.themeurl.shortcode, 'themeurl' );
						a.addImmediate( c, shortcodesModule.themepath.title, shortcodesModule.themepath.shortcode, 'themepath' );
					} );

					return n;
				}
			},

			addImmediate: function ( m, cm, a, id ) { 
				m.add( { 
					title: cm, 
					onclick: function() { 

						// fires the dialog
	                    tinyMCE.activeEditor.execCommand( 'spOpenDialog', false, {
	                        title: cm,
	                        identifier: a,
	                        id: id
	                    } );				
					} 
				} );
			},

	        getInfo: function () {
	            return {
	                longname: 'Splashing Pixels Shortcodes',
	                author: 'Splashing Pixels (Roy Ho)',
	                authorurl: 'http://splashingpixels.com',
	                infourl: 'http://splashingpixels.com',
	                version: '1.0'
	            };
	        }		
		} );

		tinymce.PluginManager.add( 'sp_shortcodes', tinymce.plugins.sp_shortcodes );
	}
} )();