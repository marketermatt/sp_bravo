jQuery( document ).ready( function( $ ) {
	//'use strict'; // this is commented out because google font is using undeclared webfontconfig global

	// create namespace to avoid any possible conflicts
	$.SPCustomizer = {	
		load_google_font_script: function( font ) { 
			// only load when necessary
			if ( font.length ) {
				WebFontConfig = {
					google: {
						families: [font]
					}
				};

				var wf = document.createElement( 'script' );

				wf.src = ( 'https:' === document.location.protocol ? 'https' : 'http' ) + '://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js';

				wf.type = 'text/javascript';

				wf.async = 'true';

				var s = document.getElementsByTagName( 'script' )[0];

				s.parentNode.insertBefore( wf, s );
			}
		},

		init: function() {

			/////////////////////////////////////////////////////
			// logo section
			/////////////////////////////////////////////////////			
			var logoImageText,
				logoTag,
				logoUrlSaved = sp_customize.saved.logo_upload,
				logoText = sp_customize.logo_text;

			// logo show
			wp.customize( 'logo_show', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'on' ) {
						$( sp_customize.customize_init.logo_show.selector ).show();
					} else {
						$( sp_customize.customize_init.logo_show.selector ).hide();
					}
				} );
			} );

			// logo url
			wp.customize( 'logo_upload', function( value ) {
				value.bind( function( newval ) {
					logoTag = $( '<img src="' + newval + '" alt="' + sp_customize.site_title + '" />' );	

					// if img tag is already present
					if ( $( sp_customize.customize_init.logo_show.selector ).find( 'img' ).length ) {
						$( sp_customize.customize_init.logo_show.selector ).find( 'img' ).attr( 'src', newval );
					} else {
						$( sp_customize.customize_init.logo_show.selector ).html( logoTag );
					}

					$( sp_customize.customize_init.logo_show.selector ).find( 'img' ).show();
				} );
			} );

			// logo type
			wp.customize( 'logo_image_text', function( value ) {
				value.bind( function( newval ) {
					logoImageText = newval;

					if ( typeof logoUrlSaved !== 'undefined' && logoUrlSaved.length ) {
						logoTag = $( '<img src="' + logoUrlSaved + '" alt="' + sp_customize.site_title + '" />' );	
					} else {
						logoTag = $( '<img src="' + sp_theme.theme_url + '/images/logo.png" alt="' + sp_customize.site_title + '" />' );
					}

					if ( newval === 'image' ) {
						$( '#customize-control-logo_upload' ).show();

						// check if img tag is already there
						if ( $( sp_customize.customize_init.logo_show.selector ).find( 'img' ).length ) {
							$( sp_customize.customize_init.logo_show.selector ).find( 'img' ).show();
						} else {
							$( sp_customize.customize_init.logo_show.selector ).html( logoTag );
						}
					} else if ( newval === 'text' ) {
						$( sp_customize.customize_init.logo_show.selector ).find( 'img' ).hide();
						$( sp_customize.customize_init.logo_show.selector ).html( logoText );
						$( '#customize-control-logo_upload' ).hide();
					}
				} );
			} );

			// logo title text
			wp.customize( 'logo_title_text', function( value ) {
				value.bind( function( newval ) {
					// put new text value into html						
					$( sp_customize.customize_init.logo_show.selector ).html( newval );
				} );
			} );

			// logo font
			var logo_font;

			wp.customize( 'logo_font', function( value ) {
				value.bind( function( newval ) {

					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.logo_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.logo_font.selector ).css( sp_customize.customize_init.logo_font.property, newval + ', Arial, sans-serif' );

					logo_font = newval;				
				} );
			} );	

			// logo font variant
			var logo_font_variant;

			wp.customize( 'logo_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( logo_font ) !== 'undefined' && logo_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( logo_font + ':' + newval );	
						}
						
						logo_font_variant = newval;

						// change font weight				
						$( sp_customize.customize_init.logo_font_variant.selector ).css( sp_customize.customize_init.logo_font_variant.property, newval );
					}
				} );
			} );

			// logo font subset
			var logo_font_subset;

			wp.customize( 'logo_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( logo_font ) !== 'undefined' && logo_font !== 'none' ) {

							if ( typeof( logo_font_variant ) !== 'undefined' && logo_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( logo_font + ':' + logo_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( logo_font + '::' + newval.toString() );
							}

							logo_font_subset = newval;
						}
					}
				} );
			} );

			// logo title color
			wp.customize( 'logo_title_color', function( value ) {
				value.bind( function( newval ) {
					// change css color
					$( sp_customize.customize_init.logo_title_color.selector ).css( sp_customize.customize_init.logo_title_color.property, newval );
				} );
			} );	

			// logo title color on hover
			wp.customize( 'logo_title_color_hover', function( value ) {
				value.bind( function( newval ) {
					// get the current live selected color
					var color = $( sp_customize.customize_init.logo_title_color.selector ).css( sp_customize.customize_init.logo_title_color.property );

					$( '#logo' ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );	

			// logo title size
			wp.customize( 'logo_title_size', function( value ) {
				value.bind( function( newval ) {
					// change css title size
					$( sp_customize.customize_init.logo_title_size.selector ).css( sp_customize.customize_init.logo_title_size.property, newval );
				} );
			} );	

			// logo font style
			wp.customize( 'logo_font_style', function( value ) {
				value.bind( function( newval ) {
					// change css font style
					$( sp_customize.customize_init.logo_font_style.selector ).css( sp_customize.customize_init.logo_font_style.property, newval );
				} );
			} );

			// logo font weight
			wp.customize( 'logo_font_weight', function( value ) {
				value.bind( function( newval ) {
					// change css font weight
					$( sp_customize.customize_init.logo_font_weight.selector ).css( sp_customize.customize_init.logo_font_weight.property, newval );
				} );
			} );

			// logo text decoration
			wp.customize( 'logo_text_decoration', function( value ) {
				value.bind( function( newval ) {
					// change css text decoration
					$( sp_customize.customize_init.logo_text_decoration.selector ).css( sp_customize.customize_init.logo_text_decoration.property, newval );
				} );
			} );

			// logo text decoration on hover
			wp.customize( 'logo_text_decoration_hover', function( value ) {
				value.bind( function( newval ) {
					var textDecoration = $( sp_customize.customize_init.logo_text_decoration.selector ).css( 'text-decoration' );

					$( sp_customize.customize_init.logo_text_decoration.selector ).hover( function() {
						$( this ).css( 'text-decoration', newval );
					}, function() {
						$( this ).css( 'text-decoration', textDecoration );
					} );
				} );
			} );	

			/////////////////////////////////////////////////////
			// tagline section
			/////////////////////////////////////////////////////

			// tagline show
			wp.customize( 'tagline_show', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'on' ) {
						$( sp_customize.customize_init.tagline_show.selector ).show();
					} else {
						$( sp_customize.customize_init.tagline_show.selector ).hide();
					}
				} );
			} );

			// tagline title text
			wp.customize( 'tagline_title_text', function( value ) {
				value.bind( function( newval ) {
					// put new text value into html						
					$( sp_customize.customize_init.tagline_title_text.selector ).html( newval );
				} );
			} );

			// tagline font
			var tagline_font;

			wp.customize( 'tagline_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.tagline_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.tagline_font.selector ).css( sp_customize.customize_init.tagline_font.property, newval + ', Arial, sans-serif' );

					// save font to variable
					tagline_font = newval;
				} );
			} );	
			
			// tagline font variant
			var tagline_font_variant;

			wp.customize( 'tagline_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( tagline_font ) !== 'undefined' && tagline_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( tagline_font + ':' + newval );
						}

						tagline_font_variant = newval;

						// change font weight				
						$( sp_customize.customize_init.tagline_font_variant.selector ).css( sp_customize.customize_init.tagline_font_variant.property, newval );
					}
				} );
			} );

			// tagline font subset
			var tagline_font_subset;

			wp.customize( 'tagline_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( tagline_font ) !== 'undefined' && tagline_font !== 'none' ) {

							if ( typeof( tagline_font_variant ) !== 'undefined' && tagline_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( tagline_font + ':' + tagline_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( tagline_font + '::' + newval.toString() );
							}

							tagline_font_subset = newval;
						}
					}
				} );
			} );

			// tagline title color
			wp.customize( 'tagline_title_color', function( value ) {
				value.bind( function( newval ) { 
					// change css color
					$( sp_customize.customize_init.tagline_title_color.selector ).css( sp_customize.customize_init.tagline_title_color.property, newval );
				} );
			} );

			// tagline title size
			wp.customize( 'tagline_title_size', function( value ) {
				value.bind( function( newval ) {
					// change css title size
					$( sp_customize.customize_init.tagline_title_size.selector ).css( sp_customize.customize_init.tagline_title_size.property, newval );
				} );
			} );	

			// tagline font style
			wp.customize( 'tagline_font_style', function( value ) {
				value.bind( function( newval ) {
					// change css font style
					$( sp_customize.customize_init.tagline_font_style.selector ).css( sp_customize.customize_init.tagline_font_style.property, newval );
				} );
			} );

			// tagline font weight
			wp.customize( 'tagline_font_weight', function( value ) {
				value.bind( function( newval ) {
					// change css font weight
					$( sp_customize.customize_init.tagline_font_weight.selector ).css( sp_customize.customize_init.tagline_font_weight.property, newval );
				} );
			} );		

			/////////////////////////////////////////////////////
			// favicon section
			/////////////////////////////////////////////////////
			// logo url
			wp.customize( 'favicon_upload', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.favicon_upload.selector ).attr( sp_customize.customize_init.favicon_upload.property, newval );
				} );
			} );		

			/////////////////////////////////////////////////////
			// body text color section
			/////////////////////////////////////////////////////
			wp.customize( 'body_text_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.body_text_color.selector ).css( sp_customize.customize_init.body_text_color.property, newval );
				} );
			} );		

			/////////////////////////////////////////////////////
			// site background section
			/////////////////////////////////////////////////////	
			var backgroundSiteUploadSaved;

			wp.customize( 'background_site_upload', function( value ) {
				backgroundSiteUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_site_upload.selector ).css( sp_customize.customize_init.background_site_upload.property, 'url(' + newval + ')' );	
				} );
			} );
			
			wp.customize( 'background_site_predefined', function( value ) {
				// get default standard background
				var background_site_predefined_std = sp_customize.customize_init.background_site_predefined.std;

				// check if a default standard background is set
				if ( background_site_predefined_std.length === 0 ) {
					background_site_predefined_std = 'none';
				} else if ( background_site_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_site_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_site_predefined_std + ')';
				}

				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						if ( background_site_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_site_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_site_predefined.selector ).css( 'background-color', background_site_predefined_std );
						} else {
							$( sp_customize.customize_init.background_site_predefined.selector ).css( 'background', background_site_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_site_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_site_predefined.selector ).css( 'background', 'url(' + backgroundSiteUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_site_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_site_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_site_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_site_bg_position.selector ).css( sp_customize.customize_init.background_site_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_site_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_site_bg_repeat.selector ).css( sp_customize.customize_init.background_site_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_site_bg_attachment', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_site_bg_attachment.selector ).css( sp_customize.customize_init.background_site_bg_attachment.property, newval );
				} );
			} );

			wp.customize( 'background_site_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_site_bg_color.selector ).css( sp_customize.customize_init.background_site_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_site_bg_color.selector ).css( sp_customize.customize_init.background_site_bg_color.property, newval );
					}
				} );
			} );	

			/////////////////////////////////////////////////////
			// topbar background section
			/////////////////////////////////////////////////////	
			var backgroundTopbarUploadSaved;

			wp.customize( 'background_topbar_upload', function( value ) {
				backgroundTopbarUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_topbar_upload.selector ).css( 'background-image', 'url(' + newval + ')' );	
				} );
			} );

			wp.customize( 'background_topbar_predefined', function( value ) {
				// get default standard background
				var background_topbar_predefined_std = sp_customize.customize_init.background_topbar_predefined.std;

				// check if a default standard background is set
				if ( background_topbar_predefined_std.length === 0 ) {
					background_topbar_predefined_std = 'none';
				} else if ( background_topbar_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_topbar_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_topbar_predefined_std + ')';
				}

				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						if ( background_topbar_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_topbar_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_topbar_predefined.selector ).css( 'background-color', background_topbar_predefined_std );
						} else {
							$( sp_customize.customize_init.background_topbar_predefined.selector ).css( 'background', background_topbar_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_topbar_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_topbar_predefined.selector ).css( 'background', 'url(' + backgroundTopbarUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_topbar_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_topbar_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_topbar_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_topbar_bg_position.selector ).css( sp_customize.customize_init.background_topbar_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_topbar_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_topbar_bg_repeat.selector ).css( sp_customize.customize_init.background_topbar_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_topbar_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_topbar_bg_color.selector ).css( sp_customize.customize_init.background_topbar_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_topbar_bg_color.selector ).css( sp_customize.customize_init.background_topbar_bg_color.property, newval );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// header background section
			/////////////////////////////////////////////////////	
			var backgroundHeaderUploadSaved;

			wp.customize( 'background_header_upload', function( value ) {
				backgroundHeaderUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_header_upload.selector ).css( 'background-image', 'url(' + newval + ')' );	
				} );
			} );

			wp.customize( 'background_header_predefined', function( value ) {
				// get default standard background
				var background_header_predefined_std = sp_customize.customize_init.background_header_predefined.std;

				// check if a default standard background is set
				if ( background_header_predefined_std.length === 0 ) {
					background_header_predefined_std = 'none';
				} else if ( background_header_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_header_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_header_predefined_std + ')';
				}

				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						if ( background_header_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_header_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_header_predefined.selector ).css( 'background-color', background_header_predefined_std );
						} else {
							$( sp_customize.customize_init.background_header_predefined.selector ).css( 'background', background_header_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_header_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_header_predefined.selector ).css( 'background', 'url(' + backgroundHeaderUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_header_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_header_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_header_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_header_bg_position.selector ).css( sp_customize.customize_init.background_header_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_header_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_header_bg_repeat.selector ).css( sp_customize.customize_init.background_header_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_header_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_header_bg_color.selector ).css( sp_customize.customize_init.background_header_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_header_bg_color.selector ).css( sp_customize.customize_init.background_header_bg_color.property, newval );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// nav background section
			/////////////////////////////////////////////////////	
			var backgroundNavUploadSaved;

			wp.customize( 'background_nav_upload', function( value ) {
				backgroundNavUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_nav_upload.selector ).css( 'background-image', 'url(' + newval + ')' );	
				} );
			} );

			wp.customize( 'background_nav_predefined', function( value ) {
				// get default standard background
				var background_nav_predefined_std = sp_customize.customize_init.background_nav_predefined.std;

				// check if a default standard background is set
				if ( background_nav_predefined_std.length === 0 ) {
					background_nav_predefined_std = 'none';
				} else if ( background_nav_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_nav_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_nav_predefined_std + ')';
				}

				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						if ( background_nav_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_nav_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_nav_predefined.selector ).css( 'background-color', background_nav_predefined_std );
						} else {
							$( sp_customize.customize_init.background_nav_predefined.selector ).css( 'background', background_nav_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_nav_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_nav_predefined.selector ).css( 'background', 'url(' + backgroundNavUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_nav_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_nav_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_nav_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_nav_bg_position.selector ).css( sp_customize.customize_init.background_nav_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_nav_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_nav_bg_repeat.selector ).css( sp_customize.customize_init.background_nav_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_nav_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_nav_bg_color.selector ).css( sp_customize.customize_init.background_nav_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_nav_bg_color.selector ).css( sp_customize.customize_init.background_nav_bg_color.property, newval );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// page header background section
			/////////////////////////////////////////////////////	
			var backgroundPageHeaderUploadSaved;

			wp.customize( 'background_page_header_upload', function( value ) {
				backgroundPageHeaderUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_page_header_upload.selector ).css( 'background-image', 'url(' + newval + ')' );	
				} );
			} );
		
			wp.customize( 'background_page_header_predefined', function( value ) {
				// get default standard background
				var background_page_header_predefined_std = sp_customize.customize_init.background_page_header_predefined.std;

				// check if a default standard background is set
				if ( background_page_header_predefined_std.length === 0 ) {
					background_page_header_predefined_std = 'none';
				} else if ( background_page_header_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_page_header_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_page_header_predefined_std + ')';
				}

				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						if ( background_page_header_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_page_header_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_page_header_predefined.selector ).css( 'background-color', background_page_header_predefined_std );
						} else {
							$( sp_customize.customize_init.background_page_header_predefined.selector ).css( 'background', background_page_header_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_page_header_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_page_header_predefined.selector ).css( 'background', 'url(' + backgroundPageHeaderUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_page_header_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_page_header_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_page_header_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_page_header_bg_position.selector ).css( sp_customize.customize_init.background_page_header_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_page_header_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_page_header_bg_repeat.selector ).css( sp_customize.customize_init.background_page_header_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_page_header_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_page_header_bg_color.selector ).css( sp_customize.customize_init.background_page_header_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_page_header_bg_color.selector ).css( sp_customize.customize_init.background_page_header_bg_color.property, newval );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// main content background section
			/////////////////////////////////////////////////////	
			var backgroundMainContentUploadSaved;

			wp.customize( 'background_main_content_upload', function( value ) {
				backgroundMainContentUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_main_content_upload.selector ).css( 'background-image', 'url(' + newval + ')' );	
				} );
			} );

			wp.customize( 'background_main_content_predefined', function( value ) {
				// get default standard background
				var background_main_content_predefined_std = sp_customize.customize_init.background_main_content_predefined.std;

				// check if a default standard background is set
				if ( background_main_content_predefined_std.length === 0 ) {
					background_main_content_predefined_std = 'none';
				} else if ( background_main_content_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_main_content_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_main_content_predefined_std + ')';
				}

				value.bind( function( newval ) {console.log(background_main_content_predefined_std); console.log(newval);
					if ( newval === 'none' ) {
						if ( background_main_content_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_main_content_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_main_content_predefined.selector ).css( 'background', background_main_content_predefined_std );
						} else {
							$( sp_customize.customize_init.background_main_content_predefined.selector ).css( 'background', background_main_content_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_main_content_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_main_content_predefined.selector ).css( 'background', 'url(' + backgroundMainContentUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_main_content_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_main_content_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_main_content_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_main_content_bg_position.selector ).css( sp_customize.customize_init.background_main_content_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_main_content_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_main_content_bg_repeat.selector ).css( sp_customize.customize_init.background_main_content_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_main_content_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_main_content_bg_color.selector ).css( sp_customize.customize_init.background_main_content_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_main_content_bg_color.selector ).css( sp_customize.customize_init.background_main_content_bg_color.property, newval );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// footer content background section
			/////////////////////////////////////////////////////	
			var backgroundFooterContentUploadSaved;

			wp.customize( 'background_footer_content_upload', function( value ) {
				backgroundFooterContentUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_footer_content_upload.selector ).css( 'background-image', 'url(' + newval + ')' );	
				} );
			} );

			wp.customize( 'background_footer_content_predefined', function( value ) {
				// get default standard background
				var background_footer_content_predefined_std = sp_customize.customize_init.background_footer_content_predefined.std;

				// check if a default standard background is set
				if ( background_footer_content_predefined_std.length === 0 ) {
					background_footer_content_predefined_std = 'none';
				} else if ( background_footer_content_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_footer_content_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_footer_content_predefined_std + ')';
				}

				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						if ( background_footer_content_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_footer_content_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_footer_content_predefined.selector ).css( 'background-color', background_footer_content_predefined_std );
						} else {
							$( sp_customize.customize_init.background_footer_content_predefined.selector ).css( 'background', background_footer_content_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_footer_content_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_footer_content_predefined.selector ).css( 'background', 'url(' + backgroundFooterContentUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_footer_content_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_footer_content_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_footer_content_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_footer_content_bg_position.selector ).css( sp_customize.customize_init.background_footer_content_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_footer_content_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_footer_content_bg_repeat.selector ).css( sp_customize.customize_init.background_footer_content_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_footer_content_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_footer_content_bg_color.selector ).css( sp_customize.customize_init.background_footer_content_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_footer_content_bg_color.selector ).css( sp_customize.customize_init.background_footer_content_bg_color.property, newval );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// footer bar background section
			/////////////////////////////////////////////////////	
			var backgroundFooterBarUploadSaved;

			wp.customize( 'background_footer_bar_upload', function( value ) {
				backgroundFooterBarUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_footer_bar_upload.selector ).css( 'background-image', 'url(' + newval + ')' );	
				} );
			} );

			wp.customize( 'background_footer_bar_predefined', function( value ) {
				// get default standard background
				var background_footer_bar_predefined_std = sp_customize.customize_init.background_footer_bar_predefined.std;

				// check if a default standard background is set
				if ( background_footer_bar_predefined_std.length === 0 ) {
					background_footer_bar_predefined_std = 'none';
				} else if ( background_footer_bar_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_footer_bar_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_footer_bar_predefined_std + ')';
				}

				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						if ( background_footer_bar_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_footer_bar_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_footer_bar_predefined.selector ).css( 'background-color', background_footer_bar_predefined_std );
						} else {
							$( sp_customize.customize_init.background_footer_bar_predefined.selector ).css( 'background', background_footer_bar_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_footer_bar_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_footer_bar_predefined.selector ).css( 'background', 'url(' + backgroundFooterBarUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_footer_bar_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_footer_bar_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_footer_bar_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_footer_bar_bg_position.selector ).css( sp_customize.customize_init.background_footer_bar_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_footer_bar_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_footer_bar_bg_repeat.selector ).css( sp_customize.customize_init.background_footer_bar_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_footer_bar_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_footer_bar_bg_color.selector ).css( sp_customize.customize_init.background_footer_bar_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_footer_bar_bg_color.selector ).css( sp_customize.customize_init.background_footer_bar_bg_color.property, newval );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// quickview background section
			/////////////////////////////////////////////////////	
			var backgroundQuickviewUploadSaved;

			wp.customize( 'background_quickview_upload', function( value ) {
				backgroundQuickviewUploadSaved = value.get();

				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_quickview_upload.selector ).css( 'background-image', 'url(' + newval + ')' );	
				} );
			} );

			wp.customize( 'background_quickview_predefined', function( value ) {
				// get default standard background
				var background_quickview_predefined_std = sp_customize.customize_init.background_quickview_predefined.std;

				// check if a default standard background is set
				if ( background_quickview_predefined_std.length === 0 ) {
					background_quickview_predefined_std = 'none';
				} else if ( background_quickview_predefined_std.indexOf( '#' ) === 0 ) {

				} else {
					background_quickview_predefined_std = 'url(' + sp_customize.theme_url + 'images/' + background_quickview_predefined_std + ')';
				}

				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						if ( background_quickview_predefined_std.indexOf( '#' ) === 0 ) {
							$( sp_customize.customize_init.background_quickview_predefined.selector ).css( 'background', 'transparent' );
							$( sp_customize.customize_init.background_quickview_predefined.selector ).css( 'background-color', background_quickview_predefined_std );
						} else {
							$( sp_customize.customize_init.background_quickview_predefined.selector ).css( 'background', background_quickview_predefined_std );
						}

					} else if ( newval === 'no-image' ) {
						$( sp_customize.customize_init.background_quickview_predefined.selector ).css( 'background', 'none' );
					} else if ( newval === 'custom' ) {	
						if ( backgroundSiteUploadSaved.length ) {
							$( sp_customize.customize_init.background_quickview_predefined.selector ).css( 'background', 'url(' + backgroundQuickviewUploadSaved + ')' );
						} else {
							$( sp_customize.customize_init.background_quickview_predefined.selector ).css( 'background', 'none' );
						}
					} else {
						$( sp_customize.customize_init.background_quickview_predefined.selector ).css( 'background-image', 'url(' + newval + ')' );
					}
				} );
			} );

			wp.customize( 'background_quickview_bg_position', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_quickview_bg_position.selector ).css( sp_customize.customize_init.background_quickview_bg_position.property, newval );
				} );
			} );	

			wp.customize( 'background_quickview_bg_repeat', function( value ) { 
				value.bind( function( newval ) {
					$( sp_customize.customize_init.background_quickview_bg_repeat.selector ).css( sp_customize.customize_init.background_quickview_bg_repeat.property, newval );
				} );
			} );

			wp.customize( 'background_quickview_bg_color', function( value ) { 
				value.bind( function( newval ) {
					// set transparent if false
					if ( newval === false ) {
						$( sp_customize.customize_init.background_quickview_bg_color.selector ).css( sp_customize.customize_init.background_quickview_bg_color.property, 'transparent' );
					} else {	
						$( sp_customize.customize_init.background_quickview_bg_color.selector ).css( sp_customize.customize_init.background_quickview_bg_color.property, newval );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// navigation section
			/////////////////////////////////////////////////////
			// primary navigation font
			var primary_nav_font;

			wp.customize( 'primary_navigation_font', function( value ) {
				value.bind( function( newval ) {

					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.primary_navigation_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.primary_navigation_font.selector ).css( sp_customize.customize_init.primary_navigation_font.property, newval + ', Arial, sans-serif' );

					// save font to variable
					primary_nav_font = newval;
				} );
			} );	
			
			// primary navigation font variant
			var primary_nav_font_variant;

			wp.customize( 'primary_navigation_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( primary_nav_font ) !== 'undefined' && primary_nav_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( primary_nav_font + ':' + newval );
						}

						primary_nav_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.primary_navigation_font_variant.selector ).css( sp_customize.customize_init.primary_navigation_font_variant.property, newval );
					}
				} );
			} );

			// primary navigation font subset
			var primary_nav_font_subset;

			wp.customize( 'primary_navigation_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( primary_nav_font ) !== 'undefined' && primary_nav_font !== 'none' ) {

							if ( typeof( primary_nav_font_variant ) !== 'undefined' && primary_nav_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( primary_nav_font + ':' + primary_nav_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( primary_nav_font + '::' + newval.toString() );
							}

							primary_nav_font_subset = newval;
						}
					}
				} );
			} );

			// primary navigation title color
			wp.customize( 'primary_navigation_text_color', function( value ) {
				value.bind( function( newval ) { 
					// change css color
					$( sp_customize.customize_init.primary_navigation_text_color.selector ).css( sp_customize.customize_init.primary_navigation_text_color.property, newval );
				} );
			} );

			// primary navigation title color on hover
			wp.customize( 'primary_navigation_text_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.primary_navigation_text_color.selector ).css( sp_customize.customize_init.primary_navigation_text_color_hover.property );

					$( sp_customize.customize_init.primary_navigation_text_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );

			// primary navigation title size
			wp.customize( 'primary_navigation_text_size', function( value ) {
				value.bind( function( newval ) {
					// change css title size
					$( sp_customize.customize_init.primary_navigation_text_size.selector ).css( sp_customize.customize_init.primary_navigation_text_size.property, newval );
				} );
			} );	

			// primary navigation font style
			wp.customize( 'primary_navigation_font_style', function( value ) {
				value.bind( function( newval ) {
					// change css font style
					$( sp_customize.customize_init.primary_navigation_font_style.selector ).css( sp_customize.customize_init.primary_navigation_font_style.property, newval );
				} );
			} );

			// primary navigation font weight
			wp.customize( 'primary_navigation_font_weight', function( value ) {
				value.bind( function( newval ) {
					// change css font weight
					$( sp_customize.customize_init.primary_navigation_font_weight.selector ).css( sp_customize.customize_init.primary_navigation_font_weight.property, newval );
				} );
			} );

			// topbar navigation font
			var topbar_navigation_font;

			wp.customize( 'topbar_navigation_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.topbar_navigation_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.topbar_navigation_font.selector ).css( sp_customize.customize_init.topbar_navigation_font.property, newval + ', Arial, sans-serif' );

					// save font to variable
					topbar_navigation_font = newval;
				} );
			} );	
			
			// topbar navigation font variant
			var topbar_navigation_font_variant;

			wp.customize( 'topbar_navigation_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( topbar_navigation_font ) !== 'undefined' && topbar_navigation_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( topbar_navigation_font + ':' + newval );
						}

						topbar_navigation_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.topbar_navigation_font_variant.selector ).css( sp_customize.customize_init.topbar_navigation_font_variant.property, newval );
					}
				} );
			} );

			// topbar navigation font subset
			var topbar_navigation_font_subset;

			wp.customize( 'topbar_navigation_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( topbar_navigation_font ) !== 'undefined' && topbar_navigation_font !== 'none' ) {

							if ( typeof( topbar_navigation_font_variant ) !== 'undefined' && topbar_navigation_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( topbar_navigation_font + ':' + topbar_navigation_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( topbar_navigation_font + '::' + newval.toString() );
							}

							topbar_navigation_font_subset = newval;
						}
					}
				} );
			} );

			// topbar navigation title color
			wp.customize( 'topbar_navigation_text_color', function( value ) {
				value.bind( function( newval ) { 
					// change css color
					$( sp_customize.customize_init.topbar_navigation_text_color.selector ).css( sp_customize.customize_init.topbar_navigation_text_color.property, newval );
				} );
			} );

			// topbar navigation title color on hover
			wp.customize( 'topbar_navigation_text_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.topbar_navigation_text_color.selector ).css( sp_customize.customize_init.topbar_navigation_text_color_hover.property );

					$( sp_customize.customize_init.topbar_navigation_text_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );

			// topbar navigation title size
			wp.customize( 'topbar_navigation_text_size', function( value ) {
				value.bind( function( newval ) {
					// change css title size
					$( sp_customize.customize_init.topbar_navigation_text_size.selector ).css( sp_customize.customize_init.topbar_navigation_text_size.property, newval );
				} );
			} );	

			// topbar navigation font style
			wp.customize( 'topbar_navigation_font_style', function( value ) {
				value.bind( function( newval ) {
					// change css font style
					$( sp_customize.customize_init.topbar_navigation_font_style.selector ).css( sp_customize.customize_init.topbar_navigation_font_style.property, newval );
				} );
			} );

			// topbar navigation font weight
			wp.customize( 'topbar_navigation_font_weight', function( value ) {
				value.bind( function( newval ) {
					// change css font weight
					$( sp_customize.customize_init.topbar_navigation_font_weight.selector ).css( sp_customize.customize_init.topbar_navigation_font_weight.property, newval );
				} );
			} );

			// footer navigation font
			var footer_navigation_font;

			wp.customize( 'footer_navigation_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.footer_navigation_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.footer_navigation_font.selector ).css( sp_customize.customize_init.footer_navigation_font.property, newval + ', Arial, sans-serif' );

					// save font to variable
					footer_navigation_font = newval;
				} );
			} );	
			
			// footer navigation font variant
			var footer_navigation_font_variant;

			wp.customize( 'footer_navigation_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( footer_navigation_font ) !== 'undefined' && footer_navigation_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( footer_navigation_font + ':' + newval );
						}

						footer_navigation_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.footer_navigation_font_variant.selector ).css( sp_customize.customize_init.footer_navigation_font_variant.property, newval );
					}
				} );
			} );

			// footer navigation font subset
			var footer_navigation_font_subset;

			wp.customize( 'footer_navigation_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( footer_navigation_font ) !== 'undefined' && footer_navigation_font !== 'none' ) {

							if ( typeof( footer_navigation_font_variant ) !== 'undefined' && footer_navigation_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( footer_navigation_font + ':' + footer_navigation_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( footer_navigation_font + '::' + newval.toString() );
							}

							footer_navigation_font_subset = newval;
						}
					}
				} );
			} );

			// footer navigation title color
			wp.customize( 'footer_navigation_text_color', function( value ) {
				value.bind( function( newval ) { 
					// change css color
					$( sp_customize.customize_init.footer_navigation_text_color.selector ).css( sp_customize.customize_init.footer_navigation_text_color.property, newval );
				} );
			} );

			// footer navigation title color on hover
			wp.customize( 'footer_navigation_text_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.footer_navigation_text_color.selector ).css( sp_customize.customize_init.footer_navigation_text_color_hover.property );

					$( sp_customize.customize_init.footer_navigation_text_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );

			// footer navigation title size
			wp.customize( 'footer_navigation_text_size', function( value ) {
				value.bind( function( newval ) {
					// change css title size
					$( sp_customize.customize_init.footer_navigation_text_size.selector ).css( sp_customize.customize_init.footer_navigation_text_size.property, newval );
				} );
			} );	

			// footer navigation font style
			wp.customize( 'footer_navigation_font_style', function( value ) {
				value.bind( function( newval ) {
					// change css font style
					$( sp_customize.customize_init.footer_navigation_font_style.selector ).css( sp_customize.customize_init.footer_navigation_font_style.property, newval );
				} );
			} );

			// footer navigation font weight
			wp.customize( 'footer_navigation_font_weight', function( value ) {
				value.bind( function( newval ) {
					// change css font weight
					$( sp_customize.customize_init.footer_navigation_font_weight.selector ).css( sp_customize.customize_init.footer_navigation_font_weight.property, newval );
				} );
			} );

			/////////////////////////////////////////////////////
			// copyright section
			/////////////////////////////////////////////////////
			// copyright show
			wp.customize( 'copyright_show', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'on' ) {
						$( sp_customize.customize_init.copyright_show.selector ).show();
					} else {
						$( sp_customize.customize_init.copyright_show.selector ).hide();
					}
				} );
			} );

			// copyright title text
			wp.customize( 'copyright_title_text', function( value ) {
				value.bind( function( newval ) {
					var year = new Date();

					// convert %YEAR% to year
					newval = newval.replace( '%%YEAR%%', year.getFullYear() );
					newval = newval.replace( '%YEAR%', year.getFullYear() );

					// change title text					
					$( sp_customize.customize_init.copyright_title_text.selector ).html( newval );
				} );
			} );

			// copyright title font
			var copyright_font;

			wp.customize( 'copyright_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.copyright_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.copyright_font.selector ).css( sp_customize.customize_init.copyright_font.property, newval + ', Arial, sans-serif' );

					copyright_font = newval;				
				} );
			} );

			// copyright font variant
			var copyright_font_variant;

			wp.customize( 'copyright_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( copyright_font ) !== 'undefined' && copyright_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( copyright_font + ':' + newval );
						}

						copyright_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.copyright_font_variant.selector ).css( sp_customize.customize_init.copyright_font_variant.property, newval );
					}
				} );
			} );

			// copyright font subset
			var copyright_font_subset;

			wp.customize( 'copyright_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( copyright_font ) !== 'undefined' && copyright_font !== 'none' ) {

							if ( typeof( copyright_font_variant ) !== 'undefined' && copyright_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( copyright_font + ':' + copyright_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( copyright_font + '::' + newval.toString() );
							}

							copyright_font_subset = newval;
						}
					}
				} );
			} );

			// copyright title text
			wp.customize( 'copyright_text_color', function( value ) {
				value.bind( function( newval ) {
					// change text color			
					$( sp_customize.customize_init.copyright_text_color.selector ).css( sp_customize.customize_init.copyright_text_color.property, newval );
				} );
			} );

			// copyright title text
			wp.customize( 'copyright_text_size', function( value ) {
				value.bind( function( newval ) {
					// change text size		
					$( sp_customize.customize_init.copyright_text_size.selector ).css( sp_customize.customize_init.copyright_text_size.property, newval );
				} );
			} );

			// copyright title text
			wp.customize( 'copyright_font_style', function( value ) {
				value.bind( function( newval ) {
					// change font style		
					$( sp_customize.customize_init.copyright_font_style.selector ).css( sp_customize.customize_init.copyright_font_style.property, newval );
				} );
			} );

			// copyright font weight
			wp.customize( 'copyright_font_weight', function( value ) {
				value.bind( function( newval ) {
					// change font weight	
					$( sp_customize.customize_init.copyright_font_weight.selector ).css( sp_customize.customize_init.copyright_font_weight.property, newval );
				} );
			} );

			// copyright link color
			wp.customize( 'copyright_link_color', function( value ) {
				value.bind( function( newval ) {
					// change link color			
					$( sp_customize.customize_init.copyright_link_color.selector ).css( sp_customize.customize_init.copyright_link_color.property, newval );
				} );
			} );

			// copyright link color on hover
			wp.customize( 'copyright_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.copyright_link_color.selector ).css( sp_customize.customize_init.copyright_link_color_hover.property );

					$( sp_customize.customize_init.copyright_link_color.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );

			// copyright link style
			wp.customize( 'copyright_link_style', function( value ) {
				value.bind( function( newval ) {
					// change link style	
					$( sp_customize.customize_init.copyright_link_style.selector ).css( sp_customize.customize_init.copyright_link_style.property, newval );
				} );
			} );

			// copyright link weight
			wp.customize( 'copyright_link_weight', function( value ) {
				value.bind( function( newval ) {
					// change link weight	
					$( sp_customize.customize_init.copyright_link_weight.selector ).css( sp_customize.customize_init.copyright_link_weight.property, newval );
				} );
			} );

			// copyright link decoration
			wp.customize( 'copyright_link_decoration', function( value ) {
				value.bind( function( newval ) {
					// change link decoration
					$( sp_customize.customize_init.copyright_link_decoration.selector ).css( sp_customize.customize_init.copyright_link_decoration.property, newval );
				} );
			} );

			// copyright link decoration on hover
			wp.customize( 'copyright_link_decoration_hover', function( value ) {
				value.bind( function( newval ) {
					var textDecoration = $( '#copyright a' ).css( 'text-decoration' );

					$( sp_customize.customize_init.copyright_link_decoration.selector ).hover( function() { 
						$( this ).css( 'text-decoration', newval );
					}, function() {
						$( this ).css( 'text-decoration', textDecoration );
					} );
				} );
			} );

			/////////////////////////////////////////////////////
			// headings section
			/////////////////////////////////////////////////////
			// H1 heading font
			// headings h1 title font
			var headings_h1_font;

			wp.customize( 'headings_h1_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.headings_h1_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.headings_h1_font.selector ).css( sp_customize.customize_init.headings_h1_font.property, newval + ', Arial, sans-serif' );

					headings_h1_font = newval;				
				} );
			} );

			// headings h1 font variant
			var headings_h1_font_variant;

			wp.customize( 'headings_h1_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h1_font ) !== 'undefined' && headings_h1_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( headings_h1_font + ':' + newval );
						}

						headings_h1_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.headings_h1_font_variant.selector ).css( sp_customize.customize_init.headings_h1_font_variant.property, newval );
					}
				} );
			} );

			// headings h1 font subset
			var headings_h1_font_subset;

			wp.customize( 'headings_h1_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h1_font ) !== 'undefined' && headings_h1_font !== 'none' ) {

							if ( typeof( headings_h1_font_variant ) !== 'undefined' && headings_h1_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( headings_h1_font + ':' + headings_h1_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( headings_h1_font + '::' + newval.toString() );
							}

							headings_h1_font_subset = newval;
						}
					}
				} );
			} );

			// H1 heading size
			wp.customize( 'headings_h1_text_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h1_text_size.selector ).css( sp_customize.customize_init.headings_h1_text_size.property, newval );
				} );
			} );

			// H1 heading color
			wp.customize( 'headings_h1_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h1_color.selector ).css( sp_customize.customize_init.headings_h1_color.property, newval );
				} );
			} );

			// H1 heading with link color
			wp.customize( 'headings_h1_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h1_link_color.selector ).css( sp_customize.customize_init.headings_h1_link_color.property, newval );
				} );
			} );

			// H1 heading with link color on hover
			wp.customize( 'headings_h1_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( 'h1 a' ).css( 'color' );

					$( 'h1 a' ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );	

			// headings h2 title font
			var headings_h2_font;

			wp.customize( 'headings_h2_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.headings_h2_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.headings_h2_font.selector ).css( sp_customize.customize_init.headings_h2_font.property, newval + ', Arial, sans-serif' );

					headings_h2_font = newval;				
				} );
			} );

			// headings h2 font variant
			var headings_h2_font_variant;

			wp.customize( 'headings_h2_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h2_font ) !== 'undefined' && headings_h2_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( headings_h2_font + ':' + newval );
						}

						headings_h2_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.headings_h2_font_variant.selector ).css( sp_customize.customize_init.headings_h2_font_variant.property, newval );
					}
				} );
			} );

			// headings h2 font subset
			var headings_h2_font_subset;

			wp.customize( 'headings_h2_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h2_font ) !== 'undefined' && headings_h2_font !== 'none' ) {

							if ( typeof( headings_h2_font_variant ) !== 'undefined' && headings_h2_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( headings_h2_font + ':' + headings_h2_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( headings_h2_font + '::' + newval.toString() );
							}

							headings_h2_font_subset = newval;
						}
					}
				} );
			} );

			// h2 heading size
			wp.customize( 'headings_h2_text_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h2_text_size.selector ).css( sp_customize.customize_init.headings_h2_text_size.property, newval );
				} );
			} );

			// h2 heading color
			wp.customize( 'headings_h2_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h2_color.selector ).css( sp_customize.customize_init.headings_h2_color.property, newval );
				} );
			} );

			// h2 heading with link color
			wp.customize( 'headings_h2_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h2_link_color.selector ).css( sp_customize.customize_init.headings_h2_link_color.property, newval );
				} );
			} );

			// h2 heading with link color on hover
			wp.customize( 'headings_h2_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( 'h2 a' ).css( 'color' );

					$( 'h2 a' ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );

			// headings h3 title font
			var headings_h3_font;

			wp.customize( 'headings_h3_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.headings_h3_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.headings_h3_font.selector ).css( sp_customize.customize_init.headings_h3_font.property, newval + ', Arial, sans-serif' );

					headings_h3_font = newval;				
				} );
			} );

			// headings h3 font variant
			var headings_h3_font_variant;

			wp.customize( 'headings_h3_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h3_font ) !== 'undefined' && headings_h3_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( headings_h3_font + ':' + newval );
						}

						headings_h3_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.headings_h3_font_variant.selector ).css( sp_customize.customize_init.headings_h3_font_variant.property, newval );
					}
				} );
			} );

			// headings h3 font subset
			var headings_h3_font_subset;

			wp.customize( 'headings_h3_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h3_font ) !== 'undefined' && headings_h3_font !== 'none' ) {

							if ( typeof( headings_h3_font_variant ) !== 'undefined' && headings_h3_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( headings_h3_font + ':' + headings_h3_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( headings_h3_font + '::' + newval.toString() );
							}

							headings_h3_font_subset = newval;
						}
					}
				} );
			} );

			// h3 heading size
			wp.customize( 'headings_h3_text_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h3_text_size.selector ).css( sp_customize.customize_init.headings_h3_text_size.property, newval );
				} );
			} );

			// h3 heading color
			wp.customize( 'headings_h3_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h3_color.selector ).css( sp_customize.customize_init.headings_h3_color.property, newval );
				} );
			} );

			// h3 heading with link color
			wp.customize( 'headings_h3_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h3_link_color.selector ).css( sp_customize.customize_init.headings_h3_link_color.property, newval );
				} );
			} );

			// h3 heading with link color on hover
			wp.customize( 'headings_h3_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( 'h3 a' ).css( 'color' );

					$( 'h3 a' ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );	

			// headings h4 title font
			var headings_h4_font;

			wp.customize( 'headings_h4_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.headings_h4_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.headings_h4_font.selector ).css( sp_customize.customize_init.headings_h4_font.property, newval + ', Arial, sans-serif' );

					headings_h4_font = newval;				
				} );
			} );

			// headings h4 font variant
			var headings_h4_font_variant;

			wp.customize( 'headings_h4_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h4_font ) !== 'undefined' && headings_h4_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( headings_h4_font + ':' + newval );
						}

						headings_h4_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.headings_h4_font_variant.selector ).css( sp_customize.customize_init.headings_h4_font_variant.property, newval );
					}
				} );
			} );

			// headings h4 font subset
			var headings_h4_font_subset;

			wp.customize( 'headings_h4_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h4_font ) !== 'undefined' && headings_h4_font !== 'none' ) {

							if ( typeof( headings_h4_font_variant ) !== 'undefined' && headings_h4_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( headings_h4_font + ':' + headings_h4_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( headings_h4_font + '::' + newval.toString() );
							}

							headings_h4_font_subset = newval;
						}
					}
				} );
			} );

			// h4 heading size
			wp.customize( 'headings_h4_text_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h4_text_size.selector ).css( sp_customize.customize_init.headings_h4_text_size.property, newval );
				} );
			} );

			// h4 heading color
			wp.customize( 'headings_h4_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h4_color.selector ).css( sp_customize.customize_init.headings_h4_color.property, newval );
				} );
			} );

			// h4 heading with link color
			wp.customize( 'headings_h4_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h4_link_color.selector ).css( sp_customize.customize_init.headings_h4_link_color.property, newval );
				} );
			} );

			// h4 heading with link color on hover
			wp.customize( 'headings_h4_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( 'h4 a' ).css( 'color' );

					$( 'h4 a' ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );	

			// headings h5 title font
			var headings_h5_font;

			wp.customize( 'headings_h5_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.headings_h5_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.headings_h5_font.selector ).css( sp_customize.customize_init.headings_h5_font.property, newval + ', Arial, sans-serif' );

					headings_h5_font = newval;					
				} );
			} );

			// headings h5 font variant
			var headings_h5_font_variant;

			wp.customize( 'headings_h5_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h5_font ) !== 'undefined' && headings_h5_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( headings_h5_font + ':' + newval );
						}

						headings_h5_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.headings_h5_font_variant.selector ).css( sp_customize.customize_init.headings_h5_font_variant.property, newval );
					}
				} );
			} );

			// headings h5 font subset
			var headings_h5_font_subset;

			wp.customize( 'headings_h5_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h5_font ) !== 'undefined' && headings_h5_font !== 'none' ) {

							if ( typeof( headings_h5_font_variant ) !== 'undefined' && headings_h5_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( headings_h5_font + ':' + headings_h5_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( headings_h5_font + '::' + newval.toString() );
							}

							headings_h5_font_subset = newval;
						}
					}
				} );
			} );

			// h5 heading size
			wp.customize( 'headings_h5_text_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h5_text_size.selector ).css( sp_customize.customize_init.headings_h5_text_size.property, newval );
				} );
			} );

			// h5 heading color
			wp.customize( 'headings_h5_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h5_color.selector ).css( sp_customize.customize_init.headings_h5_color.property, newval );
				} );
			} );

			// h5 heading with link color
			wp.customize( 'headings_h5_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h5_link_color.selector ).css( sp_customize.customize_init.headings_h5_link_color.property, newval );
				} );
			} );

			// h5 heading with link color on hover
			wp.customize( 'headings_h5_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( 'h5 a' ).css( 'color' );

					$( 'h5 a' ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );

			// headings h6 title font
			var headings_h6_font;

			wp.customize( 'headings_h6_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.headings_h6_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.headings_h6_font.selector ).css( sp_customize.customize_init.headings_h6_font.property, newval + ', Arial, sans-serif' );

					headings_h6_font = newval;				
				} );
			} );

			// headings h6 font variant
			var headings_h6_font_variant;

			wp.customize( 'headings_h6_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h6_font ) !== 'undefined' && headings_h6_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( headings_h6_font + ':' + newval );
						}

						headings_h6_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.headings_h6_font_variant.selector ).css( sp_customize.customize_init.headings_h6_font_variant.property, newval );
					}
				} );
			} );

			// headings h6 font subset
			var headings_h6_font_subset;

			wp.customize( 'headings_h6_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( headings_h6_font ) !== 'undefined' && headings_h6_font !== 'none' ) {

							if ( typeof( headings_h6_font_variant ) !== 'undefined' && headings_h6_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( headings_h6_font + ':' + headings_h6_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( headings_h6_font + '::' + newval.toString() );
							}

							headings_h6_font_subset = newval;
						}
					}
				} );
			} );

			// h6 heading size
			wp.customize( 'headings_h6_text_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h6_text_size.selector ).css( sp_customize.customize_init.headings_h6_text_size.property, newval );
				} );
			} );

			// h6 heading color
			wp.customize( 'headings_h6_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h6_color.selector ).css( sp_customize.customize_init.headings_h6_color.property, newval );
				} );
			} );

			// h6 heading with link color
			wp.customize( 'headings_h6_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.headings_h6_link_color.selector ).css( sp_customize.customize_init.headings_h6_link_color.property, newval );
				} );
			} );

			// h6 heading with link color on hover
			wp.customize( 'headings_h6_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( 'h6 a' ).css( 'color' );

					$( 'h6 a' ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );
			
			/////////////////////////////////////////////////////
			// blog section
			/////////////////////////////////////////////////////
			var blog_category_title_font;

			// blog category title font
			wp.customize( 'blog_category_title_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.blog_category_title_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.blog_category_title_font.selector ).css( sp_customize.customize_init.blog_category_title_font.property, newval + ', Arial, sans-serif' );

					// save font to variable
					blog_category_title_font = newval;											
				} );
			} );	

			// blog category title font variant
			var blog_category_title_font_variant;

			wp.customize( 'blog_category_title_font_variant', function( value ) { 
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( blog_category_title_font ) !== 'undefined' && blog_category_title_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( blog_category_title_font + ':' + newval );
						}

						blog_category_title_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.blog_category_title_font_variant.selector ).css( sp_customize.customize_init.blog_category_title_font_variant.property, newval );
					}
				} );
			} );

			// blog category title font subset
			var blog_category_title_font_subset;

			wp.customize( 'blog_category_title_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( blog_category_title_font ) !== 'undefined' && blog_category_title_font !== 'none' ) {

							if ( typeof( blog_category_title_font_variant ) !== 'undefined' && blog_category_title_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( blog_category_title_font + ':' + blog_category_title_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( blog_category_title_font + '::' + newval.toString() );
							}

							blog_category_title_font_subset = newval;
						}
					}
				} );
			} );

			// blog category title size
			wp.customize( 'blog_category_title_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_category_title_size.selector ).css( 'font-size', newval );
				} );
			} );

			// blog category title color
			wp.customize( 'blog_category_title_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_category_title_color.selector ).css( 'color', newval );
				} );
			} );

			// blog category title style
			wp.customize( 'blog_category_title_style', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_category_title_style.selector ).css( 'font-style', newval );
				} );
			} );

			// blog category title weight
			wp.customize( 'blog_category_title_weight', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_category_title_weight.selector ).css( 'font-weight', newval );
				} );
			} );							

			// blog category title decoration
			wp.customize( 'blog_category_title_decoration', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_category_title_decoration.selector ).css( 'text-decoration', newval );
				} );
			} );	

			// blog post title font
			var blog_post_title_font;

			// blog category title font
			wp.customize( 'blog_post_title_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.blog_post_title_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.blog_post_title_font.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					// save font to variable
					blog_post_title_font = newval;											
				} );
			} );	

			// blog category title font variant
			var blog_post_title_font_variant;

			wp.customize( 'blog_post_title_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( blog_post_title_font ) !== 'undefined' && blog_post_title_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( blog_post_title_font + ':' + newval );
						}

						blog_post_title_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.blog_post_title_font_variant.selector ).css( sp_customize.customize_init.blog_post_title_font_variant.property, newval );
					}
				} );
			} );

			// blog category title font subset
			var blog_post_title_font_subset;

			wp.customize( 'blog_post_title_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( blog_post_title_font ) !== 'undefined' && blog_post_title_font !== 'none' ) {

							if ( typeof( blog_post_title_font_variant ) !== 'undefined' && blog_post_title_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( blog_post_title_font + ':' + blog_post_title_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( blog_post_title_font + '::' + newval.toString() );
							}

							blog_post_title_font_subset = newval;
						}
					}
				} );
			} );

			// blog post title size
			wp.customize( 'blog_post_title_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_title_size.selector ).css( 'font-size', newval );
				} );
			} );

			// blog post title color
			wp.customize( 'blog_post_title_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_title_color.selector ).css( 'color', newval );
				} );
			} );

			// blog post title color on hover
			wp.customize( 'blog_post_title_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.blog_post_title_color_hover.selector ).css( 'color' );

					$( sp_customize.customize_init.blog_post_title_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );

			// blog post title style
			wp.customize( 'blog_post_title_style', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_title_style.selector ).css( 'font-style', newval );
				} );
			} );

			// blog post title weight
			wp.customize( 'blog_post_title_weight', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_title_weight.selector ).css( 'font-weight', newval );
				} );
			} );							

			// blog post title decoration
			wp.customize( 'blog_post_title_decoration', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_title_decoration.selector ).css( 'text-decoration', newval );
				} );
			} );						

			// blog post entry meta font
			var blog_post_entry_meta_font;

			wp.customize( 'blog_post_entry_meta_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.blog_post_entry_meta_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.blog_post_entry_meta_font.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					blog_post_entry_meta_font = newval;
				} );
			} );	

			// blog post entry meta title font variant
			var blog_post_entry_meta_font_variant;

			wp.customize( 'blog_post_entry_meta_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( blog_post_entry_meta_font ) !== 'undefined' && blog_post_entry_meta_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( blog_post_entry_meta_font + ':' + newval );
						}

						blog_post_entry_meta_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.blog_post_entry_meta_font_variant.selector ).css( sp_customize.customize_init.blog_post_entry_meta_font_variant.property, newval );
					}
				} );
			} );

			// blog post entry meta title font subset
			var blog_post_entry_meta_font_subset;

			wp.customize( 'blog_post_entry_meta_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( blog_post_entry_meta_font ) !== 'undefined' && blog_post_entry_meta_font !== 'none' ) {

							if ( typeof( blog_post_entry_meta_font_variant ) !== 'undefined' && blog_post_entry_meta_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( blog_post_entry_meta_font + ':' + blog_post_entry_meta_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( blog_post_entry_meta_font + '::' + newval.toString() );
							}

							blog_post_entry_meta_font_subset = newval;
						}
					}
				} );
			} );

			// blog post entry meta size
			wp.customize( 'blog_post_entry_meta_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_meta_size.selector ).css( 'font-size', newval );
				} );
			} );

			// blog post entry meta color
			wp.customize( 'blog_post_entry_meta_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_meta_color.selector ).css( 'color', newval );
				} );
			} );							

			// blog post entry meta link color
			wp.customize( 'blog_post_entry_meta_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_meta_link_color.selector ).css( 'color', newval );
				} );
			} );						
					
			// blog post entry meta link color on hover
			wp.customize( 'blog_post_entry_meta_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.blog_post_entry_meta_link_color_hover.selector ).css( 'color' );

					$( sp_customize.customize_init.blog_post_entry_meta_link_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );	

			// blog post entry meta link style
			wp.customize( 'blog_post_entry_meta_link_style', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_meta_link_style.selector ).css( 'font-style', newval );
				} );
			} );

			// blog post entry meta link weight
			wp.customize( 'blog_post_entry_meta_link_weight', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_meta_link_weight.selector ).css( 'font-weight', newval );
				} );
			} );

			// blog post entry meta link decoration
			wp.customize( 'blog_post_entry_meta_link_decoration', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_meta_link_decoration.selector ).css( 'text-decoration', newval );
				} );
			} );

			// blog post entry meta link decoration on hover
			wp.customize( 'blog_post_entry_meta_link_decoration_hover', function( value ) {
				value.bind( function( newval ) {
					var textDecoration = $( sp_customize.customize_init.blog_post_entry_meta_link_decoration_hover.selector ).css( 'text-decoration' );

					$( sp_customize.customize_init.blog_post_entry_meta_link_decoration_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'text-decoration', newval );
					}, function() {
						$( this ).css( 'text-decoration', textDecoration );
					} );
				} );
			} );						

			// blog post entry content font
			var blog_post_entry_content_font;

			wp.customize( 'blog_post_entry_content_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.blog_post_entry_content_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.blog_post_entry_content_font.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					blog_post_entry_content_font = newval;
				} );
			} );	

			// blog post title font variant
			var blog_post_entry_content_font_variant;

			wp.customize( 'blog_post_entry_content_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( blog_post_entry_content_font ) !== 'undefined' && blog_post_entry_content_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( blog_post_entry_content_font + ':' + newval );
						}

						blog_post_entry_content_font_variant = newval;
						
						// change font weight				
						$( sp_customize.customize_init.blog_post_entry_content_font_variant.selector ).css( sp_customize.customize_init.blog_post_entry_content_font_variant.property, newval );
					}
				} );
			} );

			// blog post title font subset
			var blog_post_entry_content_font_subset;

			wp.customize( 'blog_post_entry_content_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( blog_post_entry_content_font ) !== 'undefined' && blog_post_entry_content_font !== 'none' ) {

							if ( typeof( blog_post_entry_content_font_variant ) !== 'undefined' && blog_post_entry_content_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( blog_post_entry_content_font + ':' + blog_post_entry_content_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( blog_post_entry_content_font + '::' + newval.toString() );
							}

							blog_post_entry_content_font_subset = newval;
						}
					}
				} );
			} );

			// blog post entry content size
			wp.customize( 'blog_post_entry_content_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_content_size.selector ).css( 'font-size', newval );
				} );
			} );

			// blog post entry content color
			wp.customize( 'blog_post_entry_content_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_content_color.selector ).css( 'color', newval );
				} );
			} );							

			// blog post entry content link color
			wp.customize( 'blog_post_entry_content_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_content_link_color.selector ).css( 'color', newval );
				} );
			} );						
					
			// blog post entry content link color on hover
			wp.customize( 'blog_post_entry_content_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.blog_post_entry_content_link_color_hover.selector ).css( 'color' );

					$( sp_customize.customize_init.blog_post_entry_content_link_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );	

			// blog post entry content link style
			wp.customize( 'blog_post_entry_content_link_style', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_content_link_style.selector ).css( 'font-style', newval );
				} );
			} );

			// blog post entry content link weight
			wp.customize( 'blog_post_entry_content_link_weight', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_content_link_weight.selector ).css( 'font-weight', newval );
				} );
			} );

			// blog post entry content link decoration
			wp.customize( 'blog_post_entry_content_link_decoration', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.blog_post_entry_content_link_decoration.selector ).css( 'text-decoration', newval );
				} );
			} );

			// blog post entry content link decoration on hover
			wp.customize( 'blog_post_entry_content_link_decoration_hover', function( value ) {
				value.bind( function( newval ) {
					var textDecoration = $( '.blog .entry-content a' ).css( 'text-decoration' );

					$( sp_customize.customize_init.blog_post_entry_content_link_decoration_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'text-decoration', newval );
					}, function() {
						$( this ).css( 'text-decoration', textDecoration );
					} );
				} );
			} );

			/////////////////////////////////////////////////////
			// page section
			/////////////////////////////////////////////////////

			// page title font
			var page_title_font;

			wp.customize( 'page_title_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.page_title_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.page_title_font.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					page_title_font = newval;
				} );
			} );	

			// page font variant
			var page_title_font_variant;

			wp.customize( 'page_title_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( page_title_font ) !== 'undefined' && page_title_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( page_title_font + ':' + newval );
						}

						page_title_font_variant = newval;

						// change font weight				
						$( sp_customize.customize_init.page_title_font_variant.selector ).css( sp_customize.customize_init.page_title_font_variant.property, newval );
					}
				} );
			} );

			// page font subset
			var page_title_font_subset;

			wp.customize( 'page_title_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( page_title_font ) !== 'undefined' && page_title_font !== 'none' ) {

							if ( typeof( page_title_font_variant ) !== 'undefined' && page_title_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( page_title_font + ':' + page_title_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( page_title_font + '::' + newval.toString() );
							}

							page_title_font_subset = newval;
						}
					}
				} );
			} );

			// page title size
			wp.customize( 'page_title_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_title_size.selector ).css( 'font-size', newval );
				} );
			} );

			// page title color
			wp.customize( 'page_title_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_title_color.selector ).css( 'color', newval );
				} );
			} );

			// page title style
			wp.customize( 'page_title_style', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_title_style.selector ).css( 'font-style', newval );
				} );
			} );

			// page title weight
			wp.customize( 'page_title_weight', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_title_weight.selector ).css( 'font-weight', newval );
				} );
			} );							

			// page entry content font
			var page_entry_content_font;

			wp.customize( 'page_entry_content_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.page_entry_content_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.page_entry_content.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					page_entry_content_font = newval;
				} );
			} );	

			// page entry content font variant
			var page_entry_content_font_variant;

			wp.customize( 'page_entry_content_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( page_entry_content_font ) !== 'undefined' && page_entry_content_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( page_entry_content_font + ':' + newval );
						}

						page_entry_content_font_variant = newval;

						// change font weight				
						$( sp_customize.customize_init.page_entry_content_font_variant.selector ).css( sp_customize.customize_init.page_entry_content_font_variant.property, newval );
					}
				} );
			} );

			// page entry content font subset
			var page_entry_content_font_subset;

			wp.customize( 'page_entry_content_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( page_entry_content_font ) !== 'undefined' && page_entry_content_font !== 'none' ) {

							if ( typeof( page_entry_content_font_variant ) !== 'undefined' && page_entry_content_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( page_entry_content_font + ':' + page_entry_content_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( page_entry_content_font + '::' + newval.toString() );
							}

							page_entry_content_font_subset = newval;
						}
					}
				} );
			} );

			// page entry content size
			wp.customize( 'page_entry_content_size', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_entry_content_size.selector ).css( 'font-size', newval );
				} );
			} );

			// page entry content color
			wp.customize( 'page_entry_content_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_entry_content_color.selector ).css( 'color', newval );
				} );
			} );							

			// page entry content link color
			wp.customize( 'page_entry_content_link_color', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_entry_content_link_color.selector ).css( 'color', newval );
				} );
			} );						
					
			// page entry content link color on hover
			wp.customize( 'page_entry_content_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.page_entry_content_link_color_hover.selector ).css( 'color' );

					$( sp_customize.customize_init.page_entry_content_link_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );	

			// page entry content link style
			wp.customize( 'page_entry_content_link_style', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_entry_content_link_style.selector ).css( 'font-style', newval );
				} );
			} );

			// page entry content link weight
			wp.customize( 'page_entry_content_link_weight', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_entry_content_link_weight.selector ).css( 'font-weight', newval );
				} );
			} );

			// page entry content link decoration
			wp.customize( 'page_entry_content_link_decoration', function( value ) {
				value.bind( function( newval ) {
					$( sp_customize.customize_init.page_entry_content_link_decoration.selector ).css( 'text-decoration', newval );
				} );
			} );

			// page entry content link decoration on hover
			wp.customize( 'page_entry_content_link_decoration_hover', function( value ) {
				value.bind( function( newval ) {
					var textDecoration = $( sp_customize.customize_init.page_entry_content_link_decoration_hover.selector ).css( 'text-decoration' );

					$( sp_customize.customize_init.page_entry_content_link_decoration_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'text-decoration', newval );
					}, function() {
						$( this ).css( 'text-decoration', textDecoration );
					} );
				} );
			} );

			/////////////////////////////////////////////////////
			// products section
			/////////////////////////////////////////////////////
			// products page title
			var products_page_title_font;

			wp.customize( 'products_page_title_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.products_page_title_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.products_page_title_font.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					products_page_title_font = newval;
				} );
			} );		

			// product page title font variant
			var products_page_title_font_variant;

			wp.customize( 'products_page_title_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( products_page_title_font ) !== 'undefined' && products_page_title_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( products_page_title_font + ':' + newval );
						}

						products_page_title_font_variant = newval;

						// change font weight				
						$( sp_customize.customize_init.products_page_title_font_variant.selector ).css( sp_customize.customize_init.products_page_title_font_variant.property, newval );
					}
				} );
			} );

			// product page title font subset
			var products_page_title_font_subset;

			wp.customize( 'products_page_title_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( products_page_title_font ) !== 'undefined' && products_page_title_font !== 'none' ) {

							if ( typeof( products_page_title_font_variant ) !== 'undefined' && products_page_title_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( products_page_title_font + ':' + products_page_title_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( products_page_title_font + '::' + newval.toString() );
							}

							products_page_title_font_subset = newval;
						}
					}
				} );
			} );

			// products page title size
			wp.customize( 'products_page_title_size', function( value ) {
				value.bind( function( newval ) {
					// change text size					
					$( sp_customize.customize_init.products_page_title_size.selector ).css( 'font-size', newval );
				} );
			} );	

			// products page title color
			wp.customize( 'products_page_title_color', function( value ) {
				value.bind( function( newval ) {
					// change text color			
					$( sp_customize.customize_init.products_page_title_color.selector ).css( 'color', newval );
				} );
			} );		

			// products page title style
			wp.customize( 'products_page_title_style', function( value ) {
				value.bind( function( newval ) {
					// change text style					
					$( sp_customize.customize_init.products_page_title_style.selector ).css( 'font-style', newval );
				} );
			} );

			// products page title weight
			wp.customize( 'products_page_title_weight', function( value ) {
				value.bind( function( newval ) {
					// change text weight
					$( sp_customize.customize_init.products_page_title_weight.selector ).css( 'font-weight', newval );
				} );
			} );	

			// products title font
			var products_title_font;

			wp.customize( 'products_title_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.products_title_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.products_title_font.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					products_title_font = newval;
				} );
			} );

			// products title font variant
			var products_title_font_variant;

			wp.customize( 'products_title_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( products_title_font ) !== 'undefined' && products_title_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( products_title_font + ':' + newval );
						}

						products_title_font_variant = newval;

						// change font weight				
						$( sp_customize.customize_init.products_title_font_variant.selector ).css( sp_customize.customize_init.products_title_font_variant.property, newval );
					}
				} );
			} );

			// products title font subset
			var products_title_font_subset;

			wp.customize( 'products_title_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( products_title_font ) !== 'undefined' && products_title_font !== 'none' ) {

							if ( typeof( products_title_font_variant ) !== 'undefined' && products_title_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( products_title_font + ':' + products_title_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( products_title_font + '::' + newval.toString() );
							}

							products_title_font_subset = newval;
						}
					}
				} );
			} );

			// products title weight
			wp.customize( 'products_title_size', function( value ) {
				value.bind( function( newval ) {
					// change text size
					$( sp_customize.customize_init.products_title_size.selector ).css( 'font-size', newval );
				} );
			} );	

			// products title color
			wp.customize( 'products_title_color', function( value ) {
				value.bind( function( newval ) {
					// change text color
					$( sp_customize.customize_init.products_title_color.selector ).css( 'color', newval );
				} );
			} );			

			// products title style
			wp.customize( 'products_title_style', function( value ) {
				value.bind( function( newval ) {
					// change text style
					$( sp_customize.customize_init.products_title_style.selector ).css( 'font-style', newval );
				} );
			} );			

			// products title weight
			wp.customize( 'products_title_weight', function( value ) {
				value.bind( function( newval ) {
					// change text weight
					$( sp_customize.customize_init.products_title_weight.selector ).css( 'font-weight', newval );
				} );
			} );	

			// products title link decoration
			wp.customize( 'products_title_link_decoration', function( value ) {
				value.bind( function( newval ) {
					// change text link decoration
					$( sp_customize.customize_init.products_title_link_decoration.selector ).css( 'text-decoration', newval );
				} );
			} );

			// products title link decoration on hover
			wp.customize( 'products_title_link_decoration_hover', function( value ) {
				value.bind( function( newval ) {
					var textDecoration = $( sp_customize.customize_init.products_title_link_decoration_hover.selector ).css( 'text-decoration' );

					$( sp_customize.customize_init.products_title_link_decoration_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'text-decoration', newval );
					}, function() {
						$( this ).css( 'text-decoration', textDecoration );
					} );
				} );
			} );

			// products detail title font
			var products_detail_title_font;

			wp.customize( 'products_detail_title_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.products_detail_title_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.products_detail_title_font.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					products_detail_title_font = newval;
				} );
			} );

			// products detail title font variant
			var products_detail_title_font_variant;

			wp.customize( 'products_detail_title_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( products_detail_title_font ) !== 'undefined' && products_detail_title_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( products_detail_title_font + ':' + newval );
						}

						products_detail_title_font_variant = newval;

						// change font weight				
						$( sp_customize.customize_init.products_detail_title_font_variant.selector ).css( sp_customize.customize_init.products_detail_title_font_variant.property, newval );
					}
				} );
			} );

			// products detail title font subset
			var products_detail_title_font_subset;

			wp.customize( 'products_detail_title_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( products_detail_title_font ) !== 'undefined' && products_detail_title_font !== 'none' ) {

							if ( typeof( products_detail_title_font_variant ) !== 'undefined' && products_detail_title_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( products_detail_title_font + ':' + products_detail_title_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( products_detail_title_font + '::' + newval.toString() );
							}

							products_detail_title_font_subset = newval;
						}
					}
				} );
			} );

			// product detail title weight
			wp.customize( 'products_detail_title_size', function( value ) {
				value.bind( function( newval ) {
					// change text size
					$( sp_customize.customize_init.products_detail_title_size.selector ).css( 'font-size', newval );
				} );
			} );	

			// product detail title color
			wp.customize( 'products_detail_title_color', function( value ) {
				value.bind( function( newval ) {
					// change text color
					$( sp_customize.customize_init.products_detail_title_color.selector ).css( 'color', newval );
				} );
			} );			

			// product detail title style
			wp.customize( 'products_detail_title_style', function( value ) {
				value.bind( function( newval ) {
					// change text style
					$( sp_customize.customize_init.products_detail_title_style.selector ).css( 'font-style', newval );
				} );
			} );			

			// product detail title weight
			wp.customize( 'products_detail_title_weight', function( value ) {
				value.bind( function( newval ) {
					// change text weight
					$( sp_customize.customize_init.products_detail_title_weight.selector ).css( 'font-weight', newval );
				} );
			} );		

			// products description
			var products_description_font;

			wp.customize( 'products_description_font', function( value ) {
				value.bind( function( newval ) {
					if ( newval === 'none' ) {
						newval = sp_customize.customize_init.products_description_font.std;
					}

					$.SPCustomizer.load_google_font_script( newval );

					// change font family					
					$( sp_customize.customize_init.products_description_font.selector ).css( 'font-family', newval + ', Arial, sans-serif' );

					products_description_font = newval;
				} );
			} );

			// products description font variant
			var products_description_font_variant;

			wp.customize( 'products_description_font_variant', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( products_description_font ) !== 'undefined' && products_description_font !== 'none' ) {
							$.SPCustomizer.load_google_font_script( products_description_font + ':' + newval );
						}

						products_description_font_variant = newval;

						// change font weight				
						$( sp_customize.customize_init.products_description_font_variant.selector ).css( sp_customize.customize_init.products_description_font_variant.property, newval );
					}
				} );
			} );

			// products description font subset
			var products_description_font_subset;

			wp.customize( 'products_description_font_subset', function( value ) {
				value.bind( function( newval ) {
					if ( newval !== 'none' ) {
						if ( typeof( products_description_font ) !== 'undefined' && products_description_font !== 'none' ) {

							if ( typeof( products_description_font_variant ) !== 'undefined' && products_description_font_variant !== 'none' ) {
								$.SPCustomizer.load_google_font_script( products_description_font + ':' + products_description_font_variant + ':' + newval.toString() );								
							} else {
								$.SPCustomizer.load_google_font_script( products_description_font + '::' + newval.toString() );
							}

							products_description_font_subset = newval;
						}
					}
				} );
			} );

			// products description weight
			wp.customize( 'products_description_size', function( value ) {
				value.bind( function( newval ) {
					// change text size
					$( sp_customize.customize_init.products_description_size.selector ).css( 'font-size', newval );
				} );
			} );	

			// products description color
			wp.customize( 'products_description_color', function( value ) {
				value.bind( function( newval ) {
					// change text color
					$( sp_customize.customize_init.products_description_color.selector ).css( 'color', newval );
				} );
			} );			

			// products description style
			wp.customize( 'products_description_style', function( value ) {
				value.bind( function( newval ) {
					// change text style
					$( sp_customize.customize_init.products_description_style.selector ).css( 'font-style', newval );
				} );
			} );			

			// products description weight
			wp.customize( 'products_description_weight', function( value ) {
				value.bind( function( newval ) {
					// change text weight
					$( sp_customize.customize_init.products_description_weight.selector ).css( 'font-weight', newval );
				} );
			} );	

			// products description link color
			wp.customize( 'products_description_link_color', function( value ) {
				value.bind( function( newval ) {
					// change text color
					$( sp_customize.customize_init.products_description_link_color.selector ).css( 'color', newval );
				} );
			} );

			// products description link color on hover
			wp.customize( 'products_description_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					var color = $( sp_customize.customize_init.products_description_link_color_hover.selector ).css( 'color' );

					$( sp_customize.customize_init.products_description_link_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );
				} );
			} );

			// products description link decoration
			wp.customize( 'products_description_link_decoration', function( value ) {
				value.bind( function( newval ) {
					// change text link decoration
					$( sp_customize.customize_init.products_description_link_decoration.selector ).css( 'text-decoration', newval );
				} );
			} );

			// products description link decoration on hover
			wp.customize( 'products_description_link_decoration_hover', function( value ) {
				value.bind( function( newval ) {
					var textDecoration = $( sp_customize.customize_init.products_description_link_decoration_hover.selector ).css( 'text-decoration' );

					$( sp_customize.customize_init.products_description_link_decoration_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'text-decoration', newval );
					}, function() {
						$( this ).css( 'text-decoration', textDecoration );
					} );
				} );
			} );

			/////////////////////////////////////////////////////
			// widgets section
			/////////////////////////////////////////////////////		

			// widgets title color
			wp.customize( 'widgets_footer_title_color', function( value ) {
				value.bind( function( newval ) {
					// change text color			
					$( sp_customize.customize_init.widgets_footer_title_color.selector ).css( 'color', newval );
				} );
			} );						

			wp.customize( 'widgets_footer_link_color', function( value ) {
				value.bind( function( newval ) {
					// change text color			
					$( sp_customize.customize_init.widgets_footer_link_color.selector ).css( 'color', newval );
				} );
			} );						

			wp.customize( 'widgets_footer_link_color_hover', function( value ) {
				value.bind( function( newval ) {
					// change text color			
					$( sp_customize.customize_init.widgets_footer_link_color_hover.selector ).css( 'color', newval );

					$( sp_customize.customize_init.widgets_footer_link_color_hover.selector.replace( ':hover', '' ) ).hover( function() { 
						$( this ).css( 'color', newval );
					}, function() {
						$( this ).css( 'color', color );
					} );					
				} );
			} );																											
		}  // close init
	}; // close namespace
	
	$.SPCustomizer.init();
// end document ready
} );