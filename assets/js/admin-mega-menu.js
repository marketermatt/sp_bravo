jQuery( document ).ready( function( $ ) {
	'use strict';

	var megaMenuTimeout;

	// create namespace to avoid any possible conflicts
	$.SPMegaMenu = {

		reInit: function( ui ) {
			
			// loop through each item and set mega menu values
			$( 'li.sp-mega-menu-item' ).each( function( i ) {
				var item = $( this ),
					enableCheckbox = $( '.enable-mega-menu', item );

				// bypass depth-0
				if ( ! item.is( '.menu-item-depth-0' ) ) {
					var checkItem = $( 'li.sp-mega-menu-item' ).filter( ':eq( ' + ( i - 1 ) + ' )' );
					
					if ( checkItem.is( '.sp-mega-menu-enable' ) ) {
						item.addClass( 'sp-mega-menu-enable' );

						// uncheck enable mega menu if becomes child depth
						enableCheckbox.prop( 'checked', false );
					} else {
						item.removeClass( 'sp-mega-menu-enable' );
					}
				}

				// if depth 0 or 1
				if ( item.is( '.menu-item-depth-0' ) || item.is( '.menu-item-depth-1' ) ) {
					
					// uncheck use textblock
					item.find( '.use-textblock' ).prop( 'checked', false );

					// remove use textblock class
					item.removeClass( 'is-text-block' );
				}
			} );

			if ( typeof( ui ) !== 'undefined' ) {
				// if currently dragged item and is not depth 0 remove mega menu active text
				if ( ui.item.is( '.menu-item-depth-0' ) && ui.item.find( '.enable-mega-menu' ).prop( 'checked' ) === false ) {
					ui.item.find( '.item-type-sp-mega-menu-text' ).hide();
				}
			}
		},
		
		init: function() {
			function bindMediaUploader() {
				/////////////////////////////////////////////////////
				// media upload
				/////////////////////////////////////////////////////
				var mediaFrame;

				$( '.media-upload' ).on( 'click', function( e ) {

					// prevent default behavior
					e.preventDefault();

					var container = $( this ).parents( 'p' );

					// Create the media frame.
					mediaFrame = wp.media.frames.mediaFrame = wp.media( {

						// Tell the modal to show only images.
						library: {
							type: 'image'
						},

						multiple: false
					} );

					// after a file has been selected
					mediaFrame.on( 'select', function() {
						// get the first file selected
						var attachment = mediaFrame.state().get( 'selection' ).first().toJSON(); 

						// set input field value with full size image
						container.find( 'input.media-file' ).val( attachment.url );
						
					} );

					// open the modal frame
					mediaFrame.open();
				} );
			}
			bindMediaUploader();

			// listens for changes in jQuery sortable and reinitialize
			$( '#menu-to-edit' ).on( 'sortstop', function( event, ui ) {
				// clear time out first
				clearTimeout( megaMenuTimeout );
				megaMenuTimeout = setTimeout( function() { $.SPMegaMenu.reInit( ui ); }, 300 );
			} );

			// listen for mega menu enable checkbox
			$( '#menu-to-edit' ).on( 'click', '.enable-mega-menu', function() {
				var option = $( this ),
					itemContainer = option.parents( '.menu-item' ).eq( 0 );

				if ( option.is( ':checked' ) ) {
					itemContainer.addClass( 'sp-mega-menu-enable' ).trigger( 'refreshItems' );
				} else {
					itemContainer.removeClass( 'sp-mega-menu-enable' ).trigger( 'refreshItems' );
				}		
			} );

			// listen for refresh event
			$( '#menu-to-edit' ).on( 'refreshItems', function() {
				$.SPMegaMenu.reInit();
			} );

			// listen on textblock enable changes
			$( '#menu-to-edit' ).on( 'change', '.sp-mega-menu-item .use-textblock', function() {
				$.SPMegaMenu.reInit();

				// check if textblock is checked
				if ( $( this ).is( ':checked' ) ) {
					// add class
					$( this ).parents( 'li.sp-mega-menu-item' ).addClass( 'is-text-block' );

					bindMediaUploader();
				} else {
					// remove class
					$( this ).parents( 'li.sp-mega-menu-item' ).removeClass( 'is-text-block' );
				}
			} );				
		}  // close init
	}; // close namespace
	
	$.SPMegaMenu.init();
	$.SPMegaMenu.reInit();
// end document ready
} );