// @codekit-prepend "timepicker.js"
// @codekit-prepend "select2.js"
// @codekit-prepend "magnificpopup.js"
// @codekit-prepend "bootstrap.js"

jQuery( document ).ready( function( $ ) {
	'use strict';

	// create namespace to avoid any possible conflicts
	$.SPFrameWork = {	
		showLoading: function( selector ) {
			// show loading
			selector.addClass( 'loading' ).stop( false, true ).fadeIn( 600 );	
		},
			
		hideLoading: function( selector, status ) {
			// hide loading
			if ( status === 'error' ) {
				status = 'save-error';	
			} else {
				status = 'done';	
			}

			selector.removeClass( 'loading' ).addClass( status ).stop( false, true ).delay( 2000 ).fadeOut( 1000, function() {
			
			$( this ).removeClass( status );

			} );	
		},

		enableSaveButton: function() {
			// remove the attribute disabled from button
			$( '.sp-panel input.save' ).removeAttr( 'disabled' );
		},

		toggleCheckbox: function( e ) {
			var buttonID = $( e ).data( 'id' ),
				innerContainer = $( '.inner.' + buttonID ),
				hiddenInput = innerContainer.find( 'input.hidden-checkbox-value' ).first();		 

			if ( hiddenInput.val() === 'on' ) {
				hiddenInput.val( 'off' );
			} else {
				hiddenInput.val( 'on' );
			}
		},

		showHideSliderSettings: function( element ) {
			var container = $( element ).parents( '.slider-settings-container' ),
				selection = $( element ).val();

			if ( selection === 'single' ) {
				// iterate through each row and find context
				$( '.row', container ).each( function() {
					if ( $( this ).hasClass( 'single' ) ) {
						$( this ).show();
					} else if ( $( this ).hasClass( 'carousel' ) ) {
						$( this ).hide();
					}
				} );

			} else if ( selection === 'carousel' ) {
				// iterate through each row and find context
				$( '.row', container ).each( function() {
					if ( $( this ).hasClass( 'carousel' ) ) {
						$( this ).show();
					} else if ( $( this ).hasClass( 'single' ) ) {
						$( this ).hide();
					}
				} );
			}
		},

		updateExportSettings: function() {
			var	$data = {
					action: 'sp_get_theme_settings_ajax',
					ajaxCustomNonce : sp_theme.ajaxCustomNonce
				};

			$.post( sp_theme.ajaxurl, $data, function( response ) {
				$( '.sp-panel .export-box' ).html( response );
			} );
		},

		updateCustomStyles: function( styles ) {
			var	$data = {
					action: 'sp_save_custom_styles_ajax',
					styles: styles,
					ajaxCustomNonce : sp_theme.ajaxCustomNonce
				};

			$.post( sp_theme.ajaxurl, $data );			
		},

		textSizeSlider: function() {
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
					$( 'span.value', container ).html( defaultValue.replace( 'px', '' ) + 'px' );
					input.val( defaultValue ).keyup();
				} );
			} );
		},

		reinitMCE: function( tinymceID ) {
			var element, mceID, editor, wpautop;

			mceID = tinymceID;

			wpautop = false;

			// check if mceID is set
			if ( typeof( mceID ) === 'undefined' ) {
				element =  $( '.sp-tinymce-content' );
				mceID = element.attr( 'id' );
			}

			editor = $( '#wp-' + mceID + '-wrap' );

			// remove the on switch action
			editor.find( '.wp-switch-editor' ).removeAttr( 'onclick' );

			// for some reason we need to trigger the tmce side once before initializing our own
			// for the quicktags to work properly
			$( '.switch-tmce' ).trigger( 'click' );

			editor.on( 'click', '.switch-tmce', function() {
				$( editor ).removeClass( 'html-active' ).addClass( 'tmce-active' );

				if ( wpautop ) {
					var content = window.switchEditors.wpautop( editor.find( 'textarea.sp-tinymce-content' ).val() );

					$( 'textarea.sp-tinymce-content' ).val( content );
				}
				
				if ( tinymce.majorVersion === '4' ) { 
					tinyMCE.execCommand( 'mceAddEditor', true, mceID );
				} else {
					window.tinyMCE.execCommand( 'mceAddControl', true, mceID );
				}
			} );

			editor.on( 'click', '.switch-html', function() {
				$( editor ).removeClass( 'tmce-active' ).addClass( 'html-active' );

				if ( tinymce.majorVersion === '4' ) { 
					tinyMCE.execCommand( 'mceRemoveEditor', true, mceID );
				} else {
					window.tinyMCE.execCommand( 'mceRemoveControl', true, mceID );
				}
			} );

			// for some reason we need to click the tabs to engage the toolbar on html side
			editor.find( '.switch-html' ).trigger( 'click' );
			editor.find( '.switch-tmce' ).trigger( 'click' );

			if ( sp_theme.page_builder_default_editor_tab === 'html' ) {
				editor.find( '.switch-html' ).trigger( 'click' );
			} else {
				editor.find( '.switch-tmce' ).trigger( 'click' );
			}

			wpautop = true;
		},

		newMCE: function( tinymceID ) {
			var element, mceID, editor, wpautop;

			mceID = tinymceID;

			wpautop = false;

			// check if mceID is set
			if ( typeof( mceID ) === 'undefined' ) {
				element =  $( '.sp-tinymce-content' );
				mceID = element.attr( 'id' );
			}

			editor = $( '#wp-' + mceID + '-wrap' );

			// remove the on switch action
			editor.find( '.wp-switch-editor' ).removeAttr( 'onclick' );

			// for some reason we need to trigger the tmce side once before initializing our own
			// for the quicktags to work properly
			$( '.switch-tmce' ).trigger( 'click' );

			editor.on( 'click', '.switch-tmce', function() {
				$( editor ).removeClass( 'html-active' ).addClass( 'tmce-active' );

				if ( wpautop ) {
					var content = window.switchEditors.wpautop( editor.find( 'textarea.sp-tinymce-content' ).val() );

					$( 'textarea.sp-tinymce-content' ).val( content );
				}
				
				if ( tinymce.majorVersion === '4' ) { 
					tinyMCE.execCommand( 'mceAddEditor', true, mceID );
				} else {
					window.tinyMCE.execCommand( 'mceAddControl', true, mceID );
				}
			} );

			editor.on( 'click', '.switch-html', function() {
				$( editor ).removeClass( 'tmce-active' ).addClass( 'html-active' );

				if ( tinymce.majorVersion === '4' ) { 
					tinyMCE.execCommand( 'mceRemoveEditor', true, mceID );
				} else {
					window.tinyMCE.execCommand( 'mceRemoveControl', true, mceID );
				}
			} );

			// for some reason we need to click the tabs to engage the toolbar on html side
			editor.find( '.switch-html' ).trigger( 'click' );
			editor.find( '.switch-tmce' ).trigger( 'click' );

			if ( sp_theme.page_builder_default_editor_tab === 'html' ) {
				editor.find( '.switch-html' ).trigger( 'click' );
			} else {
				editor.find( '.switch-tmce' ).trigger( 'click' );
			}
			
			// initially remove all content
			window.tinyMCE.get( mceID ).setContent( '' );

			wpautop = true;
		},

		popup: function( moduleElement, content ) {
			// build popup
			var popup = $( '<div class="popup-mask"><div class="page-builder-modal popup-content"></div></div>' );

			// insert content into popup
			popup.find( '.popup-content' ).html( content );

			// hide popup initially
			popup.hide();

			// append the popup to body
			$( 'body' ).append( popup );

			// append the close button
			popup.find( '.popup-content' ).append( '<button title="' + sp_theme.page_builder_settings_done_text + '" class="popup-close button button-primary">' + sp_theme.page_builder_settings_done_text + '</button>' );

			// append the cancel button
			popup.find( '.popup-content' ).append( '<button title="' + sp_theme.page_builder_settings_cancel_text + '" class="popup-cancel button">' + sp_theme.page_builder_settings_cancel_text + '</button>' );

			// fade in popup then center it
			popup.fadeIn( 'fast' ).find( '.popup-content' ).center();

			// re center when window resizes
			$( window ).resize( function() { $( '.popup-content' ).center(); } );

			$( '.popup-content' ).on( 'click', '.popup-close', function( e ) {
				// prevent default behavior
				e.preventDefault();

				$.SPFrameWork.closePopup( moduleElement, 'save' );
			} );

			$( '.popup-content' ).on( 'click', '.popup-cancel', function( e ) {
				// prevent default behavior
				e.preventDefault();

				$.SPFrameWork.closePopup( moduleElement, 'cancel' );
			} );			
		},

		closePopup: function( moduleElement, action ) {
			var newContent,
				mceID = $( '.popup-content' ).find( '.sp-tinymce-content' ).attr( 'id' );

			// check to see if tinymce exists
			try {
				newContent = window.tinyMCE.get( mceID ).getContent();

				if ( tinymce.majorVersion === '4' ) { 
					// remove tinymce instance
					window.tinyMCE.execCommand( 'mceRemoveEditor', true, mceID );				
				} else {
					// remove tinymce instance
					window.tinyMCE.execCommand( 'mceRemoveControl', true, mceID );	
				}
			}
			catch ( err ) {
				newContent = $( 'textarea.sp-tinymce-content' ).val();
			}

			if ( action === 'save' ) {

				// set the content value from editor
				moduleElement.find( '.pb-textarea' ).val( newContent );
			}

			$( '.popup-content' ).remove();
			$( '.popup-mask' ).fadeOut( 'fast' ).remove();
		},

		init: function() {

			// plugin to center element vertically and horizontally in center viewport
			$.fn.center = function ( absolute ) {
				return this.each( function () {
					var t = $( this );
			
					t.css({
						position:	absolute ? 'absolute' : 'fixed', 
						left:		'50%', 
						top:		'50%'
					}).css({
						marginLeft:	'-' + ( t.outerWidth() / 2 ) + 'px', 
						marginTop:	'-' + ( t.outerHeight() / 2 ) + 'px'
					});
			
					if ( absolute ) {
						t.css({
							marginTop:	parseInt( t.css('marginTop'), 10 ) + $( window ).scrollTop(), 
							marginLeft:	parseInt( t.css('marginLeft'), 10 ) + $( window ).scrollLeft()
						} );
					}
				} );
			};

			// fix for jQuery clone issue on select fields
			( function ( original ) {
				$.fn.clone = function () {
					var result = original.apply( this, arguments ),
					my_textareas = this.find( 'textarea' ).add( this.filter( 'textarea' ) ),
					result_textareas = result.find( 'textarea' ).add( result.filter( 'textarea' ) ),
					my_selects = this.find( 'select' ).add( this.filter( 'select' ) ),
					result_selects = result.find( 'select' ).add( result.filter( 'select' ) );

					for ( var i = 0, l = my_textareas.length; i < l; ++i ) { $( result_textareas[i] ).val( $( my_textareas[i] ).val() ); }
					for ( var b = 0, x = my_selects.length; b < x; ++b ) { result_selects[b].selectedIndex = my_selects[b].selectedIndex; }

					return result;
				};
			} ) ( $.fn.clone );

			/////////////////////////////////////////////////////
			// start tabs for theme SP Panel
			/////////////////////////////////////////////////////
			// check if tabs function exists
			if ( $.fn.tabs ) {
				$( '#sp-main-tabs, .sp-sub-tabs' ).tabs( { 
					fx: { 
						opacity:'toggle',
						duration: 200
					}			 
				} );
			}

			/////////////////////////////////////////////////////
			// start WP color picker SP Panel
			/////////////////////////////////////////////////////
			// check if colorpicker function exists
			if ( $.fn.wpColorPicker ) {
				$( '.sp-panel input.sp-colorpicker' ).wpColorPicker( {
					change: function() {
						// enable save button
						$.SPFrameWork.enableSaveButton();
					}
				} );
			}

			/////////////////////////////////////////////////////
			// start WP color picker for slider settings
			/////////////////////////////////////////////////////	
			// check if colorpicker function exists
			if ( $.fn.wpColorPicker ) {					
				$( '.slider-settings-container input.sp-colorpicker' ).wpColorPicker();
			}

			/////////////////////////////////////////////////////
			// bind datepicker
			/////////////////////////////////////////////////////
			// check if datetimepicker function exists
			if ( $.fn.datetimepicker ) {			
				$( '.sp-panel input.datepicker' ).datetimepicker();
				$( '#ui-datepicker-div' ).wrap( '<div class="jquery-ui-style" />' );
			}

			/////////////////////////////////////////////////////
			// listen for changes then enable save button
			/////////////////////////////////////////////////////
			$( '#sp-panel-form' ).on( 'change keypress input', function() {
				// enable save button
				$.SPFrameWork.enableSaveButton();
			} );

			/////////////////////////////////////////////////////
			// slide toggle all sections
			/////////////////////////////////////////////////////
			$( '.sp-panel .slide-toggle' ).toggle( function( e ) {
				e.preventDefault();

				$( this ).parents( '.panel' ).find( '.accordion-container' ).slideDown();

				// change button to minus symbol
				$( this ).html( '[ - ]' );

				// change the caret direction
				$( this ).parents( '.panel' ).find( 'h3.header span' ).removeClass( 'caret-closed' ).addClass( 'caret-open' );
			}, function() {
				$( this ).parents( '.panel' ).find( '.accordion-container' ).slideUp();
				
				// change button to plus symbol
				$( this ).html( '[ + ]' );	

				// change the caret direction
				$( this ).parents( '.panel' ).find( 'h3.header span' ).removeClass( 'caret-open' ).addClass( 'caret-closed' );							
			} );

			/////////////////////////////////////////////////////
			// media upload
			/////////////////////////////////////////////////////
			var mediaFrame;

			$( '.media-upload' ).on( 'click', function( e ) { 

				// prevent default behavior
				e.preventDefault();

				var buttonID = $( this ).data( 'id' ),
					innerContainer = $( '.inner.' + buttonID ),
					metaContainer = $( '.meta.' + buttonID );

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
					// get the first file selected
					var attachment = mediaFrame.state().get( 'selection' ).first().toJSON(); 

					// set input field value with full size image
					innerContainer.find( 'input.media-file' ).val( attachment.url ).show();

					// set preview image source to thumbnail size
					if ( attachment.sizes.length > 0 ) {
						metaContainer.find( '.image-preview img' ).attr( 'src', attachment.sizes.thumbnail.url );
					} else {
						metaContainer.find( '.image-preview img' ).attr( 'src', attachment.url );
					}

					// fadein preview
					metaContainer.find( '.image-preview' ).fadeIn( 'fast' );

					// set the attachment id to the hidden field
					metaContainer.find( 'input.attachment-id' ).val( attachment.id );

					// show the remove image button
					metaContainer.find( 'p.remove-media' ).show();
					
					// enable save button
					$.SPFrameWork.enableSaveButton();					

				} );

				// open the modal frame
				mediaFrame.open();
			} );		

			/////////////////////////////////////////////////////
			// remove media
			/////////////////////////////////////////////////////
			$( 'p.remove-media a' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				var buttonID = $( this ).data( 'id' ),
					innerContainer = $( '.inner.' + buttonID ),
					metaContainer = $( '.meta.' + buttonID );

				// unset and hide the image input field
				innerContainer.find( 'input.media-file' ).val( '' ).hide();	

				// unset the image src
				metaContainer.find( '.image-preview img' ).attr( 'src', '' );

				// hide the image preview
				metaContainer.find( '.image-preview' ).hide();

				// unset the attachment id
				metaContainer.find( 'input.attachment-id' ).val( '' );

				// enable save button
				$.SPFrameWork.enableSaveButton();

				// hide itself
				$( this ).parent().hide();
			} );

			/////////////////////////////////////////////////////
			// admin login background image on change
			/////////////////////////////////////////////////////
			$( '.sp-panel' ).on( 'change', 'select[name="admin_login_background_image"]', function() {
				var thisSelect = $( this ),
					uploadModule = thisSelect.parents( 'tr.select-module' ).next( 'tr.upload-module' ),
					metaModule = uploadModule.next( 'tr.upload-module.meta' );

				if ( thisSelect.val() === 'custom' ) {
					uploadModule.css( 'visibility', 'visible' );

					// upload button
					uploadModule.find( '.media-upload' ).css( 'visibility', 'visible' );

					metaModule.css( 'visibility', 'visible' );

					if ( uploadModule.find( '.media-file' ).val().length ) {
						metaModule.find( '.image-preview' ).show();
						metaModule.find( 'p.remove-media' ).show();
					}
				} else {
					uploadModule.css( 'visibility', 'hidden' );

					// upload button
					uploadModule.find( '.media-upload' ).css( 'visibility', 'hidden' );					

					metaModule.css( 'visibility', 'hidden' );

					metaModule.find( '.image-preview' ).hide();

					metaModule.find( 'p.remove-media' ).hide();
				}	
			} );

			/////////////////////////////////////////////////////
			// slider media upload
			/////////////////////////////////////////////////////
			var sliderMediaFrame;

			$( '.slider-media-upload' ).on( 'click', function( e ) { 
				// prevent default behavior
				e.preventDefault();

				var previewBox = $( this ).prev( '.preview-box' ),
					postID = $( this ).data( 'post-id' );

				// Create the media frame.
				sliderMediaFrame = wp.media.frames.sliderMediaFrame = wp.media({

					title: $( this ).data( 'uploader_title' ),

					button: {
						text: $( this ).data( 'uploader_button_text' )
					},

					multiple: true
				} );

				// after a file has been selected
				sliderMediaFrame.on( 'select', function() {
					// get all files selected
					var attachment = sliderMediaFrame.state().get( 'selection' ).toJSON(); 

					// iterate through each object
					$( attachment ).each( function() {
						var attachmentID = this.id,
							$data = {
								action: 'sp_set_slide_media_object_ajax',
								attachment_id: attachmentID,
								post_id: postID,
								size: 'slider_slide_list',
								ajaxCustomNonce: sp_theme.ajaxCustomNonce
							};

						$.post( sp_theme.ajaxurl, $data, function( response ) {
							var newResponse = $.parseJSON( response );
							previewBox.append( newResponse.attachmentObject );
						} );  
					} );				
				} );

				// open the modal frame
				sliderMediaFrame.open();
			} );	

			/////////////////////////////////////////////////////
			// remove slide media
			/////////////////////////////////////////////////////
			$( '.slider-media-container' ).on( 'click', 'a.remove-media', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var container = $( this ).parent(),
					attachmentID = container.data( 'attachment-id' ),
					postID = container.data( 'post-id' );

				// remove the media
				var	$data = {
						action: 'sp_remove_slide_media_ajax',
						attachment_id: attachmentID,
						post_id: postID,
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					// everything is ok
					if ( response === 'done' ) {
						// remove container from preview box
						container.remove();
						
						// remove slide media settings
						$( '.slide-settings-container .inner-container' ).html( '' );						
					}
				} );  
			} );

			/////////////////////////////////////////////////////
			// show hide items for slider settings
			/////////////////////////////////////////////////////			
			$( '.slider-settings-container select[name=type]' ).change( function() {
				$.SPFrameWork.showHideSliderSettings( this );

				// remove the slide media settings
				$( '.slide-settings-container .inner-container' ).html( '' );

				// remove the edit outline on media object
				$( '.slider-media-container img' ).removeClass( 'active' );

				// remove the edit label
				$( '.slider-media-container span.edit' ).removeClass( 'active' );

				// save the type setting
				var	postID = $( '#post_ID' ).val(),
					type = $( this ).val(),
					$data = {
						action: 'sp_save_slider_type_ajax',
						post_id: postID,
						type: type,
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data );
			} );

			// run it once on load
			$.SPFrameWork.showHideSliderSettings( '.slider-settings-container select[name=type]' );	

			/////////////////////////////////////////////////////
			// font select change event - carousel slider settings
			/////////////////////////////////////////////////////
			$( '.slider-settings-container .font-select' ).each( function() { 
				var fontSelect = $( this );

				fontSelect.on( 'change', function() {
					var font				= fontSelect.val(),
						fontVariantSelect	= $( fontSelect ).parents( '.row' ).next( '.row' ).find( 'select.font-variant-select' ),
						fontSubsetSelect	= $( fontVariantSelect ).parents( '.row' ).next( '.row' ).find( 'select.font-subset-select' ),
						$data = {
							action: 'sp_font_select_ajax',
							font: font,
							ajaxCustomNonce : sp_theme.ajaxCustomNonce
						};

					$.post( sp_theme.ajaxurl, $data, function( response ) {

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

			/////////////////////////////////////////////////////
			// make slider slides sortable
			/////////////////////////////////////////////////////
			// check if sortable function exists
			if ( $.fn.sortable ) {			
				$( '.slider-media-container .preview-box.sortable' ).sortable( {
					cursor: 'move',
					placeholder: 'slider-sortable-placeholder',
					stop: function( event, ui ) { 
						var positions = $( '.slider-media-container .preview-box.sortable' ).sortable( "toArray", { attribute: 'data-attachment-id' } ),
							postID = ui.item.data( 'post-id' ),
							$data = {
								action: 'sp_sort_slides_ajax',
								post_id: postID,
								positions: positions,
								ajaxCustomNonce : sp_theme.ajaxCustomNonce
							};

						$.post( sp_theme.ajaxurl, $data );
					}
				} );
			}

			/////////////////////////////////////////////////////
			// show edit settings when slide container is clicked
			/////////////////////////////////////////////////////
			$( '.slider-media-container' ).on( 'click', '.slide-container img', function() {

				var alert = $( this ).siblings( 'img.alert' ),
					postID = $( this ).parent().data( 'post-id' ),
					attachmentID = $( this ).parent().data( 'attachment-id' );

				// show loading
				$.SPFrameWork.showLoading( alert );

				// remove active from all containers
				$( '.slide-container' ).find( 'img' ).removeClass( 'active' );
				$( '.slide-container' ).find( 'span.edit' ).removeClass( 'active' );

				// show an outline of the container being edited
				$( this ).addClass( 'active' );

				// show the span edit tag
				$( this ).parent().find( 'span.edit' ).addClass( 'active' );

				// get the media details
				var	$data = {
						action: 'sp_get_slide_media_details_ajax',
						attachment_id: attachmentID,
						post_id: postID,
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					var newResponse = $.parseJSON( response );

					$( '.slide-settings-container .inner-container' ).html( '' ).append( newResponse.mediaDetail );

					// hide loading
					$.SPFrameWork.hideLoading( alert );

					/////////////////////////////////////////////////////
					// start WP color picker for slide settings
					/////////////////////////////////////////////////////
					$( '.slide-settings-container input.sp-colorpicker' ).wpColorPicker();
					
					/////////////////////////////////////////////////////
					// start select2 plugin for slide settings
					/////////////////////////////////////////////////////
					// check if select2 function exists
					if ( $.fn.select2 ) {					
						$( '.select2-select' ).select2( { width: 'element', minimumResultsForSearch: 20 } );
					}		

					// run text size slider
					$.SPFrameWork.textSizeSlider();																			
				} );
			} ); // show edit settings

			/////////////////////////////////////////////////////
			// when add video link button is clicked
			/////////////////////////////////////////////////////
			$( '.slider-media-container a.add-slide-video-link' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				// show/hide container
				$( '.slider-media-container .video-link-container' ).slideToggle();			
			} );

			/////////////////////////////////////////////////////
			// add video external link to slide
			/////////////////////////////////////////////////////
			$( '.slider-media-container .submit-slide-video-link' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				// if either input fields are not entered don't continue
				if ( ! $( '.slider-media-container input.slide-video-link-input' ).val() || ! $( '.slider-media-container input.slide-video-link-title-input' ).val() ) {
					return;
				}

				// add post
				var	postID = $( this ).data( 'post-id' ),
					title = $( 'input.slide-video-link-title-input' ).val(),
					link = $( 'input.slide-video-link-input' ).val(),
					$data = {
						action: 'sp_add_video_link_slide_ajax',
						post_id: postID,
						link: link, 
						title: title,
						size: 'slider_slide_list',
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					var newResponse = $.parseJSON( response );

					// prepend the slide to preview box
					$( '.preview-box' ).append( newResponse.attachmentObject );	

					// empty the input fields
					$( '.slider-media-container input.slide-video-link-input' ).val( '' );
					$( '.slider-media-container input.slide-video-link-title-input' ).val( '' );			
				} );			
			} );

			/////////////////////////////////////////////////////
			// when add slide content button is clicked
			/////////////////////////////////////////////////////
			$( '.slider-media-container a.add-slide-content' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				// show/hide container
				$( '.slider-media-container .content-media-container' ).slideToggle();			
			} );

			/////////////////////////////////////////////////////
			// add content media to slide
			/////////////////////////////////////////////////////
			$( '.slider-media-container .submit-slide-content' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				// if either input fields are not entered don't continue
				if ( ! $( '.slider-media-container input.slide-content-title-input' ).val() ) {
					return;
				}

				// add post
				var	postID = $( this ).data( 'post-id' ),
					title = $( 'input.slide-content-title-input' ).val(),	
					$data = {
						action: 'sp_add_content_slide_ajax',
						title: title,
						post_id: postID,
						size: 'slider_slide_list',
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					var newResponse = $.parseJSON( response );

					// prepend the slide to preview box
					$( '.preview-box' ).append( newResponse.attachmentObject );	

					// empty the input fields
					$( '.slider-media-container input.slide-content-title-input' ).val( '' );	
				} );				
			} );

			/////////////////////////////////////////////////////
			// save slide settings
			/////////////////////////////////////////////////////
			$( '.slide-settings-container' ).on( 'click', '.save-slide-settings', function( e ) {
				// prevent default behavior
				e.preventDefault();

				// show loading
				$.SPFrameWork.showLoading( $( '.slide-settings-container .alert' ) );

				// handle the font subsets
				$( '.slide-settings-container .font-subset-select' ).each( function() {
					var subsetSelect = $( this );
						
					if ( $( subsetSelect ).val() === null ) {
						// select the default of none when all subsets removed
						$( 'option:first-child', subsetSelect ).attr( 'selected', true );
					}
				} );

				// save the settings
				var form = $( this ).parents( '.slide-settings-container' ).find( 'form' ),
					postID = form.data( 'post-id' ),
					attachmentID = form.data( 'attachment-id' ),
					formFields = form.serialize(),
					$data = {
						action: 'sp_save_slide_settings_ajax',
						form_items: formFields,
						post_id: postID,
						attachment_id: attachmentID,
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) { 
					// hide loading
					$.SPFrameWork.hideLoading( $( '.slide-settings-container .alert' ), response );
				} );
			} );

			/////////////////////////////////////////////////////
			// save settings
			/////////////////////////////////////////////////////
			$( '#sp-panel-form' ).submit( function( e ) {
				// prevent default behavior
				e.preventDefault();

				// show loading
				$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );

				// save the settings
				var form = $( this ).serialize(),
					customStyles = $( '#custom-styles' ).val(),
					$data = {
						action: 'sp_theme_save_ajax',
						form_items: form,
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					// hide loading
					$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), response );

					// disable the save button
					$( '.sp-panel input.save' ).attr( 'disabled', 'disabled' );

					// custom trigger
					$( '#sp-panel-form' ).trigger( 'after_save' );

					// update the export box settings
					$.SPFrameWork.updateExportSettings();

					// if custom styles have content
					if ( customStyles.length ) {
						$.SPFrameWork.updateCustomStyles( customStyles );
					} else {
						$.SPFrameWork.updateCustomStyles( '' );
					}
				} );  
			} );

			/////////////////////////////////////////////////////
			// listen for checkbox value
			/////////////////////////////////////////////////////
			$( 'input.checkbox-button' ).change( function() {
				// toggle the checkbox value
				$.SPFrameWork.toggleCheckbox( this );
			} );

			/////////////////////////////////////////////////////
			// open/close the options box
			/////////////////////////////////////////////////////
			$( '.sp-panel .accordion h3.header' ).click( function() {
				$( this ).next( 'div' ).slideToggle( 'fast', function() { 
					var caret = $( this ).prev( 'h3.header' ).find( 'span' );

					if ( caret.hasClass( 'caret-closed' ) ) {
						$( this ).prev( 'h3.header' ).find( 'span' ).removeClass( 'caret-closed' ).addClass( 'caret-open' );
					} else {
						$( this ).prev( 'h3.header' ).find( 'span' ).removeClass( 'caret-open' ).addClass( 'caret-closed' );
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// slide toggle slider settings
			/////////////////////////////////////////////////////
			$( '.slider-settings-container h3.header' ).toggle( function( e ) {
				e.preventDefault();

				$( this ).next( '.accordion-container' ).slideDown();

				// change the caret direction
				$( this ).find( 'span' ).removeClass( 'caret-closed' ).addClass( 'caret-open' );
			}, function() {
				$( this ).next( '.accordion-container' ).slideUp();

				// change the caret direction
				$( this ).find( 'span' ).removeClass( 'caret-open' ).addClass( 'caret-closed' );							
			} );

			/////////////////////////////////////////////////////
			// reset customizer settings
			/////////////////////////////////////////////////////
			$( '.sp-panel .customizer-reset' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				var reply = confirm( sp_theme.reset_customizer_settings_msg );
				
				// if confirmed
				if ( reply ) {
					// show loading
					$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );
					
					// reset theme settings
					var $data = {
						action: 'sp_customizer_reset_ajax',
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
						};

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						if ( response === 'done' ) {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'done' );
						} else {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'error' );
						}
					} ); 
				}
			} );

			/////////////////////////////////////////////////////
			// reset all settings
			/////////////////////////////////////////////////////
			$( '.sp-panel .theme-reset' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				var reply = confirm( sp_theme.reset_settings_msg );
				
				// if confirmed
				if ( reply ) {
					// show loading
					$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );
					
					// reset theme settings
					var $data = {
						action: 'sp_theme_reset_ajax',
						ajaxCustomNonce : sp_theme.ajaxCustomNonce
						};

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						if ( response === 'done' ) {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'done' );

							// redirect to control panel
							window.location = 'admin.php?page=sp';
						} else {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'error' );
						}
					} ); 
				}
			} );

			/////////////////////////////////////////////////////
			// reset config settings
			/////////////////////////////////////////////////////
			$( '.sp-panel .theme-config-reset' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();
				
				// show loading
				$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );
				
				// reset theme settings
				var $data = {
					action: 'sp_theme_config_reset_ajax',
					ajaxCustomNonce : sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					if ( response === 'done' ) {
						// hide loading
						$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'done' );

						// redirect to control panel
						window.location = 'admin.php?page=sp';
					} else {
						// hide loading
						$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'error' );
					}
				} ); 
			} );

			/////////////////////////////////////////////////////
			// import theme settings
			/////////////////////////////////////////////////////
			$( '.sp-panel .import-theme-settings' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				var reply = confirm( sp_theme.settings_import_msg );

				// if confirmed
				if ( reply ) {				
					// show loading
					$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );

					// import theme settings
					var settings = $( '#textarea-import_theme_settings' ).val(),
						$data = {
							action: 'sp_import_theme_settings_ajax',
							settings: settings,
							ajaxCustomNonce : sp_theme.ajaxCustomNonce
						};

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						if ( response === 'done' ) {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'done' );

							// redirect to control panel
							window.location = 'admin.php?page=sp';
						} else {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'error' );
						}
					} ); 
				}
			} );

			/////////////////////////////////////////////////////
			// when custom widget item selected update location widget
			/////////////////////////////////////////////////////
			$( '.sp-panel' ).on( 'change', 'select.custom-widget-select', function() {
				var parentContainer = $( this ).parents( '.inner' ),
					thisID = $( this ).val(),
					locationSelect = parentContainer.find( 'select.custom-widget-location' ),
					locationSelectID = locationSelect.attr( 'id' );

				// destroy select2 first
				locationSelect.select2( 'destroy' );

				// update the id of the location select from widget select
				locationSelect.attr( 'id', locationSelectID.replace( /\d+/, thisID ) );
				locationSelect.attr( 'name', locationSelectID.replace( /\d+/, thisID ) + '[]' );
				
				// update the select2 plugin
				locationSelect.select2( { width: 'element', minimumResultsForSearch: 20 } );				
			} );

			/////////////////////////////////////////////////////
			// add custom widgets
			/////////////////////////////////////////////////////
			$( '.sp-panel .inner' ).on( 'click', 'a.add-widgets', function( e ) {
				// prevent default behavior
				e.preventDefault();

				// stop the propagation 
				e.stopPropagation();

				var element = $( this ).parents( '.inner' );

				// be sure to destroy select2 instance prior to cloning
				element.find( 'select.select2-select' ).each( function() {
					$( this ).select2( 'destroy' );
				} );

				var cloneElement = element.clone( true ),
					locationSelect = cloneElement.find( '.custom-widget-location' ), 
					locationSelectID = locationSelect.attr( 'id' );

				// insert the element after the list and reset selected to default
				cloneElement.slideDown( 'fast' ).insertAfter( element ).find( 'select option:selected' ).removeAttr( 'selected' );

				// update the id of the location select from widget select
				locationSelect.attr( 'id', locationSelectID.replace( /\d+/, '0' ) );
				locationSelect.attr( 'name', locationSelectID.replace( /\d+/, '0' ) );

				// reinit select2 on orginal and cloned version
				element.find( 'select.select2-select' ).select2( { width: 'element', minimumResultsForSearch: 20 } );
				cloneElement.find( 'select.select2-select' ).select2( { width: 'element', minimumResultsForSearch: 20 } );

				// enable save button
				$.SPFrameWork.enableSaveButton();				

			} );

			/////////////////////////////////////////////////////
			// delete custom widgets
			/////////////////////////////////////////////////////
			$( '.sp-panel .inner' ).on( 'click', 'a.delete-widget', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var element = $( this ).parents( '.inner' ),
					accordionContainer = $( this ).parents( '.accordion-container' );

				// don't delete last item
				if ( accordionContainer.find( '.inner' ).length > 1 ) {
					element.slideUp( 'fast', function() { element.remove(); } );

					// enable save button
					$.SPFrameWork.enableSaveButton();				
				}
			} );

			/////////////////////////////////////////////////////
			// add checkout info link
			/////////////////////////////////////////////////////
			$( '.sp-panel .inner' ).on( 'click', 'a.add-link', function( e ) {
				// prevent default behavior
				e.preventDefault();

				// stop the propagation 
				e.stopPropagation();

				var thisRow = $( this ).parents( '.inner' ),
					previousRow = thisRow.prev( '.checkout_add_links' ),
					thisRowCloned = thisRow.clone( true ),
					previousRowCloned = previousRow.clone( true );

				// insert the element after the list and reset values
				previousRowCloned.fadeIn( 'fast' ).insertAfter( thisRow ).find( 'input' ).val( '' );
				thisRowCloned.fadeIn( 'fast' ).insertAfter( previousRowCloned ).find( 'textarea' ).val( '' );

				// enable save button
				$.SPFrameWork.enableSaveButton();				

			} );

			/////////////////////////////////////////////////////
			// delete checkout info link
			/////////////////////////////////////////////////////
			$( '.sp-panel .inner' ).on( 'click', 'a.delete-link', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var thisRow = $( this ).parents( '.inner' ),
					previousRow = thisRow.prev( '.checkout_add_links' );

				// don't delete last item
				if ( $( '.sp-panel .checkout_add_links' ).length > 2 ) {
					thisRow.fadeOut( 'fast', function() { thisRow.remove(); } );
					previousRow.fadeOut( 'fast', function() { previousRow.remove(); } );

					// enable save button
					$.SPFrameWork.enableSaveButton();				
				}
			} );

			/////////////////////////////////////////////////////
			// create page
			/////////////////////////////////////////////////////
			$( '.sp-panel a.create-page' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				// show loading
				$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );

				// create page
				var pageTitle = $( this ).parents( '.inner' ).find( 'input.page-title' ).val(),
					pageTemplate = $( this ).parents( '.inner' ).find( 'input.page-title' ).val(),
					$data = {
						action: 'sp_create_page_ajax',
						page_title: pageTitle,
						page_template: pageTemplate,
						ajaxCustomNonce: sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					// hide loading
					$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), response );
					
					// redirect to control panel
					window.location = 'admin.php?page=sp';
				} );  
			} );

			/////////////////////////////////////////////////////
			// save theme configuration settings
			/////////////////////////////////////////////////////
			$( '.sp-panel .save-config' ).click( function() {
				// show loading
				$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );

				var configName = $( this ).prevAll( 'input.save-config-name' ).val(),
					$data = {
						action: 'sp_save_config_ajax',
						ajaxCustomNonce: sp_theme.ajaxCustomNonce,
						config_name: configName
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					if ( response === 'done') {

						// update the apply configuration dropdown with new configruation
						$( '.sp-panel select[name=apply_config]' ).append( '<option value="' + configName + '">' + configName + '</option>' );

						// update the select2 plugin
						$( '.sp-panel select[name=apply_config]' ).trigger( 'change' );

						// hide loading
						$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'done' );
					} else {
						// hide loading
						$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'error' );
					}

					$( '.sp-panel input.save-config-name' ).val( '' );
				} );					
			} );

			/////////////////////////////////////////////////////
			// apply theme configuration settings
			/////////////////////////////////////////////////////
			$( '.sp-panel .apply-config' ).click( function() {

				var configName = $( this ).prevAll( 'select[name=apply_config]' ).val(),
					reply = confirm( sp_theme.apply_config_msg ),
					$data = {
						action: 'sp_apply_config_ajax',
						ajaxCustomNonce: sp_theme.ajaxCustomNonce,
						config_name: configName
					};

				// if confirmed
				if ( reply ) {	
					// show loading
					$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						if ( response === 'done') {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'done' );

							// redirect to control panel
							window.location = 'admin.php?page=sp';							
						} else {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'error' );
						}
					} );
				}								
			} );

			/////////////////////////////////////////////////////
			// delete theme configuration settings
			/////////////////////////////////////////////////////
			$( '.sp-panel .delete-config' ).click( function() {

				var configName = $( this ).prevAll( 'select[name=delete_config]' ).val(),
					reply = confirm( sp_theme.delete_config_msg ),
					$data = {
						action: 'sp_delete_config_ajax',
						ajaxCustomNonce: sp_theme.ajaxCustomNonce,
						config_name: configName
					};

				// if confirmed
				if ( reply ) {	
					// show loading
					$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						if ( response === 'done') {
							// remove it from the dropdown
							$( '.sp-panel select[name=delete_config]' ).find( 'option[value=' + configName + ']' ).remove();
							$( '.sp-panel select[name=apply_config]' ).find( 'option[value=' + configName + ']' ).remove();

							// update the select2 plugin
							$( '.sp-panel select[name=delete_config]' ).trigger( 'change' );

							// update the select2 plugin
							$( '.sp-panel select[name=apply_config]' ).trigger( 'change' );

							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'done' );
							
						} else {
							// hide loading
							$.SPFrameWork.hideLoading( $( '.sp-panel .alert' ), 'error' );
						}
					} );
				}								
			} ); // delete theme config settings

			/////////////////////////////////////////////////////
			// display truncation settings
			/////////////////////////////////////////////////////
			$( '#excerpt-truncate' ).click( function() {
				$( '.truncate-settings-container' ).slideToggle( 'fast' );	
			} );

			/////////////////////////////////////////////////////
			// after panel save events
			/////////////////////////////////////////////////////
			$( '#sp-panel-form' ).on( 'after_save', function() {
				var status = $( 'input[name=maintenance_enable]', this ).filter( ':checked' ).val(),
					html = $( '<li id="wp-admin-bar-maintenance_mode" class="toolbar-maintenance-mode"><div class="ab-item ab-empty-item">' + sp_theme.maintenance_mode_msg + '</div></li>' ),
					toolbar = $( '#wp-admin-bar-top-secondary' );

				if ( status === 'on' ) {
					if ( toolbar.find( '.toolbar-maintenance-mode' ).length <= 0 ) {
						$( toolbar ).append( html );
					}
				} else {
					$( '#wp-admin-bar-maintenance_mode', toolbar ).remove();
				}
			} );	

			/////////////////////////////////////////////////////
			// contact form get field max id
			/////////////////////////////////////////////////////
			function contactFormGetFieldID() {
				var ids = [];
				
				$( '.contact-form-field-item' ).each( function() {
					ids.push( $( this ).attr( 'data-field-id' ) );
				} );

				return Math.max.apply( Math, ids );
			} // contact form

			/////////////////////////////////////////////////////
			// contact form add new field
			/////////////////////////////////////////////////////						
			$( '#contact-form-content' ).on( 'click', 'a.add-field', function( e ) {
				// prevent default behavior
				e.preventDefault();

				// stops bubbling
				e.stopPropagation();

				var sectionContainer = $( '#contact-form-content' ),
					fieldItem = sectionContainer.find( '.contact-form-field-item' ).eq( 0 );

				// first destroy select2 before cloning
				fieldItem.find( 'select.select2-select' ).select2( 'destroy' );

				var	cloned = fieldItem.clone( true );

				// reset selected to default
				cloned.find( 'select option:selected' ).removeAttr( 'selected' );

				// blank out input values
				cloned.find( 'input[type=text]' ).val( '' );

				// uncheck checkboxes
				cloned.find( 'input[type=checkbox]' ).removeAttr( 'checked' );	

				// set required to off
				cloned.find( '.hidden-required' ).val( 'off' );

				// remove all option rows
				cloned.find( '.option-row' ).remove();

				// remove all add option row
				cloned.find( '.add-option-row' ).remove();

				// append it to the container
				$( cloned ).appendTo( '.field-container' );

				// set the data field id
				$( cloned ).attr( 'data-field-id', ( parseInt( contactFormGetFieldID(), 10 ) + 1 ) );

				// reinit select2
				fieldItem.find( 'select.select2-select' ).select2( { width: 'element', minimumResultsForSearch: 20 } );
				cloned.find( 'select.select2-select' ).select2( { width: 'element', minimumResultsForSearch: 20 } );

				// show required fields
				cloned.find( 'input.field-label' ).show();
				cloned.find( 'input.required-cb' ).show();
				cloned.find( 'input.tag-name' ).show();								
			} ); // contact form

			/////////////////////////////////////////////////////
			// contact form remove field
			/////////////////////////////////////////////////////				
			$( '#contact-form-content' ).on( 'click', 'a.remove-field', function( e ) {
				// prevent default behavior
				e.preventDefault();

				// only remove if there are more than one
				if ( $( this ).parents( '#contact-form-content' ).find( '.contact-form-field-item' ).length > 1 ) {
					$( this ).parents( '.contact-form-field-item' ).remove();

					// renumerate ids
					var i = 1;
					$( '#contact-form-content' ).find( '.contact-form-field-item' ).each( function() {
						$( this ).attr( 'data-field-id', i );

						// check if option row is found
						if ( $( this ).find( 'ul.option-row' ).length ) {
							// loop through each option row
							$( this ).find( 'ul.option-row' ).each( function() {
								$( this ).find( 'input' ).attr( 'name', 'field_options[][field_' + i + '][]' );
							} );
						}

						i++;
					} );
				}
			} ); // contact form

			/////////////////////////////////////////////////////
			// contact form copy label name to unqiue tag name
			/////////////////////////////////////////////////////
			$( '#contact-form-content .field-label' ).each( function() {
				$( this ).on( 'blur', function() {
					var text = $( this ).val();

					// format text
					text = text.toLowerCase(); // makes all lowercase
					text = text.replace( /\s/g, '_' ); // replaces all spaces with underscores
					text = text.replace( /-/g, '_' ); // replaces all hyphens with underscores

					// if unique tag name is not already set
					if ( $( this ).parents( '.contact-form-field-item' ).find( '.tag-name' ).val() === '' ) {
						// add the text to the unique tag name
						$( this ).parents( '.contact-form-field-item' ).find( '.tag-name' ).val( text );		
					}			
				} );
			} ); // contact form

			/////////////////////////////////////////////////////
			// contact form live replace unique tag name with formatted one
			/////////////////////////////////////////////////////			
			$( '#contact-form-content .tag-name' ).each( function() {
				$( this ).on( 'blur', function() {
					var text = $( this ).val();

					// format text
					text = text.toLowerCase(); // makes all lowercase
					text = text.replace( /\s/g, '_' ); // replaces all spaces with underscores
					text = text.replace( /-/g, '_' ); // replaces all hyphens with underscores

					// set the text value
					$( this ).val( text );
				} );
			} ); // contact form

			/////////////////////////////////////////////////////
			// contact form update required hidden checkbox value
			/////////////////////////////////////////////////////
			function contactFormUpdateRequired() {
				$( '.contact-form-field-item' ).each( function() {
					$( this ).find( '.required-cb' ).on( 'click', function() {
						if ( $( this ).is( ':checked' ) ) {
							$( this ).next().val( 'on' );
						} else {
							$( this ).next().val( 'off' );
						}
					} );
				} );
			} // contact form
			contactFormUpdateRequired();

			/////////////////////////////////////////////////////
			// contact form radio remove options on click
			/////////////////////////////////////////////////////	
			function contactFormRemoveOption() {
				// remove all bindings first and rebind
				$( 'ul.option-row' ).off( 'click', '.remove-option' );

				$( 'ul.option-row' ).on( 'click', '.remove-option', function( e ) {
					// prevent default behavior
					e.preventDefault();

					// remove if there are more than one option row
					if ( $( this ).parents( '.contact-form-field-item' ).find( 'ul.option-row' ).length > 1 ) {
						$( this ).parents( 'ul.option-row' ).remove();					
					}
				} );
			} // contact form
			contactFormRemoveOption();

			/////////////////////////////////////////////////////
			// contact form radio add options on click
			/////////////////////////////////////////////////////	
			function contactFormAddOption() { 
				// remove all bindings first and rebind
				$( 'ul.add-option-row' ).off( 'click', '.add-option' );

				$( 'ul.add-option-row' ).on( 'click', '.add-option', function( e ) { 
					// prevent default behavior
					e.preventDefault();

					var addButton = $( this ),
						fieldID = addButton.parents( '.contact-form-field-item' ).attr( 'data-field-id' ),
						optionRow = $( '<ul class="option-row"><li><i class="icon-options-indicator" aria-hidden="true"></i> ' + sp_theme.contact_form_option_name + ' <input type="text" name="field_options[][field_' + fieldID + '][]" value="" /> <a href="#" class="remove-option button" title="' + sp_theme.contact_form_remove_option + '">' + sp_theme.contact_form_remove_option + '</a><i class="icon-reorder option-field-handle" aria-hidden="true"></i></li></ul>' );	

					// insert the new option row
					optionRow.insertAfter( addButton.parents( 'ul.add-option-row' ).prev( 'ul.option-row' ) );

					// run remove option event listener
					contactFormRemoveOption();	

					// show the options row if it is hidden
					if ( addButton.parents( '.contact-form-field-item' ).find( 'ul.option-row' ).is( ':hidden' ) ) {
						addButton.parents( '.contact-form-field-item' ).find( 'ul.option-row' ).show();
					}									
				} );					
			} // contact form
			contactFormAddOption();

			/////////////////////////////////////////////////////
			// contact form check for field type and display options
			/////////////////////////////////////////////////////	
			$( '#contact-form-content select.field-type' ).each( function() {			
				var select = $( this );

				select.on( 'change', function() {
					var selected = $( this ).val(),
						rowContainer = $( this ).parents( '.contact-form-field-item' ),
						fieldID = rowContainer.attr( 'data-field-id' );

					switch( selected ) {
						case 'radio' :
						case 'select' :
						case 'multiselect' :
							// remove all option fields first
							$( '.option-row', rowContainer ).remove();
							$( '.add-option-row', rowContainer ).remove();

							var optionRow = $( '<ul class="option-row"><li><i class="icon-options-indicator" aria-hidden="true"></i> ' + sp_theme.contact_form_option_name + ' <input type="text" name="field_options[][field_' + fieldID + '][]" value="" /> <a href="#" class="remove-option button" title="' + sp_theme.contact_form_remove_option + '">' + sp_theme.contact_form_remove_option + '</a><i class="handle" aria-hidden="true"></i></li></ul><ul class="add-option-row"><li><i class="icon-options-indicator" aria-hidden="true"></i> <a href="#" class="add-option button" title="' + sp_theme.contact_form_add_option + '">' + sp_theme.contact_form_add_option + '</a><a href="#" class="toggle-options button" title="' + sp_theme.contact_form_toggle_options + '">' + sp_theme.contact_form_toggle_options + '</a></li></ul>' );	

							optionRow.appendTo( rowContainer );

							// run add option event listener
							contactFormAddOption();

							// get the count of the option rows
							var optionRowCount = $( this ).parents( '.contact-form-field-item' ).find( 'ul.option-row' ).length;
							
							// run remove option event listener
							optionRow.find( '.remove-option' ).on( 'click', function( e ) {
								// prevent default behavior
								e.preventDefault();

								// remove if there are more than one option row
								if ( optionRowCount > 1 ) {
									$( this ).parents( 'ul.option-row' ).remove();
								}
							} );

							// set the count of options field to 1 initially
							rowContainer.find( 'input.field-options-count' ).val( '1' );

							// show the options row if it is hidden
							if ( rowContainer.find( 'ul.option-row' ).is( ':hidden' ) ) {
								rowContainer.find( 'ul.option-row' ).show();
							}

							// show required fields
							rowContainer.find( 'input.field-label' ).show();
							rowContainer.find( 'input.required-cb' ).show();
							rowContainer.find( 'input.tag-name' ).show();

							// make sortable
							runOptionSortable();
							break;

						case 'text' :
						case 'email' :
						case 'textarea' :
						case 'checkbox' :
						case 'captcha' :
							// remove all option fields first
							$( '.option-row', rowContainer ).remove();
							$( '.add-option-row', rowContainer ).remove();
							
							rowContainer.find( 'input.hidden-required' ).val( 'on' );
							rowContainer.find( 'input.required-cb' ).hide();
							break;
							
						case 'datepicker' :
						case 'datetimepicker' :
							// remove all option fields
							$( '.option-row', rowContainer ).remove();
							$( '.add-option-row', rowContainer ).remove();

							// show required fields
							rowContainer.find( 'input.field-label' ).show();
							rowContainer.find( 'input.required-cb' ).show();
							rowContainer.find( 'input.tag-name' ).show();
							break;

						case 'separator' :
							// remove all option fields
							$( '.option-row', rowContainer ).remove();
							$( '.add-option-row', rowContainer ).remove();

							// hide non required fields
							rowContainer.find( 'input.field-label' ).hide();
							rowContainer.find( 'input.required-cb' ).hide();
							rowContainer.find( 'input.tag-name' ).hide();							
							break;						
						case 'heading' :
							// remove all option fields
							$( '.option-row', rowContainer ).remove();
							$( '.add-option-row', rowContainer ).remove();

							// show required fields
							rowContainer.find( 'input.field-label' ).show();

							// hide non required fields
							rowContainer.find( 'input.required-cb' ).hide();
							rowContainer.find( 'input.tag-name' ).hide();							
							break;
					}
				} );
			} ); // contact form

			/////////////////////////////////////////////////////
			// contact form field row sortable
			/////////////////////////////////////////////////////
			// check if sortable function exists	
			if ( $.fn.sortable ) {
				$( '#contact-form-content' ).sortable( {
					items: '.contact-form-field-item',
					cursor: 'move',
					handle: '.form-field-handle',
					placeholder: 'cf-sortable-placeholder',
					update: function() {
						// renumerate ids
						var i = 1;
						$( '#contact-form-content' ).find( '.contact-form-field-item' ).each( function() {
							$( this ).attr( 'data-field-id', i );

							// check if option row is found
							if ( $( this ).find( 'ul.option-row' ).length ) {
								// loop through each option row
								$( this ).find( 'ul.option-row' ).each( function() {
									$( this ).find( 'input' ).attr( 'name', 'field_options[][field_' + i + '][]' );
								} );
							}

							i++;
						} );					
					}
				} );
			} // contact form

			/////////////////////////////////////////////////////
			// contact form option row sortable
			/////////////////////////////////////////////////////
			function runOptionSortable() {
				// check if sortable function existsz
				if ( $.fn.sortable ) {
					$( '.contact-form-field-item' ).sortable( {
						items: 'ul.option-row',
						cursor: 'move',
						placeholder: 'cf-or-sortable-placeholder',
						handle: '.option-field-handle'
					} );
				}
			} // contact form
			runOptionSortable();

			/////////////////////////////////////////////////////
			// contact form toggle options hide/show
			/////////////////////////////////////////////////////			
			$( '.contact-form-field-item' ).on( 'click', '.toggle-options', function( e ) {
				// prevent default behavior
				e.preventDefault();

				if ( $( this ).parents( '.contact-form-field-item' ).find( 'ul.option-row' ).is( ':visible' ) ) {
					$( this ).parents( '.contact-form-field-item' ).find( 'ul.option-row' ).hide();
				} else {
					$( this ).parents( '.contact-form-field-item' ).find( 'ul.option-row' ).show();
				}
			} ); // contact form

			/////////////////////////////////////////////////////
			// contact form populate template button
			/////////////////////////////////////////////////////			
			$( '#contact-form-messages a.populate-template' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();
				e.stopPropagation();

				var template = '',
					templateContainer = $( this ).parents( '#contact-form-messages' );

				// grab the fields from content
				$( '#contact-form-content .contact-form-field-item' ).each( function() {
					// skip separators and headings
					if ( $( this ).find( 'select.field-type' ).val() !== 'heading' && $( this ).find( 'select.field-type' ).val() !== 'separator' && $( this ).find( 'select.field-type' ).val() !== 'captcha' ) {
						template += $( this ).find( 'input.field-label' ).val() + ':' + '\r\n';
						template += '[' + $( this ).find( 'input.tag-name' ).val() + ']' + '\r\n\r\n';
					}
				} );

				// replace the template with content
				templateContainer.find( 'textarea[name=contact_form_email_template]' ).val( template );
			} ); // contact form

			/////////////////////////////////////////////////////
			// page builder switcher button
			/////////////////////////////////////////////////////
			$( '#poststuff' ).on( 'click', '.page-builder-switcher', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var thisButton = $( this );

				// switching to advanced page builder
				if ( thisButton.is( '.default' ) ) {
					// change the title of the button
					thisButton.attr( 'title', sp_theme.page_builder_switcher_default_text ).html( sp_theme.page_builder_switcher_default_text ).removeClass( 'default' ).addClass( 'advanced' );

					// change the editor type value to be saved
					thisButton.siblings( 'input[name="sp_editor_type"]' ).val( 'advanced' );

					// hide the current default editor
					$( '#postdivrich' ).fadeOut( 'fast' );

					// show the advanced page builder
					$( '#page-builder' ).fadeIn( 'fast' );

					// hide custom sidebar layout
					$( '#sp_page_layout' ).hide();
				} else {
					// change the title of the button
					thisButton.attr( 'title', sp_theme.page_builder_switcher_advanced_text ).html( sp_theme.page_builder_switcher_advanced_text ).removeClass( 'advanced' ).addClass( 'default' );

					// change the editor type value to be saved
					thisButton.siblings( 'input[name="sp_editor_type"]' ).val( 'default' );

					// hide the current advanced editor
					$( '#page-builder' ).fadeOut( 'fast' );

					// show the default editor
					$( '#postdivrich' ).fadeIn( 'fast' );

					// show custom sidebar layout
					$( '#sp_page_layout' ).show();				
				}
			} );
			
			// on load checks if page is default editor or page builder and hide layout
			if ( $( '#poststuff' ).find( '.page-builder-switcher' ).is( '.default' ) ) {
					// show custom sidebar layout
					$( '#sp_page_layout' ).show();				
			} else {
					// hide custom sidebar layout
					$( '#sp_page_layout' ).hide();
			}

			/////////////////////////////////////////////////////
			// editor type on load
			/////////////////////////////////////////////////////
			// on page load, check editor type and switch accordingly
			if ( $( 'input[name="sp_editor_type"]' ).length ) {
				var editor_type = $( 'input[name="sp_editor_type"]' ).val();

				if ( editor_type === 'advanced' ) {
					$( '#postdivrich' ).hide();
					$( '#page-builder' ).show();
				} else {
					$( '#postdivrich' ).show();
					$( '#page-builder' ).hide();					
				}
			}

			/////////////////////////////////////////////////////
			// page builder clears settings container
			/////////////////////////////////////////////////////
			function pageBuilderClearSettings() {
				$( '.page-builder-section .settings-container .settings' ).html( '' );
				$( '.page-builder-section .settings-container' ).slideUp( 'fast' );
			}

			/////////////////////////////////////////////////////
			// page builder re order modules function
			// this runs each time there is a change in the modules
			// being added, deleted, change of order...etc
			/////////////////////////////////////////////////////
			function pageBuilderModuleReorder() {
				$( '.page-builder-section' ).each( function() {
					var rowCount = 1,
						rowColCount = 0;

					// rows
					$( '.rows-wrapper .row-container', this ).each( function( row ) { 
						var row_width_name = String( $( 'p.row-width input', this ).attr( 'name' ) ),
							replacedName = row_width_name.replace( /\[row\]\[\d+\]|\[row\]\[\]/, '[row][' + row + ']' );

						$( 'p.row-width input', this ).attr( 'name', replacedName );

						var row_status_name = String( $( 'p.row-status input', this ).attr( 'name' ) ),
							replacedStatusName = row_status_name.replace( /\[row\]\[\d+\]|\[row\]\[\]/, '[row][' + row + ']' );

						$( 'p.row-status input', this ).attr( 'name', replacedStatusName );

						$( '.pb-row-columns', this ).prop( 'name', 'pb[row][' + rowColCount + '][row_column_class]' );

						var colCount = 1;

						// columns
						$( '.columns-wrapper .column', this ).each( function( column ) {

							$( '.module-element', this ).each( function( module ) {

								$( '.module-value', this ).each( function() {

									var name = String( $( this ).attr( 'name' ) ),
										replacedRow = name.replace( /\[row\]\[\d+\]|\[row\]\[\]/, '[row][' + row + ']' ),
										replacedColumn = replacedRow.replace( /\[column\]\[\d+\]|\[column\]\[\]/, '[column][' + column + ']' ),
										newValue = replacedColumn.replace( /\[module\]\[\d+\]|\[module\]\[\]/, '[module][' + module + ']' );

									$( this ).attr( 'name', newValue );

									// update widget module value
									if ( $( this ).data( 'module' ) === 'widget_area' ) {
										var pageID = $( this ).data( 'page-id' ),
											pageName = $( this ).data( 'page-name' );

										$( this ).val( pageName + '(' + pageID + ') Row(' + rowCount + ') Col(' + colCount + ')' );
									}
								} );
							} );

							// update column count
							$( this ).find( 'h3.column-heading .col-count' ).html( colCount );

							colCount++;						
						} );

						// update row count
						$( this ).find( 'h3.row-heading .row-count' ).html( rowCount );

						rowCount++;
						rowColCount++;
					} );
				} );
			}
			pageBuilderModuleReorder();

			/////////////////////////////////////////////////////
			// page builder row sortable function
			/////////////////////////////////////////////////////
			function pageBuilderRunRowSortable() {
				if ( $.fn.sortable ) {
					$( '.page-builder-section' ).each( function() {
						var thisRow = $( this ).find( '.rows-wrapper' );

						thisRow.sortable( {
							items: $( '.row-container', thisRow ),
							placeholder: 'sortable-placeholder',
							handle: '.reorder-row',
							update: function() {
								pageBuilderModuleReorder();

								pageBuilderClearSettings();
							}
						} );						
					} ); // page builder module list sortable
				}
			}
			pageBuilderRunRowSortable();

			/////////////////////////////////////////////////////
			// page builder module sortable function
			/////////////////////////////////////////////////////
			function pageBuilderRunModuleSortable() {
				if ( $.fn.sortable ) {
					$( '.page-builder-section' ).each( function() {
						var thisModuleElement = $( this ).find( '.column .inner' );

						thisModuleElement.sortable( {
							items: $( '.module-element', thisModuleElement ),
							connectWith: '.column .inner',
							placeholder: 'sortable-placeholder',
							distance: 20,
							update: function() {
								pageBuilderModuleReorder();

								pageBuilderClearSettings();
							}
						} );						
					} ); // page builder module list sortable
				}
			}
			pageBuilderRunModuleSortable();

			/////////////////////////////////////////////////////
			// page builder droppable function
			/////////////////////////////////////////////////////
			function pageBuilderRunDroppable() {
				var postID = $( 'input[name=post_id]' ).val();

				if ( $.fn.droppable ) {
					$( '.page-builder-section' ).each( function() {
						$( this ).find( '.column .inner' ).each( function() {
							var thisColumn = $( this );

							thisColumn.droppable( {
								accept: '.module',
								activeClass: 'ui-state-highlight',
								tolerance: 'touch',
								drop: function( event, ui ) {
									var module = ui.draggable.attr( 'data-id' ),
										data = {
											action: 'sp_page_builder_get_module_ajax',
											ajaxCustomNonce: sp_theme.ajaxCustomNonce,
											module: module,
											post_id: postID
										};

									$.post( sp_theme.ajaxurl, data, function( response ) {
										thisColumn.append( response );

										pageBuilderRunModuleSortable();

										pageBuilderModuleReorder();

										pageBuilderClearSettings();
									} );
								}
							} );						
						} );
					} ); // page builder module draggable
				}
			}
			pageBuilderRunDroppable();

			/////////////////////////////////////////////////////
			// page builder module draggable
			/////////////////////////////////////////////////////
			function pageBuilderRunModuleDraggable() {
				if ( $.fn.draggable ) {
					$( '.page-builder-section .rows-wrapper' ).each( function() {
						$( this ).find( '.module' ).draggable( {
							helper: 'clone'
						} );
					} ); // page builder module draggable
				}
			}
			pageBuilderRunModuleDraggable();

			/////////////////////////////////////////////////////
			// page builder collapse rows
			/////////////////////////////////////////////////////
			$( '.page-builder-section' ).on( 'click', 'a.collapse-rows', function( e ) {
				// prevent default behavior
				e.preventDefault();

				$( this ).parents( '.page-builder-section' ).find( '.row-container' ).each( function() {

					var rowContainer = $( this ),
						rowInner = rowContainer.find( '.row-inner' );

						rowInner.slideUp( 'fast' );

						rowContainer.addClass( 'collapsed' ).removeClass( 'expanded' ).find( 'a.collapse-row i' ).attr( 'class', 'icon-caret-up' );		
				});
			});

			/////////////////////////////////////////////////////
			// page builder add rows
			/////////////////////////////////////////////////////
			$( '.page-builder-section' ).on( 'click', 'a.add-row', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var rowWrapper = $( this ).parents( '.page-builder-section' ).find( '.rows-wrapper' ),
					clonedRow = $( '.row-container', rowWrapper ).eq( 0 ).clone(),
					rowWidthName = String( clonedRow.find( 'p.row-width input' ).attr( 'name' ) ),
					replacedName = rowWidthName.replace( /\[row\]\[\d+\]|\[row\]\[\]/, '[row][1000]' ),
					rowStatusName = String( clonedRow.find( 'p.row-status input' ).attr( 'name' ) ),
					replacedStatusName = rowStatusName.replace( /\[row\]\[\d+\]|\[row\]\[\]/, '[row][1000]' );					

				// change the row_width name temporarily on clone
				clonedRow.find( 'p.row-width input' ).attr( 'name', replacedName );

				// change the row_status name temporarily on clone
				clonedRow.find( 'p.row-status input' ).attr( 'name', replacedStatusName );

				// remove columns from the cloned row
				clonedRow.find( '.columns-wrapper' ).html( '' );

				// remove layout active from column layout
				clonedRow.find( '.column-layout a.active' ).removeClass( 'active' );

				rowWrapper.append( clonedRow );

				// scroll to location after adding row
				$( 'html, body' ).animate({
					scrollTop: $( clonedRow ).offset().top - 30
				}, 2000 );

				// select defaults for row width and row status
				clonedRow.find( 'p.row-width input' ).eq( 1 ).prop( 'checked', true );
				clonedRow.find( 'p.row-status input' ).eq( 0 ).prop( 'checked', true );

				pageBuilderRunRowSortable();

				pageBuilderRunModuleDraggable();
				
				pageBuilderClearSettings();

				pageBuilderModuleReorder();

				$.SPFrameWork.startToolTip();								
			} );

			/////////////////////////////////////////////////////
			// page builder remove row
			/////////////////////////////////////////////////////
			$( '.page-builder-section' ).on( 'click', 'a.remove-row', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var rowWrapper = $( this ).parents( '.page-builder-section' ).find( '.rows-wrapper' ),
					row = $( this ).parents( '.row-container' );

				// leave at least one row
				if ( $( '.row-container', rowWrapper ).length === 1 ) {
					return;
				}

				// check if row is empty
				if ( $( '.column .inner .module-element', row ).length === 0 ) {
					// remove the current row
					row.remove();
			
				} else {
					// ask to confirm before removing row
					var proceed = confirm( sp_theme.page_builder_remove_row );

					if ( proceed ) {
						// remove the current column
						row.remove();							
					}
				}

				pageBuilderModuleReorder();

				// clear out settings
				pageBuilderClearSettings();	
														
			} );

			/////////////////////////////////////////////////////
			// page builder collapse row
			/////////////////////////////////////////////////////
			$( '.page-builder-section' ).on( 'click', 'a.collapse-row', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var rowContainer = $( this ).parents( '.row-container' ),
					rowInner = rowContainer.find( '.row-inner' );

				if ( rowInner.is( ':visible' ) ) {
					rowInner.slideUp( 'fast' );

					$( this ).addClass( 'collapsed' ).removeClass( 'expanded' ).find( 'i' ).attr( 'class', 'icon-caret-up' );
				} else {
					rowInner.slideDown( 'fast' );

					$( this ).addClass( 'expanded' ).removeClass( 'collapsed' ).find( 'i' ).attr( 'class', 'icon-caret-down' );
				}
			} );

			/////////////////////////////////////////////////////
			// page builder change columns
			/////////////////////////////////////////////////////
			$( '.page-builder-section' ).on( 'click', 'a.one, a.two, a.three, a.four, a.five, a.six, a.two-third, a.one-third, a.two-sidebars, a.one-fourth, a.three-fourth', function( e ) {
				// prevent default behavior
				e.preventDefault();

				// remove all active states
				$( this ).parents( '.column-layout' ).find( 'a' ).removeClass( 'active' );

				var rowInner = $( this ).parents( '.row-inner' ),
					columnsWrapper = $( '.columns-wrapper', rowInner ),
					columnHTML = $( '<div class="column"><h3 class="column-heading">' + sp_theme.page_builder_column_heading_text + ' <span class="col-count"></span></h3><div class="inner"><div class="module-element column-placeholder"><div class="module-values"><input type="hidden" name="pb[row][][column][][module][0][placeholder]" class="module-value" value="hold" /></div></div></div></div>' ),
					columnType = $( this ).data( 'column' ),
					rowContainer = $( this ).parents( '.row-container' ),
					modules = '',
					columnCount,
					columnNumber;

				// set the column class
				rowContainer.find( 'input.pb-row-columns' ).val( columnType );

				switch( columnType ) {
					case 'one' :
						columnNumber = 1;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;
					case 'two' :
						columnNumber = 2;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;
					case 'three' :
						columnNumber = 3;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;
					case 'four' :
						columnNumber = 4;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;
					case 'five' :
						columnNumber = 5;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;
					case 'six' :
						columnNumber = 6;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;		
					case 'one-third' :
						columnNumber = 2;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;		
					case 'two-third' :
						columnNumber = 2;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;	
					case 'two-sidebars' :
						columnNumber = 3;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;	
					case 'one-fourth' :
						columnNumber = 2;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;	
					case 'three-fourth' :
						columnNumber = 2;
						columnCount = Math.abs( columnNumber - columnsWrapper.find( '.column' ).length );

						break;				
				}	

				// if no columns exists
				if ( rowInner.find( '.columns-wrapper .column' ).length < 1 ) {
					// append column
					for ( var i = 1; i <= columnNumber; i++ ) {								
						columnsWrapper.append( columnHTML.clone().addClass( columnType ) );
					}				
				} else {

					if ( columnsWrapper.find( '.column' ).length < columnNumber ) { 
						// append column
						for ( var c = 1; c <= columnCount; c++ ) {
							columnsWrapper.append( columnHTML.clone() );
						}

						columnsWrapper.find( '.column' ).prop( 'class', 'column ' + columnType );						

					} else if ( columnsWrapper.find( '.column' ).length > columnNumber ) {
						// loop through each column
						$( '.column:gt(' + ( columnNumber - 1 ) + ')', columnsWrapper ).each( function() {
							
							$( '.inner .module-element', this ).not( '.module-element.column-placeholder' ).each( function() {
								var dataID = $( this ).prop( 'data-id' );
								modules += '<div class="module-element" data-id="' + dataID + '">' + $( this ).html() + '</div>';
							} );
							
							// remove the column
							$( this ).remove();
						} );

						$( '.column', columnsWrapper ).last().find( '.inner' ).append( modules );
						$( '.column', columnsWrapper ).prop( 'class', 'column ' + columnType );
					} else {
						$( '.column', columnsWrapper ).last().find( '.inner' ).append( modules );
						$( '.column', columnsWrapper ).prop( 'class', 'column ' + columnType );
					}
				}

				// add the active class on currently clicked item
				$( this ).addClass( 'active' );

				pageBuilderRunDroppable();	

				pageBuilderModuleReorder();

				pageBuilderRunModuleSortable();

				pageBuilderClearSettings();											
			} );

			/////////////////////////////////////////////////////
			// page builder delete module
			/////////////////////////////////////////////////////
			$( '.page-builder-section' ).on( 'click', 'a.module-element-delete', function( e ) {
				// prevent default behavior
				e.preventDefault();

				$( this ).parents( '.module-element' ).remove();

				pageBuilderModuleReorder();

				pageBuilderClearSettings();
			} );

			/////////////////////////////////////////////////////
			// page builder edit module
			/////////////////////////////////////////////////////
			$( '.page-builder-section' ).on( 'click', 'a.module-element-edit', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var moduleElement = $( this ).parents( '.module-element' ),
					moduleValues = $( '.module-values', moduleElement ),
					dataID = moduleElement.data( 'id' ),
					//mceID = moduleElement.data( 'mce-id' ),
					toggleButton = $( '<a href="#" class="toggle-options button" title="' + sp_theme.shortcodes_more_options_button_text + '">' + sp_theme.shortcodes_more_options_button_text + '</a>' ),
					closeButton = $( '<a href="#" class="close-page-builder-modal button button-primary" title="' + sp_theme.page_builder_settings_done_text + '">' + sp_theme.page_builder_settings_done_text + '</a>' ),
					textAreaContent = moduleElement.find( '.pb-textarea' ).val();

				// hide optional settings on load
				moduleValues.find( 'div.optional' ).hide();

				// grab wp editor
				if ( dataID === 'custom_content' ) {
					var	$data = {
							action: 'sp_page_builder_content_tinymce_ajax',
							ajaxCustomNonce: sp_theme.ajaxCustomNonce,
							content: textAreaContent
						};

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						moduleValues = response;

						$.SPFrameWork.popup( moduleElement, moduleValues );
						$.SPFrameWork.reinitMCE();				
					} );				
				} else {

					$.magnificPopup.open( {
						items: {
							src: moduleValues,
						},
						type: 'inline',
						removalDelay: 300,
						mainClass: 'page-builder-modal',
						closeMarkup: '<button title="' + sp_theme.page_builder_settings_done_text + '" class="mfp-close button button-primary">' + sp_theme.page_builder_settings_done_text + '</button>',
						closeOnContentClick: false,
						modal: true,
						callbacks: {
							open: function() {
								if ( dataID !== 'custom_content' && moduleValues.find( 'div.optional' ).length ) {
									$( '.page-builder-modal .mfp-content' ).append( toggleButton );
								}

								$( '.page-builder-modal .mfp-content' ).append( closeButton );

								/////////////////////////////////////////////////////
								// page builder more options
								/////////////////////////////////////////////////////
								$( '.page-builder-modal' ).on( 'click', 'a.toggle-options', function( e ) {
									// prevent default behavior
									e.preventDefault();

									var button = $( this ),
										container = $( this ).parents( '.page-builder-modal' );

									container.find( 'div.optional' ).slideToggle( 300 );

									button.text( function( i, text ) {
										return text === sp_theme.shortcodes_more_options_button_text ? sp_theme.shortcodes_less_options_button_text : sp_theme.shortcodes_more_options_button_text;
									} );							
								} );

								// closes the modal
								$( '.page-builder-modal' ).on( 'click', 'a.close-page-builder-modal', function( e ) {
									// prevent default behavior
									e.preventDefault();

									$.magnificPopup.close();
								} );
							},

							close: function() {
								// remove the event to prevent propagation
								$( '.page-builder-modal' ).off( 'click', 'a.toggle-options' );
							}
						}
					}, 0 );
				}
			} );	

			/////////////////////////////////////////////////////
			// page builder shortcode button
			/////////////////////////////////////////////////////
			$( '.page-builder-section' ).on( 'click', 'span.page-builder-shortcode-button', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var shortcodeContainer = $( this ).next( '.page-builder-shortcode-list' ),
					contentArea = $( this ).parents( '.module-values' ).find( '.content-area' );

				if ( shortcodeContainer.is( ':visible' ) ) { 
					shortcodeContainer.stop( true, true ).slideUp( 'fast' );
				} else {
					shortcodeContainer.stop( true, true ).slideDown( 'fast' );

					shortcodeContainer.on( 'click', 'a', function( e ) {
						// prevent default behavior
						e.preventDefault();						

						// close any opened dialog first
						$( '.shortcodes-module-container' ).each( function() { 
							$( this ).dialog( 'close' );
						} );

						var	module = $( this ).data( 'id' ),
							title = $( this ).prop( 'title' ),
							data = {
								action: 'sp_shortcode_input_form_ajax',
								ajaxCustomNonce: sp_theme.ajaxCustomNonce,
								module: module
							},
							shortcodesModule = $.parseJSON( sp_theme.shortcodes_module ),
							content,
							originalValues = [],
							originalRadioValues = [];

						$.post( sp_theme.ajaxurl, data, function( response ) {
							response = $.parseJSON( response );

							content = $( '<div class="shortcodes-module-container" data-id="' + module + '">' + response.form + '<button class="button button-primary add-shortcode">' + sp_theme.shortcodes_add_shortcode_button_text + '</button><button class="toggle-options button">' + sp_theme.shortcodes_more_options_button_text + '</button></div>' );
							
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
								title: title,
								width: 600,
								height: 'auto',
								close: function() {
									content.remove();	
								},
								open: function() {
									// sets the scrollbar back up at the top
									$( '.shortcodes-module-container' ).scrollTop( 0 );
								}
							} );

							// open the dialog
							$( '.shortcodes-module-container' ).dialog( 'open' );

							// get original values
							$( 'input[type=text], textarea, select', content ).not( 'textarea[name="inner_wrap_content"]' ).each( function() {
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

								shortcode = '[' + shortcodesModule[module].shortcode_name;

								// loop through input fields
								$( 'input[type=text], textarea, select', container ).not( 'textarea[name="inner_wrap_content"]' ).each( function( index ) {
									// check if any changes to the value
									if ( $( this ).val() !== originalValues[index] ) {
										shortcode += ' ' + $( this ).prop( 'name' ) + '="' + $( this ).val() + '"';
									}
								} );

								// loop through input radio fields
								$( 'input[type=radio]:checked', container ).each( function( index ) {
									// check if optional is displayed
									if ( $( this ).val() !== originalRadioValues[index] ) {							
										shortcode += ' ' + $( this ).prop( 'name' ) + '="' + $( this ).val() + '"';
									}
								} );

								shortcode += ']';

								// check if there needs to be a wrapping container
								if ( module === 'tabs' ) {
									shortcode += '[sp-tab-content tab=""]' + sp_theme.shortcodes_tinymce_shortcode_content_msg + '[/sp-tab-content][/' + shortcodesModule[module].shortcode_name + ']';
								}

								if ( module === 'accordion' ) {
									shortcode += '[sp-accordion-content]' + sp_theme.shortcodes_tinymce_shortcode_content_msg + '[/sp-accordion-content][/' + shortcodesModule[module].shortcode_name + ']';
								}

								if ( $( 'textarea[name="inner_wrap_content"]', container ).length && $( 'textarea[name="inner_wrap_content"]', container ).val().length > 0 ) {
									shortcode += $( 'textarea[name="inner_wrap_content"]', container ).val() + '[/' + shortcodesModule[module].shortcode_name + ']';
								}

								contentArea.val( contentArea.val() + shortcode ).trigger( 'keyup' );

								// close the dialog
								$( '.shortcodes-module-container' ).dialog( 'close' );						
							} );

							$( '.shortcodes-module-container' ).on( 'click', '.toggle-options', function( e ) {
								// prevent default behavior
								e.preventDefault();

								var button = $( this ),
									container = $( this ).parents( '.shortcodes-module-container' );

								container.find( 'div.optional' ).slideToggle( 300, function() {
									button.text( function( i, text ) {
										return text === sp_theme.shortcodes_more_options_button_text ? sp_theme.shortcodes_less_options_button_text : sp_theme.shortcodes_more_options_button_text;
									} );
								} );
							} );
						} );
					} );
				}
			} ); // page builder shortcode

			/////////////////////////////////////////////////////
			// page builder custom content media upload
			/////////////////////////////////////////////////////
			var customContentMediaFrame;

			$( '.page-builder-section' ).on( 'click', '.pb-custom-content-media-upload', function( e ) { 
				// prevent default behavior
				e.preventDefault();

				var thisValues = $( this ).parents( '.module-values' ),
					thisContent = thisValues.find( '.content-area' );

				// Create the media frame.
				customContentMediaFrame = wp.media.frames.customContentMediaFrame = wp.media( {

					title: $( this ).data( 'uploader_title' ),

					button: {
						text: $( this ).data( 'uploader_button_text' )
					},

					multiple: false
				} );

				// after a file has been selected
				customContentMediaFrame.on( 'select', function() {
					// get all files selected
					var attachment = customContentMediaFrame.state().get( 'selection' ).toJSON(); 

					$( attachment ).each( function() {
						var img = '<img src="' + this.url + '" alt="' + this.alt + '" width="' + this.width + '" height="' + this.height + '" />';

						thisContent.html( thisContent.html() + ' ' + img ).trigger( 'keyup' );
						thisContent.val( thisContent.val() + ' ' + img ).trigger( 'keyup' );
					} );
				} );

				// open the modal frame
				customContentMediaFrame.open();
			} );	

			/////////////////////////////////////////////////////
			// alternate product image media upload
			/////////////////////////////////////////////////////
			$( '#sp_alternate_product_image' ).on( 'click', '.alternate-product-image-media-upload', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var container = $( this ).parents( '#sp_alternate_product_image' );

				// Create the media frame.
				customContentMediaFrame = wp.media.frames.customContentMediaFrame = wp.media( {
					multiple: false,

					// Tell the modal to show only images.
					library: {
						type: 'image'
					}
				} );

				// after a file has been selected
				customContentMediaFrame.on( 'select', function() {
					// get all files selected
					var attachment = customContentMediaFrame.state().get( 'selection' ).toJSON(); 

					$( attachment ).each( function() {
						var previewImg = '<img src="' + this.sizes.thumbnail.url + '" width="' + this.sizes.thumbnail.width + '" height="' + this.sizes.thumbnail.height + '" />',
							attachmentID = this.id,
							replaceContainer = container.find( 'p.hide-if-no-js' ).eq( 0 );

						// set the value
						container.find( '#alternate-product-image' ).val( attachmentID );

						replaceContainer.html( '<a href="#" class="alternate-product-image-media-upload">' + previewImg + '</a>' );

						container.find( 'p.hide-if-no-js' ).eq( 1 ).remove();

						replaceContainer.after( '<p class="hide-if-no-js"><a href="#" class="remove-alternate-product-image">' + sp_theme.remove_alternate_product_image_text + '</a></p>' );
					} );
				} );

				// open the modal frame
				customContentMediaFrame.open();				
			} );

			/////////////////////////////////////////////////////
			// alternate product image remove
			/////////////////////////////////////////////////////
			$( '#sp_alternate_product_image' ).on( 'click', '.remove-alternate-product-image', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var container = $( this ).parents( '#sp_alternate_product_image' ),
					setImage = $( '<a href="#" class="alternate-product-image-media-upload">' + sp_theme.set_alternate_product_image_text + '</a>' );

				container.find( 'p.hide-if-no-js' ).eq( 0 ).remove();
				container.find( 'p.hide-if-no-js' ).html( setImage );
				container.find( '#alternate-product-image' ).val( '' );
			} );

			/////////////////////////////////////////////////////
			// install sample data
			/////////////////////////////////////////////////////			
			$( '.sp-panel .install-sample-data' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				if ( confirm( sp_theme.confirm_install_sample_data_msg ) ) {
					var $data = {
						action: 'sp_install_sample_data_ajax',
						ajaxCustomNonce:sp_theme.ajaxCustomNonce
					};

					$.SPFrameWork.showLoading( $( '.sp-panel .alert' ) );

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						if ( response ) {
							window.location = 'admin.php?page=sp';
						}					
					} );
				}
			} );
		},  // close init

		startSelect2: function() {
			// check if select2 function exists
			if ( $.fn.select2 ) {			
				$( '.select2-select' ).select2( {
					width: 'element',
					minimumResultsForSearch: 20
				} );
			}
		},

		wooCommerce: function() {
			function refreshTabs() {
				var productTabContainer = $( '.product-tab-container' );

				if ( productTabContainer.data( 'ui-tabs' ) ) {
					productTabContainer.tabs( 'refresh' );
				} else {
					productTabContainer.tabs( { 
						heightStyle: 'content'
					} );
				}

				// if no more items, destroy tabs
				if ( productTabContainer.find( 'li' ).length <= 0 ) {
					$( productTabContainer ).tabs( 'destroy' );
				}
			}

			function reinitTabs() {
				var productTabContainer = $( '.product-tab-container' ),
					i = 1;

				// loop through tab title and set proper id
				productTabContainer.find( 'li.tab' ).each( function() {
					var tabLink = $( '.tab-title', this );

					tabLink.attr( 'href', '#tabs-' + i );

					i++;
				} );

				// reset counter
				i = 1;

				// loop through tab content and set proper id
				productTabContainer.find( '.tab-content' ).each( function() {
					var tabContent = $( this );

					tabContent.attr( 'id', 'tabs-' + i );

					i++;
				} );

				refreshTabs();
			}

			// product custom tabs
			$( '.product-tab-container' ).each( function() {
				$( this ).tabs( {
					heightStyle: 'content'
				} );
			} );

			// add tab button
			$( '#sp_custom_product_tabs' ).on( 'click', '.add-tab', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var productTabContainer = $( '.product-tab-container' ),
					$data = {
						action: 'sp_add_custom_product_tab_ajax',
						ajaxCustomNonce:sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					response = $.parseJSON( response );

					productTabContainer.find( 'ul.tab-list' ).append( response.tab );

					productTabContainer.append( response.editor ).show();

					$.SPFrameWork.newMCE( response.mce_id );

					reinitTabs();

					// show first tab if only 1 tab
					if ( productTabContainer.find( 'ul.tab-list li' ).length === 1 ) {
						productTabContainer.find( 'ul.tab-list li a.tab-title' ).eq( 0 ).trigger( 'click' );
					} else {
						// show the newly created tab
						productTabContainer.find( 'ul.tab-list li:last a.tab-title' ).trigger( 'click' );
					}				
				} );
			} );

			// remove tab button
			$( '#sp_custom_product_tabs' ).on( 'click', '.remove-tab', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var productTabContainer = $( '.product-tab-container' ),
					tabID = $( this ).parent( 'li.tab' ).find( '.tab-title' ).attr( 'href' );

				// remove the tab
				$( this ).parent( 'li.tab' ).remove();

				// remove the tab content
				productTabContainer.find( tabID ).remove();

				reinitTabs();
			} );

			// edit tab title
			$( '#sp_custom_product_tabs' ).on( 'dblclick', '.tab-title', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var link = $( this ),
					input = link.siblings( 'span.edit-title' ),
					newTitle = prompt( sp_theme.custom_product_tabs_title_text, '' );

				if ( newTitle ) {
					// update the input field value
					input.find( '.tab-name' ).val( newTitle );
					link.html( newTitle );

					reinitTabs();
				}
			} );	
		},

		startToolTip: function() {
			$( '.sp-tooltip' ).tooltip( { container: 'body' } );
		}
	}; // close namespace
	
	$.SPFrameWork.init();
	$.SPFrameWork.startSelect2();
	$.SPFrameWork.textSizeSlider();
	$.SPFrameWork.wooCommerce();
	$.SPFrameWork.startToolTip();
// end document ready
} );