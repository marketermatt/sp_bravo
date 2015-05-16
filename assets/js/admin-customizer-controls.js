// @codekit-prepend "select2.js"

jQuery( document ).ready( function( $ ) {
	'use strict';

	// create namespace to avoid any possible conflicts
	$.SPCustomizerControls = {	
		init: function() {
			if ( $.fn.select2 ) {					
				$( '.customize-control .select2-select, #accordion-section-nav select' ).select2( { width: 'element', minimumResultsForSearch: 20 } );
			}
			
			/////////////////////////////////////////////////////
			// logo section
			/////////////////////////////////////////////////////
			var logoUploadSection               = $( '#customize-control-logo_upload' ),
				logoTextSection					= $( '#customize-control-logo_title_text' ),
				logoFontSection					= $( '#customize-control-logo_font' ),
				logoFontVariantSection			= $( '#customize-control-logo_font_variant' ),
				logoFontSubsetSection			= $( '#customize-control-logo_font_subset' ),
				logoFontColorSection			= $( '#customize-control-logo_title_color' ),
				logoFontColorHoverSection		= $( '#customize-control-logo_title_color_hover' ),
				logoFontSizeSection				= $( '#customize-control-logo_title_size' ),
				logoFontStyleSection			= $( '#customize-control-logo_font_style' ),
				logoFontWeightSection			= $( '#customize-control-logo_font_weight' ),
				logoImageTextSection			= $( '#customize-control-logo_image_text' ),
				logoTextDecorationSection		= $( '#customize-control-logo_text_decoration' ),
				logoTextDecorationHoverSection	= $( '#customize-control-logo_text_decoration_hover' ),
				logoImageTextCurSetting;

			function checkLogoType( checkValue ) {
				if ( typeof checkValue === 'undefined' ) {
					checkValue = _wpCustomizeSettings.settings.logo_image_text.value;
				}

				// check on page load
				if ( checkValue === 'text' ) {
					logoTextSection.show();
					logoFontSection.show();
					logoFontVariantSection.show();
					logoFontSubsetSection.show();
					logoFontColorSection.show();
					logoFontColorHoverSection.show();
					logoFontSizeSection.show();
					logoFontStyleSection.show();
					logoFontWeightSection.show();
					logoTextDecorationSection.show();
					logoTextDecorationHoverSection.show();
					logoUploadSection.hide();

					// remove the image
					$( 'a.remove', logoUploadSection ).trigger( 'click' );
				} else {
					logoTextSection.hide();
					logoFontSection.hide();
					logoFontVariantSection.hide();
					logoFontSubsetSection.hide();
					logoFontColorSection.hide();
					logoFontColorHoverSection.hide();
					logoFontSizeSection.hide();
					logoFontStyleSection.hide();
					logoFontWeightSection.hide();
					logoTextDecorationSection.hide();
					logoTextDecorationHoverSection.hide();					
					logoUploadSection.show();
				}
			}

			// run once on load
			checkLogoType();

			logoImageTextSection.find( 'input[name=_customize-radio-logo_image_text]' ).change( function() {
				logoImageTextCurSetting = $( this ).val();
				
				// check type
				checkLogoType( logoImageTextCurSetting );
			} );

			/////////////////////////////////////////////////////
			// text size slider
			///////////////////////////////////////////////////// 
			$( '.size-slider' ).each( function() {
				var input = $( 'input', this ),
					inputValue = input.val(),
					container = $( this );

				inputValue = inputValue.length > 0 ? parseInt( inputValue, 10 ) : 0;

				$( '.slider', container ).slider( {
					min: 1,
					max: 50,
					step: 1,
					value: inputValue,
					slide: function( event, ui ) {
						input.val( ui.value + 'px' );
						$( 'span.value', container ).html( ui.value + 'px' );
						input.keyup();
					},
					create: function() {
						$( 'span.value', container ).html( inputValue + 'px' );
					}
				} );

				// reset settings if default-size is clicked
				$( 'a.default-size', container ).click( function( e ) {
					// prevent default behavior
					e.preventDefault();

					var defaultValue = $( this ).data( 'default' );

					// set default if no standard is set
					if ( ! defaultValue.length ) {
						defaultValue = 15;
					}

					$( '.slider', container ).slider( 'value', parseInt( defaultValue, 10 ) );
					$( 'span.value', container ).html( defaultValue );
					input.val( defaultValue ).keyup();
				} );
			} );	

			/////////////////////////////////////////////////////
			// backgrounds
			/////////////////////////////////////////////////////
			$( '#customize-control-background_site_upload, #customize-control-background_topbar_upload, #customize-control-background_header_upload, #customize-control-background_nav_upload, #customize-control-background_page_header_upload, #customize-control-background_main_content_upload, #customize-control-background_footer_content_upload, #customize-control-background_footer_bar_upload, #customize-control-background_quickview_upload' ).each( function() {
				var thisContainer = $( this ),
					predefinedContainer = thisContainer.prev();

				if ( $( 'select.predefined-bg', predefinedContainer ).val() !== 'none' && $( 'select.predefined-bg', predefinedContainer ).val() !== 'custom' ) { 
					thisContainer.hide();
					$( 'select.predefined-bg', predefinedContainer ).keyup();
				} else if ( thisContainer.find( 'img' ).css( 'display' ) !== 'none' ) { 
					thisContainer.show();
				}

				$( predefinedContainer ).on( 'change', 'select.predefined-bg', function() {
					var selected = $( this ).val();

					if ( selected === 'none' ) {
						thisContainer.hide();
						$( 'a.remove', thisContainer ).trigger( 'click' );
					} else if ( selected === 'custom' ) {
						thisContainer.show();
					} else {
						thisContainer.hide();
						$( 'a.remove', thisContainer ).trigger( 'click' );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// font select change event
			/////////////////////////////////////////////////////
			$( '#customize-theme-controls .font-select' ).each( function() { 
				var fontSelect = $( this );

				fontSelect.on( 'change', function() {
					var font				= fontSelect.val(),
						fontVariantSelect	= $( fontSelect ).parents( 'li' ).next( 'li' ).find( 'select.font-variant-select' ),
						fontSubsetSelect	= $( fontVariantSelect ).parents( 'li' ).next( 'li' ).find( 'select.font-subset-select' ),
						$data = {
							action: 'sp_font_select_ajax',
							font: font,
							ajaxCustomNonce : sp_customize.ajaxCustomNonce
						};

					$.post( sp_customize.ajaxurl, $data, function( response ) {

						if ( response.length > 0 ) {
							var fontAttr = $.parseJSON( response );

							// destroy select2 first
							fontVariantSelect.select2( 'destroy' );
							fontSubsetSelect.select2( 'destroy' );

							// replace options
							fontVariantSelect.html( fontAttr.variants );

							// replace options
							fontSubsetSelect.html( fontAttr.subsets );

							// reinit select2
							fontVariantSelect.select2( { width: 'element', minimumResultsForSearch: 20 } );
							fontSubsetSelect.select2( { width: 'element', minimumResultsForSearch: 20 } );
						}
					} );
				} );
			} );

			// handle the font subsets
			$( '#customize-theme-controls .font-subset-select' ).each( function() {
				var subsetSelect = $( this );
				
				subsetSelect.on( 'change', function() {	
					if ( $( subsetSelect ).val() === null ) {
						// select the default of none when all subsets removed
						$( 'option:first-child', subsetSelect ).attr( 'selected', true );
					}
				} );
			} );

			// reset default button
			$( '.control-section' ).each( function() {
				var container = $( this ),
					button = $( '.customizer-reset-default', this );

				button.click( function() {
					container.find( '.customize-control' ).each( function() {
						var defaultSetting = $( 'input.default-setting', this ).data( 'default-setting' );

						if ( $( this ).is( '.customize-control-radio' ) ) {
							$( this ).find( 'input[value=' + defaultSetting + ']' ).trigger( 'click' );
						}

						if ( $( this ).is( '.customize-control-text' ) ) {
							if ( typeof( defaultSetting ) !== 'undefined' && defaultSetting !== null && defaultSetting.length ) {
								$( this ).find( 'input[type=text]' ).val( defaultSetting ).trigger( 'click' ).trigger( 'change' );
							} else {
								$( this ).find( 'input[type=text]' ).val( '' ).trigger( 'click' );
							}
						}	

						if ( $( this ).is( '.customize-control-text-size' ) ) {
							$( this ).find( '.default-size' ).trigger( 'click' );
						}	

						if ( $( this ).is( '.customize-control-color' ) ) {
							$( this ).find( 'input.wp-picker-clear, input.wp-picker-default' ).trigger( 'click' );
						}	

						if ( $( this ).is( '.customize-control-select' ) ) {
							// check if the select is for predefined background
							if ( $( this ).find( 'select.select2-select.predefined-bg' ).length ) {
								$( this ).find( 'select.select2-select.predefined-bg' ).select2( 'val', 'none' ).trigger( 'change' );							
							} else {
								// check if there is a default
								if ( typeof( defaultSetting ) !== 'undefined' && defaultSetting !== null && defaultSetting.length ) {
									$( this ).find( 'select.select2-select' ).not( '.font-subset-select' ).select2( 'val', defaultSetting ).trigger( 'change' );
									$( this ).find( 'select.select2-select.font-subset-select' ).select2( 'val', '' ).trigger( 'change' );
								} else {
									$( this ).find( 'select.select2-select' ).not( '.font-subset-select' ).select2( 'val', 'none' ).trigger( 'change' );
									$( this ).find( 'select.select2-select.font-subset-select' ).select2( 'val', '' ).trigger( 'change' );
								}
							}
						}		

						if ( $( this ).is( '.customize-control-image' ) ) {
							$( this ).find( 'a.remove' ).trigger( 'click' );
						}																	
					} );
				} );
			} );

			var mediaFrame;

			$( '.library' ).on( 'click', '.customizer-media-library', function( e ) {

				// prevent default behavior
				e.preventDefault();

				var ID = $( this ).parents( '.customize-control' ).prop( 'id' );

				// trim
				ID = ID.replace( 'customize-control-', '' );

				// Create the media frame.
				mediaFrame = wp.media.frames.mediaFrame = wp.media({

					title: $( this ).data( 'uploader_title' ),

					button: {
						text: $( this ).data( 'uploader_button_text' )
					},

					// Tell the modal to show only images.
					library: {
						type: 'image'
					},

					multiple: false
				} );

				// after a file has been selected
				mediaFrame.on( 'select', function() {
					var attachment = mediaFrame.state().get( 'selection' ).first(),
						controller = wp.customize.control.instance( ID );

					// set the image to the controller
					controller.thumbnailSrc( attachment.attributes.url );
					controller.setting.set( attachment.attributes.url );
				} );

				// open the modal frame
				mediaFrame.open();
			} );						
		}  // close init
	}; // close namespace
	
	$.SPCustomizerControls.init();
// end document ready
} );