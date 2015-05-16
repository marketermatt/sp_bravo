// @codekit-prepend "easing.js"
// @codekit-prepend "magnificpopup.js"
// @codekit-prepend "touchswipe.js"
// @codekit-prepend "fitvids.js"
// @codekit-prepend "bxslider.js"
// @codekit-prepend "isotope.js"
// @codekit-prepend "select2.js"
// @codekit-prepend "spin.js"
// @codekit-prepend "doubletaptogo.js"
// @codekit-prepend "cookie.js"
// @codekit-prepend "bootstrap.js"
// @codekit-prepend "zoom.js"
// @codekit-prepend "jquery.lazyload.js"

jQuery( window ).load( function() {
	'use strict';

	var $ = jQuery;

	// create namespace to avoid any possible conflicts
	$.sp_theme_load = {

		isotope: function() {
			/////////////////////////////////////////////////////
			// portfolio shortcode
			/////////////////////////////////////////////////////
			$( '.sc-portfolio' ).each( function() {
				var container = $( this ),
					linkGallery = $( '.link-gallery', this ).val(),
					layoutMode;

				// check what layout mode to use
				if ( $( 'article', container ).hasClass( 'mosaic' ) ) {
					layoutMode = 'masonry';
				} else {
					layoutMode = 'fitRows';
				}

				$( '.isotope-wrap', container ).imagesLoaded( function() {
					$( this ).isotope( {
						itemSelector: '.portfolio-item',
						layoutMode: layoutMode,
						resizable: true,
						onLayout: function() {
							var sortOn = $( '.portfolio-sort li a.active', container ).data( 'filter' ),
								link;

							if ( sortOn === '*' ) {
								link = $( 'a.portfolio-image-link', container );
							} else {
								link = $( '.portfolio-item' + sortOn, container ).find( 'a.portfolio-image-link' );
							}

							link.magnificPopup( {
								removalDelay: 300,
								mainClass: 'mfp-portfolio',
								gallery: {
									enabled: linkGallery === 'true' ? true : false,
									arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
								},
								closeBtnInside: false
							} );							
						}
					} );
				} );

				// filter items when filter link is clicked
				$( 'ul.portfolio-sort a', container ).click( function() {
					var selector = $( this ).attr( 'data-filter' );
					
					// loop through each filter
					$( 'ul.portfolio-sort a', container ).each( function() {
						// remove the active class
						$( this ).removeClass( 'active' );
					} );

					// add active class on selected filter
					$( this ).addClass( 'active' );

					$( '.isotope-wrap', container ).isotope( { filter: selector } );

					return false;
				} );				
			} );
		} // isotope
	}; // close namespace

	$.sp_theme_load.isotope();					
} );

jQuery( document ).ready( function( $ ) {
	'use strict';

	// create namespace to avoid any possible conflicts
	$.sp_theme = {

		stickyFooter: function() {
			var footer = $( '#footer-wrap' ),
				footerPosition = footer.position(),
				viewportHeight = $( window ).height(),
				height;

			height = viewportHeight - footerPosition.top;
			height -= footer.outerHeight();

			if ( height > 0 ) {
				footer.css( { 'margin-top' : height + 'px' } );
			}
		},

		mobileResize: function() {
			// user trigger
			$( 'body' ).trigger( 'mobile_resize' );

			// refresh menu on resize
			$.sp_theme.refreshNavMenu();

			// stick footer to bottom
			$.sp_theme.stickyFooter();

			// keep interactive modal content in center
			$( 'body' ).find( '.interactive-modal-content' ).center();

			// keep quickview content in center
			$( 'body' ).find( '.sp-quickview' ).center( 'absolute' );

			// hide mobile menu
			$( '.mobile-menu-container' ).slideUp( 'fast' );

			// ie9 quirk
			if ( $( 'html' ).hasClass( 'msie9' ) ) {
				if ( $( window ).width() > 480 ) {
					$( '.mobile-menu-button' ).hide();
				} else {
					$( '.mobile-menu-button' ).show();
				}
			}
		},
		
		runSpinner: function( target ) {
			var opts = {
				color: '#ccc',
				lines: 11,
				length: 0,
				width: 7,
				radius: 30,
				trail: 13,
				shadow: false,
				hwaccel: true
			};

			var spinner = new Spinner( opts ).spin( target );

			return spinner;
		},

		refreshNavMenu: function() {
			/////////////////////////////////////////////////////
			// reposition mega menu full width container
			/////////////////////////////////////////////////////
			$( '.sp-mega-menu-active.sp-mega-menu-full-width' ).each( function() {
				var thisLi = $( this ),
					container = $( this ).find( '.sp-mega-menu-column-container' ),
					brandContainerOffset = $( '#brand-container .container' ).offset(),
					containerOffset = thisLi.offset();

				container.css( 'left', '-' + ( containerOffset.left - brandContainerOffset.left ) + 'px' );

				// set width to global container width
				container.css( 'width', ( $( '#brand-container .container' ).width() + 30 ) + 'px' );
			} );
		},

		init: function() {
			// init double tap on touch devices
			$( '#menu-main-menu li:has(ul)' ).doubleTapToGo();
			$( '#mini-cart' ).doubleTapToGo();
			$( '#menu-footer-bar-menu li:has(ul)' ).doubleTapToGo();

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

			// plugin to center element vertically and horizontally within parent container
			$.fn.centerContained = function () {
				return this.each( function () {
					var t = $( this );
			
					t.css({
						left:		'50%', 
						top:		'50%'
					}).css({
						marginLeft:	'-' + ( t.outerWidth() / 2 ) + 'px', 
						marginTop:	'-' + ( t.outerHeight() / 2 ) + 'px'
					});
				} );
			};

			// runs when browser window is resized
			$( window ).resize( function() { $.sp_theme.mobileResize(); } );

			// closes the magnificpopup
			$( 'body' ).on( 'click', '.close-mfp', function( e ) {
				// prevent default behavior
				e.preventDefault();

				$.magnificPopup.close();
			} );

			/////////////////////////////////////////////////////
			// search button open container
			/////////////////////////////////////////////////////
			$( '.nav-wrap' ).on( 'click', '.search-icon-button', function( e ) {
				// prevent default behavior
				e.preventDefault();

				// prevent propagation
				e.stopPropagation();

				// toggle the active class
				$( this ).toggleClass( 'active' );

				// toggle opening and closing search container
				$( this ).parents( '.nav-wrap' ).find( '.search-container' ).stop( true, true ).slideToggle( { duration: 300, easing: 'swing' } );
			} );

			/////////////////////////////////////////////////////
			// float nav
			/////////////////////////////////////////////////////
			if ( sp_theme.float_nav === 'on' ) {
				// get the height of header
				var headerHeight = $( '#main-header' ).outerHeight(),
					nav = $( '.nav-wrap' ).clone( true, true ),
					height = headerHeight + nav.outerHeight();

				// hide the container
				nav.hide().appendTo( 'body' ).addClass( 'float' );

				// check if wp admin bar is present
				if ( $( '#wpadminbar' ).length ) {
					// change top position to 28 - height of admin bar
					nav.css( 'top', '28px' );
				}

				/////////////////////////////////////////////////////
				// rebind mini cart
				/////////////////////////////////////////////////////
				if ( sp_theme.is_mobile === 'no' ) {
					nav.find( '#mini-cart' ).hover( function() {
						$( '.mini-cart-contents, .mini-cart-contents-simple', this ).stop( true, true ).fadeIn( 500 );
					}, function() {
						$( '.mini-cart-contents, .mini-cart-contents-simple', this ).stop( true, true ).fadeOut( 600 );
					} );
				}

				// relocate tooltip to bottom
				nav.find( 'a.get-wishlist' ).data( 'placement', 'bottom' );
				nav.find( 'a.get-compare' ).data( 'placement', 'bottom' );
				nav.find( 'a.search-icon-button' ).data( 'placement', 'bottom' );

				$( window ).on( 'scroll', function() {
					// only work on desktop
					if ( sp_theme.is_mobile === 'no' && $(window).width() > 480 ) {
						// when window passes header
						if ( $( window ).scrollTop() > height ) {
							nav.fadeIn( 'fast' );

						} else {
							nav.fadeOut( 'fast' );
						}
					}
				} );
			}

			/////////////////////////////////////////////////////
			// lightbox on flickr photo
			/////////////////////////////////////////////////////
			$( '.sp-flickr-widget' ).each( function() {
				var container = $( this );

				$( '.flickr-item.lightbox', container ).magnificPopup( {
					removalDelay: 300,
					mainClass: 'mfp-lightbox',
					type: 'image',
					gallery: {
						enabled: true,
						arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
					},
					closeBtnInside: false
				} );				
			} );	

			/////////////////////////////////////////////////////
			// run tabs on blog widget
			/////////////////////////////////////////////////////
			$( '.blog-widget-tabs' ).each( function() {
				var container = $( this ),
					activeTab = parseInt( ( $( 'input.active-tab', container ).val() - 1 ), 10 );

				container.tabs( {
					'collapsible': true,
					'active': activeTab,
					'heightStyle': 'content'
				} );
			} );	

			/////////////////////////////////////////////////////
			// back to top
			/////////////////////////////////////////////////////
			$( 'a.btt, a.site-btt' ).hide();

			// check if we need to show btt
			$( window ).scroll( function() {
				if ( $( this ).scrollTop() > 100 ) {
					$( 'a.btt, a.site-btt' ).fadeIn( 'fast' );
				} else {
					$( 'a.btt, a.site-btt' ).fadeOut( 'fast' );
				}
			} );

			$( 'a.btt, a.site-btt' ).on( 'click', function( e ) {
				// prevent default behavior
				e.preventDefault();

				$( 'body,html' ).animate( { scrollTop: 0 }, 400 );
			} );

			/////////////////////////////////////////////////////
			// mobile menu toggle
			/////////////////////////////////////////////////////						
			$( 'a.mobile-menu-button' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				$( '.mobile-menu-container' ).slideToggle( 200 );
			} );

			/////////////////////////////////////////////////////
			// portfolio single 
			/////////////////////////////////////////////////////
			$( '.sp-portfolio a.portfolio-image-link' ).magnificPopup( {
				removalDelay: 300,
				mainClass: 'mfp-portfolio',
				gallery: {
					enabled: false,
					arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
				},
				closeBtnInside: false
			} );			
		}, // close init

		woocommerce: function() {

			/////////////////////////////////////////////////////
			// product share button
			/////////////////////////////////////////////////////				
			function share_button_click() {
				$( '.product' ).on( 'click', 'a.share-button', function( e ) {
					// prevent default behavior
					e.preventDefault();

					var thisContainer = $( this ),
						thisButton = $( this ),
						productID = thisButton.parents( '.product' ).find( 'input[name=product_id]' ).val(),
						$data = {
							action: 'sp_product_share_ajax',
							product_id: productID,
							ajaxCustomNonce:sp_theme.ajaxCustomNonce
						};

					// first remove popup first
					thisContainer.parent( '.meta-action-buttons' ).find( '.popup' ).fadeOut( 'fast', function() { $( this ).remove(); } );

					$.post( sp_theme.ajaxurl, $data, function( response ) {

						// append the message
						if ( response ) {
							// remove tooltip
							$( '.sp-tooltip' ).tooltip( 'destroy' );

							// build popup
							var popup = $( '<div class="popup">' + response + '</div>' ); 

							thisContainer.parent( '.meta-action-buttons' ).append( popup ).find( '.popup' ).stop( true, true ).fadeIn( 300, function() {
								setTimeout( function() {
									popup.fadeOut( 500, function() { popup.remove(); } );

									$.sp_theme.tooltip();
								}, 10000 );
							} );
						}
					} );
				} );
			}
			share_button_click();

			/////////////////////////////////////////////////////
			// add to wishlist
			/////////////////////////////////////////////////////				
			function add_wishlist_click() {
				$( '.product' ).on( 'click', 'a.wishlist-button', function( e ) {
					// prevent default behavior
					e.preventDefault();

					var thisContainer = $( this ),
						thisButton = $( this ),
						productID = thisButton.parents( '.product' ).find( 'input[name=product_id]' ).val(),
						$data = {
							action: 'sp_woo_add_product_wishlist_ajax',
							product_id: productID,
							ajaxCustomNonce:sp_theme.ajaxCustomNonce
						};

					// first remove popup first
					thisContainer.parent( '.meta-action-buttons' ).find( '.popup' ).fadeOut( 'fast', function() { $( this ).remove(); } );

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						thisButton.addClass( 'added' );

						// refresh icon count in header
						$( '.wishlist-compare .wishlist-item-count' ).html( response.count );

						// append the message
						if ( response.message.length ) {
							// remove tooltip
							$( '.sp-tooltip' ).tooltip( 'destroy' );

							// build popup
							var popup = $( '<div class="popup">' + response.message + '</div>' ); 

							thisContainer.append( popup ).find( '.popup' ).stop( true, true ).fadeIn( 300, function() {
								setTimeout( function() {
									popup.fadeOut( 500, function() { popup.remove(); } );

									$.sp_theme.tooltip();
								}, 5000 );
							} );
						}
					} );
				} );
			}
			add_wishlist_click();

			/////////////////////////////////////////////////////
			// add to compare
			/////////////////////////////////////////////////////	
			function add_compare_click() {			
				$( '.product' ).on( 'click', 'a.compare-button', function( e ) {
					// prevent default behavior
					e.preventDefault();

					var thisContainer = $( this ),
						thisButton = $( this ),
						productID = thisButton.parents( '.product' ).find( 'input[name=product_id]' ).val(),
						$data = {
							action: 'sp_woo_add_product_compare_ajax',
							product_id: productID,
							ajaxCustomNonce:sp_theme.ajaxCustomNonce
						};

					// first remove popup first
					thisContainer.parent( '.meta-action-buttons' ).find( '.popup' ).fadeOut( 'fast', function() { $( this ).remove(); } );

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						thisButton.addClass( 'added' );

						// refresh icon count in header
						$( '.wishlist-compare .compare-item-count' ).html( response.count );

						// append the message
						if ( response.message.length ) {
							// remove tooltip
							$( '.sp-tooltip' ).tooltip( 'destroy' );

							// build popup
							var popup = $( '<div class="popup">' + response.message + '</div>' ); 

							thisContainer.append( popup ).find( '.popup' ).stop( true, true ).fadeIn( 300, function() {
								setTimeout( function() {
									popup.fadeOut( 500, function() { popup.remove(); } );

									$.sp_theme.tooltip();
								}, 5000 );
							} );
						}
					} );
				} );
			}
			add_compare_click();

			/////////////////////////////////////////////////////
			// compare products slider
			/////////////////////////////////////////////////////
			var optionVal = {
				'mode': 'horizontal',
				'speed': 400, 
				'slideSelector': 'li.product',
				'infiniteLoop': false,
				'hideControlOnEnd': true,
				'captions': false,
				'ticker': false,
				'tickerHover': true,
				'slideMargin': 20,
				'adaptiveHeight': false,
				'responsive': true,
				'useCSS': false,
				'touchEnabled': true,
				'oneToOneTouch': true,
				'controls': true,
				'nextText': '<i class="icon-angle-right" aria-hidden="true"></i>',
				'prevText': '<i class="icon-angle-left" aria-hidden="true"></i>',
				'pager': false,
				'auto': false,
				'minSlides': 2,
				'maxSlides': 4,
				'moveSlides': 1,
				'slideWidth': 250
			};

			// user filterable trigger
			$( this ).trigger( 'sp_compare_page_slider_options', optionVal );		
					
			$( '.compare-page' ).each( function() {
				$( '.compare-products-container ul', this ).bxSlider( {
					mode: optionVal.mode,
					speed: optionVal.speed,
					slideSelector: optionVal.slideSelector,
					infiniteLoop: optionVal.infiniteLoop,
					hideControlOnEnd: optionVal.hideControlOnEnd,
					captions: optionVal.captions,
					ticker: optionVal.ticker,
					tickerHover: optionVal.tickerHover,
					slideMargin: optionVal.slideMargin,
					adaptiveHeight: optionVal.adaptiveHeight,
					responsive: optionVal.responsive,
					useCSS: optionVal.useCSS,
					touchEnabled: optionVal.touchEnabled,
					oneToOneTouch: optionVal.oneToOneTouch,
					controls: optionVal.controls,
					nextText: optionVal.nextText,
					prevText: optionVal.prevText,
					pager: optionVal.pager,
					auto: optionVal.auto,
					minSlides: optionVal.minSlides,
					maxSlides: optionVal.maxSlides,
					moveSlides: optionVal.moveSlides,
					slideWidth: optionVal.slideWidth
				} );			
			} );

			/////////////////////////////////////////////////////
			// mini cart
			/////////////////////////////////////////////////////
			if ( sp_theme.is_mobile === 'no' ) {
				$( '#mini-cart' ).hover( function() {
					$( '.mini-cart-contents, .mini-cart-contents-simple' ).stop( true, true ).fadeIn( 500 );
				}, function() {
					$( '.mini-cart-contents, .mini-cart-contents-simple' ).stop( true, true ).fadeOut( 600 );
				} );
			}

			$( 'body' ).on( 'click', '#mini-cart', function() {
				var cartURL = $( this ).data( 'link' );

				window.location.href = cartURL;
			} );

			/////////////////////////////////////////////////////
			// product quickview
			/////////////////////////////////////////////////////
			if ( $( '.product .image-wrap' ).hasClass( 'quickview' ) ) {

				/////////////////////////////////////////////////////
				// product list quickview on click
				/////////////////////////////////////////////////////
				$( '.product .image-wrap' ).on( 'click', '.product-image-link .quickview-button', function( e ) {
					// prevent default behavior
					e.preventDefault();

					var productID = $( this ).closest( '.product' ).find( 'input[name="product_id"]' ).val(),
						productType = $( this ).closest( '.product' ).find( 'input[name="product_type"]' ).val(),
						mask = $( '<div id="quickview-mask"></div>' ),
						$data = {
							action: 'sp_woo_product_quickview_ajax',
							product_id: productID,
							product_type: productType,
							ajaxCustomNonce:sp_theme.ajaxCustomNonce
						};

					// append mask to body
					$( 'body' ).append( mask );

					var target = document.getElementById( 'quickview-mask' ),
						spinner = $.sp_theme.runSpinner( target );

					// hide spinner first
					$( '#quickview-mask .spinner' ).hide();

					// hide the mask first
					mask.hide().fadeIn( 300, function() {
						// show spinner
						$( '#quickview-mask .spinner' ).fadeIn( 200 );
					} );

					$.post( sp_theme.ajaxurl, $data, function( response ) {

						// append the quickview box
						$( 'body' ).append( response );

						// checks to make sure the image is loaded before trying to center quickview
						$( 'body .sp-quickview' ).find( '.product-image' ).load( this, function() {
							$( 'body .sp-quickview' ).center( 'absolute' ).hide().fadeIn( 400, function() {
								// hide spinner
								spinner.stop();
							} );
						} );

						$( 'form.variations_form' ).wc_variation_form();

						// add lightbox to product image
						var imageLink;

						if ( sp_theme.product_gallery_swap ) {
							imageLink = $( 'body .sp-quickview .image-wrap a.zoom' );
						} else {
							imageLink = $( 'body .sp-quickview a.zoom' );
						}

						// load magnificpopup
						imageLink.magnificPopup( {
							removalDelay: 300,
							mainClass: 'mfp-lightbox',
							type: 'image',
							gallery: {
								enabled: true,
								arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
							},
							closeBtnInside: false
						} );

						// get width of image thumbnail
						var thumbWidth = $( '.sp-quickview .product input[name="product_thumb_width"]' ).val(),
							showSlider = $( '.sp-quickview .product input[name="product_image_gallery_slider"]' ).val();

						if ( showSlider === 'on' ) {
							// add slider to product thumbnails
							$( '.sp-quickview .product .thumbnails' ).bxSlider( {
								mode: 'horizontal',
								speed: 400,
								slideSelector: 'a.zoom, a.image-swap',
								infiniteLoop: true,
								hideControlOnEnd: true,
								captions: false,
								ticker: false,
								tickerHover: true,
								slideMargin: 10,
								adaptiveHeight: false,
								responsive: true,
								useCSS: false,
								touchEnabled: true,
								oneToOneTouch: true,
								controls: true,
								nextText: '<i class="icon-angle-right" aria-hidden="true"></i>',
								prevText: '<i class="icon-angle-left" aria-hidden="true"></i>',
								pager: false,
								auto: false,
								minSlides: 1,
								maxSlides: 4,
								moveSlides: 1,
								slideWidth: thumbWidth
							} );
						}

						// show nav arrows on hover
						$( '.sp-quickview .product .bx-wrapper' ).hover( function() {
							$( this ).find( '.bx-controls' ).fadeIn( 'fast' );
						}, function() {
							$( this ).find( '.bx-controls' ).fadeOut( 'fast' );
						} );

						$( '.sp-quickview .product dl.variations select' ).select2( {
							width: 'element',
							minimumResultsForSearch: 20,
							dropdownCssClass: 'quickview-select2-drop'
						} );

						// product image zoom
						if ( sp_theme.product_image_zoom && sp_theme.is_mobile === 'no' ) {
							imageLink.find( 'i.hover-icon' ).remove();

							imageLink.zoom( { url: imageLink.attr( 'href' ) } );

							$( 'body' ).on( 'found_variation reset_image', function() {
								var mainImage = $( '.sp-quickview .image-wrap a.product-image-link' ).prop( 'href' );

								$( '.sp-quickview .image-wrap a.product-image-link img.zoomImg' ).prop( 'src', mainImage );
							});
						}	

						/////////////////////////////////////////////////////
						// product gallery image swap
						/////////////////////////////////////////////////////
						$( '.product' ).on( 'click', 'a.zoom.image-swap', function( e ) {
							// prevent default behavior
							e.preventDefault();
							
							var parentContainer = $( this ).parents( '.product' ),
								attachmentID = $( this ).data( 'attachment-id' ),
								productID = $( this ).data( 'product-id' ),
								$data = {
									action: 'sp_woo_product_image_gallery_swap_quickview_ajax',
									attachment_id: attachmentID,
									product_id: productID,
									ajaxCustomNonce:sp_theme.ajaxCustomNonce
								};						

							// show spin
							var opts = {
								color: '#ccc',
								lines: 11,
								length: 0,
								width: 7,
								radius: 30,
								trail: 13,
								shadow: false,
								hwaccel: true
							};						
								
							var spinner = new Spinner( opts ).spin();
							$( 'body' ).append( spinner.el ).find( '.spinner' ).center();

							$.post( sp_theme.ajaxurl, $data, function( response ) {
								// get image size
								var imageLink = parentContainer.find( 'a.woocommerce-main-image, a.product-image-link' ),
									newImage;

								// set the height to the container to prevent collapse
								imageLink.parents( '.image-wrap' ).prepend( response );

								// get the new image
								newImage = imageLink.parents( '.image-wrap' ).find( 'a.zoom' ).eq( 0 );

								newImage.css( { position: 'absolute', zIndex: 2 } ).hide();

								$( 'img', newImage ).load( function() {
									imageLink.css( { position: 'absolute', zIndex: 1 } ).fadeOut( 300, function() {
										$( this ).remove();

										// load magnificpopup
										$( 'body .sp-quickview a.product-image-link' ).magnificPopup( {
											removalDelay: 300,
											mainClass: 'mfp-lightbox',
											type: 'image',
											gallery: {
												enabled: true,
												arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
											},
											closeBtnInside: false
										} );	
										
										// product image zoom
										if ( sp_theme.product_image_zoom && sp_theme.is_mobile === 'no' ) {
											// remove lightbox hover icon
											parentContainer.find( 'a.woocommerce-main-image, a.product-image-link' ).find( 'i.hover-icon' ).remove();										
											parentContainer.find( 'a.woocommerce-main-image, a.product-image-link' ).zoom( { url: parentContainer.find( 'a.woocommerce-main-image, a.product-image-link' ).attr( 'href' ) } );
										}																		
									} );

									newImage.css( 'position', 'relative' ).fadeIn( 200 );	
								} );

								spinner.stop();			
							} );
						} );					
	
						// bind share button
						share_button_click();

						// bind add wishlist button
						add_wishlist_click();

						// bind add compare button														
						add_compare_click();

						// tooltip
						$.sp_theme.tooltip( { container: 'body' } );
					} );
				} ); // quickview
		
				/////////////////////////////////////////////////////
				// quickview close
				/////////////////////////////////////////////////////			
				$( 'body' ).on( 'click', '.sp-quickview .close-quickview, #quickview-mask', function() {
					// close all select dropdowns
					$( '.sp-quickview .variations select' ).each( function() {
						$( this ).select2( 'close' );
					} );

					$( 'body .sp-quickview' ).fadeOut( 'fast', function() {

						$( this ).remove();

						// fade out quickview mask
						$( 'body #quickview-mask' ).fadeOut( 'fast', function() {
							$( this ).remove();
						} );
					} );
				} );
			} // end quickview

			/////////////////////////////////////////////////////
			// woocommerce add to cart
			/////////////////////////////////////////////////////
			if ( sp_theme.woo_ajax_cart_en ) {
				$( 'body' ).on( 'click', '.add_to_cart_button, .single_add_to_cart_button', function() {
					var thisButton = $( this );

					// remove added class first
					thisButton.removeClass( 'added' ).html( '<i class="icon-plus" aria-hidden="true"></i> ' + sp_theme.add_to_cart_text );

					// Block widgets and fragments
					thisButton.fadeTo( '400', '0.6' ).block( { 
						message: null, 
						overlayCSS: {
							background: 'transparent url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', 
							backgroundSize: '16px 16px', 
							opacity: 0.6 
						} 
					} );

					var current_settings = {},
						productType = thisButton.parents( '.product' ).find( 'input[name="product_type"]' ).val(),
						productID = thisButton.parents( '.product' ).find( 'input[name="product_id"]' ).val(),
						formItems = thisButton.parents( 'form.cart' ).serialize(),
						$data;
						
					switch ( productType ) {

						case 'variable' :
							var all_variations = $( this ).parents( 'form.variations_form' ).data( 'product_variations' );

							// grab each select value
							$( this ).parents( '.variations_form' ).find( '.variations select' ).each( function() {
								// put each setting into array
								current_settings[ $( this ).attr( 'name' ) ] = $( this ).val();
							} );

							var matching_variations = $.fn.wc_variation_form.find_matching_variations( all_variations, current_settings );

							$data = {
								action: 'sp_woo_add_to_cart_ajax',
								product_id: productID,
								variation_id: matching_variations[0].variation_id,
								variations: matching_variations[0].attributes,
								form: formItems,
								product_type: productType,
								ajaxCustomNonce:sp_theme.ajaxCustomNonce
							};

							$.post( sp_theme.ajaxurl, $data, function( response ) {
								response = $.parseJSON( response );

								// Redirect to cart option
								if ( response.redirect ) {
									window.location = response.redirect_url;
									return;
								} else {
									if ( response.cart.length ) {
										$( '.widget_shopping_cart_content' ).html( response.cart );
									}	

									// check if item is added to the cart
									if ( response.was_added_to_cart ) {
										thisButton.addClass( 'added' ).html( '<i class="icon-ok" aria-hidden="true"></i> ' + sp_theme.added_to_cart_text );	
									}

									$( 'body' ).trigger( 'added_to_cart' );	


									var popup = $( '<div class="interactive-modal-content-mask">' + response.interactive_add_to_cart + '</div>' );

									// append to body
									$( 'body' ).append( popup );

									var interactiveMask = $( 'body' ).find( '.interactive-modal-content-mask' ),
										interactiveContent = $( 'body' ).find( '.interactive-modal-content' );

									// center it first before we fade in
									interactiveContent.show().center().hide();

									// fade in mask
									interactiveMask.fadeIn( 'fast', function() {
										interactiveContent.fadeIn( 'fast' );
									} );

									$( 'body' ).on( 'click', '.interactive-modal-content .close-modal', function( e ) {
										// prevent default behavior
										e.preventDefault();

										interactiveContent.fadeOut( 'fast', function() {
											interactiveMask.fadeOut( 'fast', function() {
												$( this ).remove();
											} );
										} );
									} );
								}
							} );
							break;

						case 'grouped' :
						case 'simple' :

							$data = {
								action: 'sp_woo_add_to_cart_ajax',
								product_id: productID,
								form: formItems,
								product_type: productType,				
								ajaxCustomNonce:sp_theme.ajaxCustomNonce
							};

							$.post( sp_theme.ajaxurl, $data, function( response ) {
								response = $.parseJSON( response );

								// Redirect to cart option
								if ( response.redirect ) {
									window.location = response.redirect_url;
									return;
								} else {
									if ( response.cart.length ) {
										$( '.widget_shopping_cart_content' ).html( response.cart );
									}	

									// check if item is added to the cart
									if ( response.was_added_to_cart ) {
										thisButton.addClass( 'added' ).html( '<i class="icon-ok" aria-hidden="true"></i> ' + sp_theme.added_to_cart_text );	
									}
									
									$( 'body' ).trigger( 'added_to_cart' );
									
									var popup = $( '<div class="interactive-modal-content-mask">' + response.interactive_add_to_cart + '</div>' );

									// append to body
									$( 'body' ).append( popup );

									var interactiveMask = $( 'body' ).find( '.interactive-modal-content-mask' ),
										interactiveContent = $( 'body' ).find( '.interactive-modal-content' );

									// center it first before we fade in
									interactiveContent.show().center().hide();

									// fade in mask
									interactiveMask.fadeIn( 'fast', function() {
										interactiveContent.fadeIn( 'fast' );
									} );

									$( 'body' ).on( 'click', '.interactive-modal-content .close-modal', function( e ) {
										// prevent default behavior
										e.preventDefault();

										interactiveContent.fadeOut( 'fast', function() {
											interactiveMask.fadeOut( 'fast', function() {
												$( this ).remove();
											} );
										} );
									} );																								
								}
							} );

							break;

						case 'addons' :
						case 'external' :
							return true;
					}

					return false;		
				} );
			} // woo_ajax_cart_en

			/////////////////////////////////////////////////////
			// added to cart event
			/////////////////////////////////////////////////////
			$( 'body' ).on( 'added_to_cart', function() {
				// data argument is fragments and cart hash

				// unblock
				$( '.add_to_cart_button, .single_add_to_cart_button' ).stop( true ).css( 'opacity', '1' ).unblock();

				var $data = {
					action: 'sp_woo_update_cart_ajax',
					ajaxCustomNonce:sp_theme.ajaxCustomNonce
				};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					response = $.parseJSON( response );

					// update the count
					$( '#mini-cart span.product-item-count' ).html( response.count );

					// remove any notices
					$( '.woocommerce-error, .woocommerce-message' ).fadeOut( 'fast', function() { 
						$( this ).remove();
					} );
				} );
			} );

			/////////////////////////////////////////////////////
			// remove item from cart
			/////////////////////////////////////////////////////			
			$( 'body' ).on( 'click', '.remove-item', function() {
				var itemKey = $( this ).data( 'cart-item-key' ),
					$data = {
						action: 'sp_woo_remove_item_ajax',
						item_key: itemKey,
						ajaxCustomNonce:sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					response = $.parseJSON( response );

					// update cart
					if ( response.cart.length ) {
						$( '.widget_shopping_cart_content' ).html( response.cart );
					}	

					// trigger update cart event
					$( 'body' ).trigger( 'added_to_cart' );
				} );
			} );

			/////////////////////////////////////////////////////
			// remove wishlist item
			/////////////////////////////////////////////////////	
			$( '.wishlist-page' ).on( 'click', '.remove-wishlist-item', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var table = $( this ).parents( 'table.wishlist-table' ),
					thisContainer = $( this ).parents( 'tr.product' ),
					thisButton = $( this ),
					productID = thisButton.data( 'product-id' ),
					wishlistType = $( this ).parents( '.wishlist-page' ).find( 'input[name="wishlist_type"]' ).val(),
					wishlistName = $( this ).parents( '.wishlist-page' ).find( 'input[name="wishlist_name"]' ).val(),
					userID = parseInt( $( this ).parents( '.wishlist-page' ).find( 'input[name="user_id"]' ).val(), 10 ),
					$data = {
						action: 'sp_woo_remove_product_wishlist_item_ajax',
						product_id: productID,
						wishlist_type: wishlistType,
						wishlist_name: wishlistName,
						user_id: userID,
						ajaxCustomNonce:sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					// if empty, remove the table and save buttons
					if ( response === 'empty' ) {
						// remove wishlist table
						table.remove();

						// remove wishlist action buttons
						$( '.wishlist-action' ).remove();

						// remove wishlist link
						$( '#top-bar' ).find( '.topbar-links .get-wishlist' ).remove();

						// add no items message
						$( '.wishlist-page .content' ).html( '<p>' + sp_theme.wishlist_no_items + '</p>' );

						// remove back to account link
						$( '.wishlist-page' ).find( '.back-to-account-link' ).remove();

						// remove email wishlist container
						$( '.email-product-wishlist-container' ).remove();

						// remove saved wishlist title
						$( '.wishlist-name' ).remove();				

						// refresh icon count in header
						$( '.meta-icons-column .get-wishlist .wishlist-item-count' ).html( '0' );
					} else {
						thisContainer.remove();

						// refresh icon count in header
						$( '.meta-icons-column .get-wishlist .wishlist-item-count' ).html( String( parseInt( $( '.meta-icons-column .get-wishlist .wishlist-item-count' ).html(), 10 ) - 1 ) );						
					}
				} );				
			} );

			/////////////////////////////////////////////////////
			// delete wishlist entry
			/////////////////////////////////////////////////////	
			$( '.my-account-wishlists' ).on( 'click', '.delete-wishlist-entry', function( e ) {
				// prevent default behavior
				e.preventDefault();

				if ( confirm( sp_theme.wishlist_confirm_entry_delete ) ) {
					var thisButton = $( this ),
						wishlistName = thisButton.attr( 'data-wishlist-name' ),
						$data = {
							action: 'sp_woo_delete_product_wishlist_entry_ajax',
							wishlist_name: wishlistName,
							ajaxCustomNonce:sp_theme.ajaxCustomNonce
						};

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						// remove the entry
						thisButton.parents( 'li' ).remove();

						// if no more entries display message
						if ( response.length ) {
							$( '.my-account-wishlists' ).html( '<li>' + response + '</li>' );
						}
					} );	
				}	
			} );

			/////////////////////////////////////////////////////
			// save wishlist
			/////////////////////////////////////////////////////
			$( '.wishlist-page' ).on( 'change', 'select[name="product_wishlist_save_type"]', function() {
				var actionContainer = $( this ).parents( '.wishlist-action' ),
					typeNewContainer = actionContainer.find( 'p.new' ),
					typeExistingContainer = actionContainer.find( 'p.existing' ),
					type = $( this ).val();

				actionContainer.find( 'p.error' ).remove();

				switch ( type ) {
					case '0' :
						typeNewContainer.slideUp( 300 );
						typeExistingContainer.slideUp( 300 );
						
						break;

					case 'new' :
						if ( typeExistingContainer.length ) {
							typeExistingContainer.slideUp( 300, function() {
								typeNewContainer.slideDown( 300 );
							} );
						} else {
							typeNewContainer.slideDown( 300 );
						}

						break;

					case 'existing' :
						typeNewContainer.slideUp( 300, function() {
							typeExistingContainer.slideDown( 300 );
						} );

						break;
				}
			} );

			$( '.wishlist-page' ).on( 'click', '.save-wishlist', function( e ) {
				// prevent default behavior
				e.preventDefault();

				// clear any errors
				$( this ).parents( '.wishlist-action' ).find( 'p.error' ).remove();

				var wishlistType = $( this ).attr( 'data-wishlist-type' ),
					wishlistAction = $( this ).parents( '.wishlist-action' ),
					table = wishlistAction.prev( 'table.wishlist-table' ),
					wishlistName = wishlistAction.find( 'input[name="wishlist_name"]' ).val();

				// check if saving as new or existing
				if ( wishlistType ===  'new' ) {
					// check if name is filled
					if ( $( this ).parents( '.wishlist-action' ).find( 'input[name="wishlist_name"]' ).val().length > 0 ) {
						var $data = {
								action: 'sp_woo_save_new_product_wishlist_ajax',
								wishlist_name: wishlistName,
								ajaxCustomNonce:sp_theme.ajaxCustomNonce
							};

						$.post( sp_theme.ajaxurl, $data, function( response ) {
							response = $.parseJSON( response );

							// if name already exists
							if ( response.process === false ) {
								wishlistAction.find( 'label' ).after( '<p class="error">' + response.message + '</p>' );	
							} else {
								// clear wishlist
								// remove wishlist table
								table.remove();

								// remove wishlist action buttons
								$( '.wishlist-action' ).remove();

								// remove wishlist link
								$( '#top-bar' ).find( '.topbar-links .get-wishlist' ).remove();

								// add no items message
								$( '.wishlist-page .content' ).html( '<p>' + response.message + '</p>' );

								// remove back to account link
								$( '.wishlist-page a.back-to-account-link' ).remove();

								// remove email wishlist container
								$( '.email-product-wishlist-container' ).remove();								
							}
						} );					

					} else {
						wishlistAction.find( 'p.new label' ).after( '<p class="error">' + sp_theme.wishlist_save_no_name_text + '</p>' );
					}
				} else if ( wishlistType === 'existing' ) {
					// get the wishlist name from dropdown
					wishlistName = wishlistAction.find( 'select[name="existing_wishlist"]' ).val();

					var $wl_data = {
							action: 'sp_woo_save_existing_product_wishlist_ajax',
							wishlist_name: wishlistName,
							ajaxCustomNonce:sp_theme.ajaxCustomNonce
						};

					$.post( sp_theme.ajaxurl, $wl_data, function( response ) {
						response = $.parseJSON( response );

						// if name already exists
						if ( response.process === false ) {
							wishlistAction.find( 'p.new label' ).after( '<p class="error">' + response.message + '</p>' );	
						} else {
							// clear wishlist
							// remove wishlist table
							table.remove();

							// remove wishlist action buttons
							$( '.wishlist-action' ).remove();

							// remove wishlist link
							$( '#top-bar' ).find( '.topbar-links .get-wishlist' ).remove();

							// add no items message
							$( '.wishlist-page .content' ).html( '<p>' + response.message + '</p>' );

							// remove back to account link
							$( '.wishlist-page a.back-to-account-link' ).remove();

							// remove email wishlist container
							$( '.email-product-wishlist-container' ).remove();
						}
					} );
				}
			} );

			/////////////////////////////////////////////////////
			// email product wishlist
			/////////////////////////////////////////////////////				
			$( '.wishlist-page' ).each( function() {
				var container = $( this ).find( '.wishlist-email-form' );

				$( this ).on( 'click', '.email-product-wishlist-toggle', function( e ) {
					e.preventDefault();
					
					container.slideToggle();
				} );

				container.on( 'click', 'button[name="email_product_wishlist"]', function() {
					var wishlistName = $( 'a.email-product-wishlist', container ).attr( 'data-wishlist-name' ),
						email = $( 'input[name="wishlist_email"]', container ).val(),
						emailSubject = $( 'input[name="wishlist_email_subject"]', container ).val(),
						show_error = false,
						nonce = $( 'input[name="_sp_submit_email_product_wishlist_form_nonce"]', container ).val(),
						$data = {
							action: 'sp_woo_email_product_wishlist_ajax',
							wishlist_name: wishlistName,
							wishlist_email: email,
							wishlist_email_subject: emailSubject,
							ajaxCustomNonce: nonce
						};

					// show spinner
					$( 'i.loader', container ).addClass( 'icon-refresh' ).addClass( 'icon-spin' ).show().css( 'display', 'inline-block' );	

					// remove all messages
					$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
					$( 'p.alert span', container ).html( '' );

					// validate fields
					$( 'input', container ).each( function() { 
						// initially remove all errors
						$( this ).parents( '.form-group' ).removeClass( 'error' ); 

						// get the fields that are required and not set
						if ( $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '' ) { 
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}
					} );

					// shows the error and stops form from submitting
					if ( show_error ) {
						// display alert message
						$( 'p.alert.main span', container ).html( sp_theme.enter_all_required_fields_msg ).parent().addClass( 'alert-danger' ).show();
						
						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();							
						
						return false;
					}

					// ajax the form
					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						// first hide all alerts
						$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
						$( 'p.alert span', container ).html( '' );

						if ( response.proceed === true ) {
							// display alert message
							$( 'p.alert.main span', container ).html( response.message ).parent().addClass( 'alert-success' ).show();

							// clear the form
							$( 'input', container ).val( '' );
						} else {
							// display alert message
							$( 'p.alert.main span', container ).html( response.message ).parent().addClass( 'alert-danger' ).show();
						}

						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	
					} );		
					
					return false;
				} );
				
				// remove error style when input field is in focus
				container.on( 'focus', 'input', function() {
					$( this ).parents( '.form-group' ).removeClass( 'error' );
				} );	
			} );

			/////////////////////////////////////////////////////
			// remove compare item
			/////////////////////////////////////////////////////	
			$( '.compare-page' ).on( 'click', '.remove-compare-item', function( e ) {
				// prevent default behavior
				e.preventDefault();

				var thisButton = $( this ),
					productID = thisButton.data( 'product-id' ),
					$data = {
						action: 'sp_woo_remove_product_compare_item_ajax',
						product_id: productID,
						ajaxCustomNonce:sp_theme.ajaxCustomNonce
					};

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					if ( response === 'empty' ) {
						// remove compare items container
						$( '.compare-page .compare-products-container' ).remove();

						// add no items message
						$( '.compare-page' ).prepend( '<p>' + sp_theme.compare_no_items + '</p>' );

						// remove compare link
						$( '#top-bar' ).find( '.topbar-links .get-compare' ).remove();	

						// refresh icon count in header
						$( '.wishlist-compare .compare-item-count' ).html( '0' );											
					} else { 
						thisButton.parents( 'li.product' ).remove();
						
						// refresh icon count in header
						$( '.wishlist-compare .compare-item-count' ).html( String( parseInt( $( '.wishlist-compare .compare-item-count' ).html(), 10 ) - 1 ) );						
					}
				} );				
			} );

			/////////////////////////////////////////////////////
			// set view type on click
			/////////////////////////////////////////////////////			
			$( '.grid-list-view-buttons .list-view-button' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				$( '.post-type-archive-product ul.products, .tax-product_cat ul.products' ).each( function() {
					var container = $( this );

					// if already on list type return
					if ( container.hasClass( 'list-view' ) ) {
						return;
					}

					// fade out products
					container.find( 'li' ).fadeOut( 300, function() {
						
						container.addClass( 'list-view' );

						// add column sizing
						$( 'li .image-wrap-column' ).addClass( 'col-lg-4 col-md-4 col-sm-4' );
						$( 'li .content-wrap' ).addClass( 'col-lg-8 col-md-8 col-sm-8' );

						// fade in products
						container.find( 'li' ).addClass( 'clearfix' ).fadeIn( 300 );

						// hide the original
						container.find( 'li .image-wrap .add-container' ).css( 'visibility', 'hidden' );

						// add active state to list view button
						$( '.grid-list-view-buttons .list-view-button' ).addClass( 'active' );

						// remove active state from grid view button
						$( '.grid-list-view-buttons .grid-view-button' ).removeClass( 'active' );

					} );
				} );

				// set cookie
				$.cookie( 'sp_view_type', 'list-view', { expires: 30, path: '/' } );
				
			} );

			$( '.grid-list-view-buttons .grid-view-button' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();

				$( '.post-type-archive-product ul.products, .tax-product_cat ul.products' ).each( function() {
					var container = $( this );

					// if already on list type return
					if ( ! container.hasClass( 'list-view' ) ) {
						return;
					}

					// fade out products
					container.find( 'li' ).fadeOut( 300, function() {
					
						container.removeClass( 'list-view' );

						// remove column sizing
						$( 'li .image-wrap-column' ).removeClass( 'col-lg-4 col-md-4 col-sm-4' );
						$( 'li .content-wrap' ).removeClass( 'col-lg-8 col-md-8 col-sm-8' );

						// fade in products
						container.find( 'li' ).removeClass( 'clearfix' ).fadeIn( 300 );

						// show original action meta
						container.find( 'li .image-wrap .add-container' ).css( 'visibility', 'visible' );

						// add active state to list view button
						$( '.grid-list-view-buttons .list-view-button' ).removeClass( 'active' );

						// remove active state from grid view button
						$( '.grid-list-view-buttons .grid-view-button' ).addClass( 'active' );
					} );
				} );

				// set cookie
				$.cookie( 'sp_view_type', 'grid-view', { expires: 30, path: '/' } );

			} );	

			$( '.product dl.variations select' ).select2( {
				width: 'element',
				minimumResultsForSearch: 20,
				dropdownCssClass: 'single-select2-drop',
				containerCssClass: 'single-select2-container'
			} );

			/////////////////////////////////////////////////////
			// single product
			/////////////////////////////////////////////////////
			$( '.single-product .product.single-product' ).each( function() {
				// get width of image thumbnail
				var thumbWidth = parseInt( $( 'input[name="product_thumb_width"]', this ).val(), 10 ),
					showSlider = $( 'input[name="product_image_gallery_slider"]', this ).val();

				var optionVal = {
					'mode': 'horizontal',
					'speed': 300, 
					'slideSelector': 'a.zoom, a.image-swap',
					'infiniteLoop': true,
					'hideControlOnEnd': true,
					'captions': false,
					'ticker': false,
					'tickerHover': true,
					'slideMargin': 10,
					'adaptiveHeight': false,
					'responsive': true,
					'useCSS': false,
					'touchEnabled': true,
					'oneToOneTouch': true,
					'controls': true,
					'nextText': '<i class="icon-angle-right" aria-hidden="true"></i>',
					'prevText': '<i class="icon-angle-left" aria-hidden="true"></i>',
					'pager': false,
					'auto': false,
					'minSlides': 4,
					'maxSlides': 4,
					'moveSlides': 1
				};

				// user filterable trigger
				$( this ).trigger( 'sp_single_product_image_gallery_slider_options', optionVal );

				if ( showSlider === 'on' ) {
					// add slider to product thumbnails
					$( '.thumbnails', this ).bxSlider( {
						mode: optionVal.mode,
						speed: optionVal.speed,
						slideSelector: optionVal.slideSelector,
						infiniteLoop: optionVal.infiniteLoop,
						hideControlOnEnd: optionVal.hideControlOnEnd,
						captions: optionVal.captions,
						ticker: optionVal.ticker,
						tickerHover: optionVal.tickerHover,
						slideMargin: optionVal.slideMargin,
						adaptiveHeight: optionVal.adaptiveHeight,
						responsive: optionVal.responsive,
						useCSS: optionVal.useCSS,
						touchEnabled: optionVal.touchEnabled,
						oneToOneTouch: optionVal.oneToOneTouch,
						controls: optionVal.controls,
						nextText: optionVal.nextText,
						prevText: optionVal.prevText,
						pager: optionVal.pager,
						auto: optionVal.auto,
						minSlides: optionVal.minSlides,
						maxSlides: optionVal.maxSlides,
						moveSlides: optionVal.moveSlides,
						slideWidth: thumbWidth
					} );
				}

				// show nav arrows on hover
				$( '.bx-wrapper', this ).hover( function() {
					$( this ).find( '.bx-controls' ).fadeIn( 'fast' );
				}, function() {
					$( this ).find( '.bx-controls' ).fadeOut( 'fast' );
				} );

				// add lightbox to product image
				var imageLink;

				if ( sp_theme.product_gallery_swap ) {
					imageLink = $( '.image-wrap a.zoom', this );
				} else {
					imageLink = $( 'a.zoom', this );
				}

				imageLink.magnificPopup( {
					removalDelay: 300,
					mainClass: 'mfp-lightbox',
					type: 'image',
					gallery: {
						enabled: true,
						arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
					},
					closeBtnInside: false
				} );

				// product image zoom
				if ( sp_theme.product_image_zoom && sp_theme.is_mobile === 'no' ) {
					imageLink.find( 'i.hover-icon' ).remove();

					imageLink.zoom( { url: imageLink.attr( 'href' ) } );

					$( 'body' ).on( 'found_variation reset_image', function() {
						var mainImage = $( '.image-wrap a.woocommerce-main-image', this ).prop( 'href' );

						$( '.image-wrap a.woocommerce-main-image img.zoomImg', this ).prop( 'src', mainImage );
					});
				}

				// image swap
				if ( sp_theme.product_gallery_swap ) {
					$( this ).on( 'click', 'a.image-swap', function( e ) {
						// prevent default behavior
						e.preventDefault();
						
						var parentContainer = $( this ).parents( '.images' ),
							imageWrap = parentContainer.find( '.image-wrap' ),
							imageLink = imageWrap.find( 'a.woocommerce-main-image, a.product-image-link' ),
							attachmentID = $( this ).data( 'attachment-id' ),
							productID = $( this ).data( 'product-id' ),
							$data = {
								action: 'sp_woo_product_image_gallery_swap_single_ajax',
								attachment_id: attachmentID,
								product_id: productID,
								ajaxCustomNonce:sp_theme.ajaxCustomNonce
							};

						// show spin
						var opts = {
							color: '#999',
							lines: 11,
							length: 0,
							width: 7,
							radius: 30,
							trail: 13,
							shadow: false,
							hwaccel: true
						};

						var spinner = new Spinner( opts ).spin();
						$( 'body' ).append( spinner.el ).find( '.spinner' ).center();
						
						$.post( sp_theme.ajaxurl, $data, function( response ) {
							// get image size
							var newImage;

							// set the height to the container to prevent collapse
							imageWrap.prepend( response );

							// get the new image
							newImage = imageWrap.find( 'a.zoom' ).eq( 0 );

							newImage.css( { position: 'absolute', zIndex: 2 } ).hide();						

							$( 'img', newImage ).load( function() {
								imageLink.css( { position: 'absolute', zIndex: 1 } ).fadeOut( 300, function() {
									$( this ).remove();

									// add lightbox to product image
									parentContainer.find( 'a.woocommerce-main-image, a.product-image-link' ).magnificPopup( {
										removalDelay: 300,
										mainClass: 'mfp-lightbox',
										type: 'image',
										gallery: {
											enabled: true,
											arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
										},
										closeBtnInside: false
									} );

									// product image zoom
									if ( sp_theme.product_image_zoom && sp_theme.is_mobile === 'no' ) {
										// remove lightbox hover icon
										parentContainer.find( 'a.woocommerce-main-image, a.product-image-link' ).find( 'i.hover-icon' ).remove();									
										parentContainer.find( 'a.woocommerce-main-image, a.product-image-link' ).zoom( { url: parentContainer.find( 'a.woocommerce-main-image, a.product-image-link' ).attr( 'href' ) } );
									}								
								} );

								// change image back to relative position and fade in
								newImage.css( 'position', 'relative' ).fadeIn( 200 );
							} );

							imageWrap.find( 'a.product-image-link' ).css( 'display', 'inline-block' );

							spinner.stop();
						} );
					} );
				} // image swap

				// add accordion
				$( '.woocommerce-accordion', this ).accordion( {
					header: 'h3.accordion-title',
					heightStyle: 'content',
					animate: { easing: 'easeInOutQuad', duration: 300 },
					collapsible: true
				} );						
			} ); // single product

			$( '.related.products, .upsells.products, .cross-sells.products' ).each( function() {
				// get width of image thumbnail
				var thumbWidth = $( 'input[name="product_image_width"]', this ).val(),
					products = $( '.products', this );

				// add slider to product thumbnails
				products.bxSlider( {
					mode: 'horizontal',
					speed: 400,
					slideSelector: 'li.product',
					infiniteLoop: false,
					hideControlOnEnd: true,
					captions: false,
					ticker: false,
					tickerHover: true,
					slideMargin: 10,
					adaptiveHeight: false,
					responsive: true,
					useCSS: false,
					touchEnabled: true,
					oneToOneTouch: true,
					controls: true,
					prevText: '<i class="icon-angle-left" aria-hidden="true"></i>',
					nextText: '<i class="icon-angle-right" aria-hidden="true"></i>',
					pager: false,
					auto: false,
					minSlides: 1,
					maxSlides: 6,
					moveSlides: 1,
					slideWidth: thumbWidth
				} );
			} );

			/////////////////////////////////////////////////////
			// add classes to input fields in checkout
			/////////////////////////////////////////////////////
			$( 'body' ).on( 'country_to_state_changing', function() {
				$( '.sp-shipping-calculator-form input.input-text' ).each( function() {
					$( this ).addClass( 'form-control' );
				} );
			} );

			/////////////////////////////////////////////////////
			// add select2 dropdowns and add classes to input fields
			/////////////////////////////////////////////////////
			$( 'form.checkout' ).each( function() {
				/*
				$( 'select', this ).select2( {
					width: 'element',
					minimumResultsForSearch: 20,
					dropdownCssClass: 'checkout-select2-drop',
					containerCssClass: 'checkout-select2-container'
				} );
				*/

				$( 'input[type=text], input[type=password], textarea' ).each( function() {
					$( this ).addClass( 'form-control' );
				} );
			} );

			/////////////////////////////////////////////////////
			// add lightbox for checkout additional info links
			/////////////////////////////////////////////////////
			$( '.checkout-additional-info li.info-link' ).each( function() {
				$( this ).find( 'a.mfp-link' ).magnificPopup( {
					type: 'inline',
					removalDelay: 300,
					mainClass: 'mfp-lightbox',
					gallery: false,
					closeBtnInside: false
				} );
			} );

			/////////////////////////////////////////////////////
			// goto billing click
			/////////////////////////////////////////////////////			
			$( 'a.goto-billing' ).click( function() {
				// remove active class
				$( '.checkout-breadcrumbs li' ).each( function() {
					$( 'a', this ).removeClass( 'active' );
				} );

				$( '.checkout-breadcrumbs li a.billing-bc-link' ).addClass( 'active' );

				$( '.signin-section' ).hide();

				$( '.billing-form-section' ).show();

				$( 'body' ).trigger( 'sp_checkout_billing_tab' );
			} );

			/////////////////////////////////////////////////////
			// goto review click
			/////////////////////////////////////////////////////			
			$( 'a.goto-review' ).click( function() {
				var $continue = true,
					errorHTML = $( '<ul class="woocommerce-error"><li>' + sp_theme.woo_checkout_required_fields_msg + '</li></ul>' );

				// remove all error class
				$( 'form.checkout ul.woocommerce-error' ).remove();
				$( '.billing-form-section p.form-row' ).find( 'input, textarea, select, .chzn-container' ).removeClass( 'error' );

				// do basic validation
				$( '.billing-form-section #customer_details p.form-row' ).each( function() {
					if ( $( this ).is( '.validate-required' ) && $( this ).is( ':visible' ) ) {

						// add error class if required field not set
						if ( $( this ).find( 'input, textarea, select' ).val() === '' ) {
							$( this ).find( 'input, textarea, .chzn-container' ).addClass( 'error' );

							// add error msg
							$( 'form.checkout' ).prepend( errorHTML );

							$continue = false;
						}
					}
				} );
				
				// do basic validation if ship to billing is not checked
				if ( $( '.billing-form-section #ship-to-different-address-checkbox' ).prop( 'checked' ) === true ) {
					$( '.billing-form-section .shipping_address p.form-row' ).each( function() {
						if ( $( this ).is( '.validate-required' ) && $( this ).is( ':visible' ) ) {

							// add error class if required field not set
							if ( $( this ).find( 'input, textarea, select' ).val() === '' ) {
								$( this ).find( 'input, textarea, .chzn-container' ).addClass( 'error' );

								// add error msg
								$( 'form.checkout' ).prepend( errorHTML );

								$continue = false;
							}
						}
					} );
				}

				// if not logged in a must create an account validate
				if ( $( '.checkout .create-account' ).is( '.validate-required' ) || $( '.checkout input#createaccount' ).prop( 'checked' ) === true ) {
					$( '.checkout .create-account' ).find( 'p.form-row' ).each( function() {
						// add error class if required field not set
						if ( $( this ).find( 'input, textarea, select' ).val() === '' ) {
							$( this ).find( 'input, textarea, .chzn-container' ).addClass( 'error' );

							// add error msg
							$( 'form.checkout' ).prepend( errorHTML );
							
							$continue = false;
						}						
					} );
				}

				if ( $continue ) {
					// remove active class
					$( '.checkout-breadcrumbs li' ).each( function() {
						$( 'a', this ).removeClass( 'active' );
					} );

					$( '.checkout-breadcrumbs li a.review-bc-link' ).addClass( 'active' );

					$( '.signin-section' ).hide();

					$( '.billing-form-section' ).hide();

					$( '.review-section' ).show();
				}

				$( 'body' ).trigger( 'sp_checkout_review_tab' );			
			} );
			
			/////////////////////////////////////////////////////
			// sigin breadcrumb link on click
			/////////////////////////////////////////////////////			
			$( 'a.sigin-bc-link' ).click( function() {
				// add class to current and remove from all others
				$( this ).parents( '.checkout-breadcrumbs' ).find( 'li a ' ).removeClass( 'active' );
				$( this ).addClass( 'active' );

				// show content and hide all others
				$( '.signin-section' ).show();

				$( '.billing-form-section' ).hide();
				$( '.review-section' ).hide();

				$( 'body' ).trigger( 'sp_checkout_signin_tab' );
			} );

			/////////////////////////////////////////////////////
			// billing breadcrumb link on click
			/////////////////////////////////////////////////////	
			$( 'a.billing-bc-link' ).click( function() {
				// check if guest checkout enabled or logged in
				if ( ! $( '.goto-billing' ).length ) {
					return false;
				}

				// add class to current and remove from all others
				$( this ).parents( '.checkout-breadcrumbs' ).find( 'li a ' ).removeClass( 'active' );
				$( this ).addClass( 'active' );

				// show content and hide all others
				$( '.billing-form-section' ).show();

				$( '.signin-section' ).hide();
				$( '.review-section' ).hide();

				$( 'body' ).trigger( 'sp_checkout_billing_tab' );
			} );

			/////////////////////////////////////////////////////
			// review breadcrumb link on click
			/////////////////////////////////////////////////////	
			$( 'a.review-bc-link' ).click( function() {
				var $continue = true,
					errorHTML = $( '<ul class="woocommerce-error"><li>' + sp_theme.woo_checkout_required_fields_msg + '</li></ul>' );

				// remove all error class
				$( 'form.checkout ul.woocommerce-error' ).remove();
				$( '.billing-form-section p.form-row' ).find( 'input, textarea, select, .chzn-container' ).removeClass( 'error' );

				// do basic validation
				$( '.billing-form-section #customer_details p.form-row' ).each( function() {
					if ( $( this ).is( '.validate-required' ) && $( this ).is( ':visible' ) ) {

						// add error class if required field not set
						if ( $( this ).find( 'input, textarea, select' ).val() === '' ) {
							$( this ).find( 'input, textarea, .chzn-container' ).addClass( 'error' );

							// add error msg
							$( 'form.checkout' ).prepend( errorHTML );
							
							$continue = false;
						}
					}
				} );

				// do basic validation if ship to billing is not checked
				if ( $( '.billing-form-section #ship-to-different-address-checkbox' ).prop( 'checked' ) === true ) {
					$( '.billing-form-section .shipping_address p.form-row' ).each( function() {
						if ( $( this ).is( '.validate-required' ) && $( this ).is( ':visible' ) ) {

							// add error class if required field not set
							if ( $( this ).find( 'input, textarea, select' ).val() === '' ) {
								$( this ).find( 'input, textarea, .chzn-container' ).addClass( 'error' );

								// add error msg
								$( 'form.checkout' ).prepend( errorHTML );

								$continue = false;
							}
						}
					} );
				}

				// if not logged in a must create an account validate
				if ( $( '.checkout .create-account' ).is( '.validate-required' ) || $( '.checkout input#createaccount' ).prop( 'checked' ) === true  ) {
					$( '.checkout .create-account' ).find( 'p.form-row' ).each( function() {
						// add error class if required field not set
						if ( $( this ).find( 'input, textarea, select' ).val() === '' ) {
							$( this ).find( 'input, textarea, .chzn-container' ).addClass( 'error' );

							// add error msg
							$( 'form.checkout' ).prepend( errorHTML );
							
							$continue = false;
						}						
					} );
				}

				if ( $continue ) {
					// remove active class
					$( '.checkout-breadcrumbs li' ).each( function() {
						$( 'a', this ).removeClass( 'active' );
					} );

					$( '.checkout-breadcrumbs li a.review-bc-link' ).addClass( 'active' );

					$( '.signin-section' ).hide();

					$( '.billing-form-section' ).hide();

					$( '.review-section' ).show();

					// add class to current and remove from all others
					$( this ).parents( '.checkout-breadcrumbs' ).find( 'li a ' ).removeClass( 'active' );
					$( this ).addClass( 'active' );

					// show content and hide all others
					$( '.review-section' ).show();

					$( '.billing-form-section' ).hide();
					$( '.signin-section' ).hide();					
				}

				$( 'body' ).trigger( 'sp_checkout_review_tab' );		
			} );

			/////////////////////////////////////////////////////
			// my account nav tabs
			/////////////////////////////////////////////////////								
			$( '.myaccount' ).tabs( {
				show: { effect: 'fadeIn', duration: 200 },
				hide: { effect: 'fadeOut', duration: 200 }
			} );

			/////////////////////////////////////////////////////
			// my account view orders
			/////////////////////////////////////////////////////			
			$( '.myaccount a.view' ).click( function( e ) {
				e.preventDefault();

				var orderID = $( this ).data( 'order-id' ),
					$data = {
						action: 'sp_woo_view_order_ajax',
						order_id: orderID,
						ajaxCustomNonce:sp_theme.ajaxCustomNonce
					};				

				$.post( sp_theme.ajaxurl, $data, function( response ) {
					$.magnificPopup.open( {
						items: {
							src: response
						},
						type: 'inline',
						removalDelay: 300,
						mainClass: 'mfp-myaccount',
						closeBtnInside: false
					} );
				} );				
			} );	

			/////////////////////////////////////////////////////
			// my account edit account
			/////////////////////////////////////////////////////			
			$( '.myaccount .edit-account' ).each( function() {
				var container = $( this );

				$( 'form', container ).submit( function() {
					var form = $( this ).serialize(),
						show_error = false,
						$data = {
							action: 'sp_woo_edit_account_ajax',
							form_items: form
						};

					// show spinner
					$( 'i.loader', container ).addClass( 'icon-refresh' ).addClass( 'icon-spin' ).show().css( 'display', 'inline-block' );	

					// remove all messages
					$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
					$( 'p.alert span', container ).html( '' );

					// validate fields
					$( 'input', this ).each( function() { 
						// initially remove all errors
						$( this ).parents( '.form-group' ).removeClass( 'error' ); 

						// get the fields that are required and not set
						if ( $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '' ) { 
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}
					} );

					// shows the error and stops form from submitting
					if ( show_error ) {
						// display alert message
						$( 'p.alert.main span', container ).html( sp_theme.enter_all_required_fields_msg ).parent().addClass( 'alert-danger' ).show();
						
						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();							
						
						return false;
					}

					// ajax the form
					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						// first hide all alerts
						$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
						$( 'p.alert span', container ).html( '' );

						if ( typeof response.error_msg === 'object' ) {

							// firstname
							if ( typeof response.error_msg.account_first_name !== 'undefined' && response.error_msg.account_first_name.length ) {
								container.find( 'input[name=account_first_name]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.account_first_name ).parent().addClass( 'alert-danger' ).show();
							}

							// lastname
							if ( typeof response.error_msg.account_last_name !== 'undefined' && response.error_msg.account_last_name.length ) {
								container.find( 'input[name=account_last_name]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.account_last_name ).parent().addClass( 'alert-danger' ).show();
							}

							// email
							if ( typeof response.error_msg.account_email !== 'undefined' && response.error_msg.account_email.length ) {
								container.find( 'input[name=account_email]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.account_email ).parent().addClass( 'alert-danger' ).show();
							}																			

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							return false;
						}

						if ( typeof response.success_msg !== 'undefined' && response.success_msg.length ) {
							// display successful message
							$( 'p.alert.main span', container ).html( response.success_msg ).parent().addClass( 'alert-success' ).show();

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							return false;
						} else {
							// display successful message
							$( 'p.alert.main span', container ).html( response.error_msg ).parent().addClass( 'alert-warning' ).show();

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							return false;
						}
					} );
				
					return false;
				} );
				
				// remove error style when input field is in focus
				container.on( 'focus', 'input', function() {
					$( this ).parents( '.form-group' ).removeClass( 'error' );
				} );
			} );

			// widget layered nav select convert to select2
			$( '.widget_layered_nav select ' ).select2({
				width: '100%',
				minimumResultsForSearch: 20,
				dropdownCssClass: 'woocommerce-ordering-select2-drop'
			});

			$( 'form.variations_form' ).on( 'click', '.reset_variations', function() {
				$( this ).closest( '.variations_form' ).find( '.variations select' ).select2( 'destroy' ).select2({ width:'100%',minimumResultsForSearch:20 });
			});

			// lazyload
			$( 'ul.products' ).each( function() {
				// if it is not a slider
				if ( $( this ).parents( '.sc-product-slider' ).length <= 0 ) {
					$( 'img.lazyload' ).lazyload({
						effect: 'fadeIn'
					});
				}
			});

			// change item added text back to add to cart on variation change
			$( 'body' ).on( 'woocommerce_variation_select_change', function( e ) {
				$( e.target ).find( '.single_add_to_cart_button' ).removeClass( 'added' ).html( '<i class="icon-plus" aria-hidden="true"></i>' + sp_theme.add_to_cart_text );
			});
		},

		shortcode: function() {
			/////////////////////////////////////////////////////
			// lightbox shortcode
			/////////////////////////////////////////////////////
			$( '.sc-lightbox' ).each( function() {
				var link = $( 'a.lightbox', this ),
					thisGroup = link.data( 'group' ),
					items = [];

				if ( $.inArray( thisGroup, items ) === -1 ) {

					link.addClass( thisGroup );

					$( 'a.lightbox.' + thisGroup ).magnificPopup( {
						removalDelay: 300,
						mainClass: 'mfp-lightbox',
						gallery: {
							enabled: true,
							arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
						},
						closeBtnInside: false
					} );
		
					// add group into array
					items.push( thisGroup );
				}
			} );

			/////////////////////////////////////////////////////
			// carousel slider lightbox shortcode
			/////////////////////////////////////////////////////
			$( '.sc-carousel' ).each( function() {
				$( 'a.carousel-lightbox' ).magnificPopup( {
					removalDelay: 300,
					mainClass: 'mfp-carousel',
					gallery: {
						enabled: false,
						arrowMarkup: '<button title="%title%" type="button" class="mfp-custom-arrow icon-angle-%dir%"></button>',
					},
					closeBtnInside: false
				} );
			} );

			/////////////////////////////////////////////////////
			// accordion shortcode
			/////////////////////////////////////////////////////
			$( '.sc-accordion' ).each( function() {
				var accordion = $( this ),
					collapsible = $( 'input[name=collapsible]', accordion ).val(),
					activePanel = $( 'input[name=active_panel]', accordion ).val();

				accordion.accordion( {
					collapsible: ( collapsible === 'true' ) ? true : false,
					create: function( event, ui ) {
						// sets the icon for active panel					
						ui.header.find( 'i' ).removeClass( 'icon-angle-up' ).addClass( 'icon-angle-down' );
					},
					beforeActivate: function( event, ui ) {
						ui.oldHeader.find( 'i' ).removeClass( 'icon-angle-down' ).addClass( 'icon-angle-up' );
						ui.newHeader.find( 'i' ).removeClass( 'icon-angle-up' ).addClass( 'icon-angle-down' );
					},
					heightStyle: 'content',
					active: ( activePanel === 'false' ) ? false : parseInt( activePanel, 10 ) - 1
				} );
			} );

			/////////////////////////////////////////////////////
			// testimonial submit shortcode
			/////////////////////////////////////////////////////
			$( '.sc-testimonial' ).each( function() {
				var container = $( this );

				$( 'form', container ).submit( function() {
					var form = $( this ).serialize(),
						show_error = false,
						$data = {
							action: 'sp_submit_testimonial_ajax',
							form_items: form
						};

					// show spinner
					$( 'i.loader', this ).addClass( 'icon-refresh' ).addClass( 'icon-spin' ).show();

					// remove all messages
					$( '.alert-danger', this ).remove();
					$( '.alert-success', this ).remove();

					// validate fields
					$( 'input, textarea', this ).each( function() {
						// initially remove all errors
						$( this ).parents( '.form-group' ).removeClass( 'error' );

						// get the fields that are required
						if ( $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '' ) {
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}
					} );

					if ( show_error ) {
						// display alert message
						$( '.form-actions', this ).before( $( '<p class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + sp_theme.enter_all_required_fields_msg + '</p>' ) );
						
						// hide spinner
						$( 'i.loader', this ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();						
						
						return false;
					}

					$.post( sp_theme.ajaxurl, $data, function( response ) {
						// display successful message
						$( '.form-actions', container ).before( response );

						// clear the form
						$( 'input', container ).val( '' );
						$( 'textarea', container).val( '' );

						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	
					} );

					return false;
				} );
				
				// remove error style when input field is in focus
				container.on( 'focus', 'input, textarea', function() {
					$( this ).parents( '.form-group' ).removeClass( 'error' );
				} );

				// auto rotation
				$( '.carousel', container ).each( function() { 
					var interval = parseInt( $( this ).parents( '.entry-content' ).find( 'input.interval' ).val(), 10 );

					$( this ).bxSlider( {
						mode: 'fade',
						randomStart: true,
						speed: 1000,
						slideSelector: 'article',
						infiniteLoop: true,
						responsive: true,
						useCSS: false,
						touchEnabled: false,
						pager: false,
						controls: false,
						auto: true,
						pause: interval,
						autoHover: true,
						onSliderLoad: function() {
							$( '.carousel', container ).css( 'visibility', 'visible' ).hide().fadeIn( 200 );
							$( '.carousel', container ).find( 'article' ).css( 'width', '100%' );
						}
					} );
				} );
			} );

			/////////////////////////////////////////////////////
			// Tabs shortcode
			/////////////////////////////////////////////////////
			$( '.sc-tabs' ).each( function() {
				var container = $( this ),
					collapsible = $( 'input.collapsible', container ).val() === 'true' ? true : false,
					active = $( 'input.active', container ).val();

				$( this ).tabs( {
					collapsible: collapsible,
					active: ( active === 'false' ) ? false : parseInt( active, 10 ) - 1
				} );
			} );

			/////////////////////////////////////////////////////
			// pagination
			/////////////////////////////////////////////////////
			$( 'nav.pagination a.current' ).click( function( e ) {
				// prevent default behavior
				e.preventDefault();
			} );

			/////////////////////////////////////////////////////
			// contact submit shortcode
			/////////////////////////////////////////////////////
			$( '.sc-contact-form' ).each( function() {
				var container = $( this );

				$( 'form', container ).submit( function() {
					var form = $( this ).serialize(),
						show_error = false,
						$data = {
							action: 'sp_submit_contact_form_ajax',
							form_items: form
						};

					// show spinner
					$( 'i.loader', container ).addClass( 'icon-refresh' ).addClass( 'icon-spin' ).show().css( 'display', 'inline-block' );	

					// remove all messages
					$( 'p.alert' ).hide();
					$( '.alert-danger', container ).remove();

					// validate fields
					$( 'input, textarea, select', this ).each( function() { 
						// initially remove all errors
						$( this ).parents( '.form-group' ).removeClass( 'error' ); 

						// get the fields that are required and not set
						if ( $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '' ) { 
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}

						// validate single select
						if ( $( this ).hasClass( 'select2-select' ) && $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '0' ) {
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}
						
						// validate multi select
						if ( $( this ).hasClass( 'select2-select' ) && $( this ).attr( 'data-required' ) === 'required' && $( this ).attr( 'multiple' ) === 'multiple' ) {
							if ( $( this ).val() === sp_theme.contact_form_please_select || $( this ).val() === null ) {
								$( this ).parents( '.form-group' ).addClass( 'error' );
								show_error = true;
							}
						}

						// validate valid emails
						if ( $( this ).attr( 'type' ) === 'email' ) {
							var filter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

							if ( ! filter.test( $( this ).val() ) ) {
								$( this ).parents( '.form-group' ).addClass( 'error' );
								show_error = true;
							}
						}
					} );

					// shows the error and stops form from submitting
					if ( show_error ) {
						// display alert message
						$( '.form-actions', container ).before( $( '<p class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + sp_theme.enter_all_required_fields_msg + '</p>' ) );
						$( 'p.alert-danger' ).show();
						
						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();							
						
						return false;
					}

					// ajax the form
					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						// first hide all alerts
						$( 'p.alert' ).hide();
						$( '.alert-danger', container ).remove();

						// check if captcha code is correct
						if ( typeof response.captcha !== 'undefined' && response.captcha.length ) {
							// display alert message
							$( '.form-actions', container ).before( $( '<p class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + response.captcha + '</p>' ) );
							$( 'p.alert-danger' ).show();
							
							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();						
							
							return false;
						}

						// if sent successfully
						if ( response.sent && response.redirect.length ) {
							// redirect
							window.location = response.redirect;

						} else if ( response.sent ) {
							// display successful message
							$( 'p.alert-success', container ).show();

						} else if ( response.sent === false ) {
							$( 'p.alert-warning', container ).show();
						}

						// clear the form
						$( 'input[type=text]', container ).val( '' );
						$( 'input[type=email]', container ).val( '' );
						$( 'textarea', container ).val( '' );
						$( 'select', container ).removeAttr( 'selected' ).val( '' );
						$( 'input[type=checkbox]', container ).removeAttr( 'checked' );
						$( 'input[type=radio]', container ).removeAttr( 'checked' );

						// refresh select2
						$( 'select.select2-select', container ).trigger( 'change' );

						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	
					} );

					return false;
				} );
				
				// remove error style when input field is in focus
				container.on( 'focus', 'input, textarea, select', function() {
					$( this ).parents( '.form-group' ).removeClass( 'error' );
				} );

				// when select2 dropdown is opening
				container.on( 'select2-opening', 'select.select2-select', function() {
					var select = $( this );

					select.parents( '.form-group' ).removeClass( 'error' );
				} );

				// when reset button is clicked
				$( 'button[type=reset]' ).on( 'click', function() {
					// deselect all select inputs
					container.find( 'select' ).each( function() {
						// after removing selected, update select2
						$( 'option:selected', this ).removeAttr( 'selected' ).trigger( 'change' );
					} );

					container.find( 'input, textarea' ).each( function() {
						$( this ).parents( '.form-group' ).removeClass( 'error' );
					} );

					container.find( 'p.alert' ).hide();
				} );

				// date time picker field
				if ( $.fn.datetimepicker ) {			
					$( 'input.datetimepicker', container ).datetimepicker();
					$( '#ui-datepicker-div' ).wrap( '<div class="jquery-ui-style" />' );
				}			

				// date picker field
				if ( $.fn.datepicker ) {			
					$( 'input.datepicker', container ).datepicker();
					$( '#ui-datepicker-div' ).wrap( '<div class="jquery-ui-style" />' );
				}					
			} );

			/////////////////////////////////////////////////////
			// register submit shortcode
			/////////////////////////////////////////////////////
			$( '.sc-register-form' ).each( function() {
				var container = $( this );

				$( 'form', container ).submit( function() {
					var form = $( this ).serialize(),
						show_error = false,
						$data = {
							action: 'sp_submit_register_form_ajax',
							form_items: form
						};

					// show spinner
					$( 'i.loader', container ).addClass( 'icon-refresh' ).addClass( 'icon-spin' ).show().css( 'display', 'inline-block' );	

					// remove all messages
					$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
					$( 'p.alert span', container ).html( '' );

					// validate fields
					$( 'input', this ).each( function() { 
						// initially remove all errors
						$( this ).parents( '.form-group' ).removeClass( 'error' ); 

						// get the fields that are required and not set
						if ( $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '' ) { 
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}
					} );

					// shows the error and stops form from submitting
					if ( show_error ) {
						// display alert message
						$( 'p.alert.main span', container ).html( sp_theme.enter_all_required_fields_msg ).parent().addClass( 'alert-danger' ).show();
						
						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();							
						
						return false;
					}

					// ajax the form
					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						// first hide all alerts
						$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
						$( 'p.alert span', container ).html( '' );

						if ( typeof response.error_msg === 'object' ) {

							// firstname
							if ( typeof response.error_msg.firstname !== 'undefined' && response.error_msg.firstname.length ) {
								container.find( 'input[name=firstname]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.firstname ).parent().addClass( 'alert-danger' ).show();
							}

							// lastname
							if ( typeof response.error_msg.lastname !== 'undefined' && response.error_msg.lastname.length ) {
								container.find( 'input[name=lastname]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.lastname ).parent().addClass( 'alert-danger' ).show();
							}

							// username
							if ( typeof response.error_msg.username !== 'undefined' && response.error_msg.username.length ) {
								container.find( 'input[name=username]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.username ).parent().addClass( 'alert-danger' ).show();
							}

							// email
							if ( typeof response.error_msg.email !== 'undefined' && response.error_msg.email.length ) {
								container.find( 'input[name=email]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.email ).parent().addClass( 'alert-danger' ).show();
							}

							// confirm_email
							if ( typeof response.error_msg.confirm_email !== 'undefined' && response.error_msg.confirm_email.length ) {
								container.find( 'input[name=confirm_email]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.confirm_email ).parent().addClass( 'alert-danger' ).show();
							}

							// captcha
							if ( typeof response.error_msg.captcha !== 'undefined' && response.error_msg.captcha.length ) {
								container.find( 'input[name=captcha_code]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.captcha ).parent().addClass( 'alert-danger' ).show();
							}																					

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							return false;
						}

						if ( typeof response.success_msg !== 'undefined' && response.success_msg.length ) {
							// display successful message
							$( 'p.alert.main span', container ).html( response.success_msg ).parent().addClass( 'alert-success' ).show();

							// clear the form
							$( 'input[type=text]', container ).val( '' );

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							return false;
						} else {
							// display successful message
							$( 'p.alert.main span', container ).html( response.error_msg ).parent().addClass( 'alert-warning' ).show();

							// clear the form
							$( 'input[type=text]', container ).val( '' );

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							return false;
						}
					} );
				
					return false;
				} );
				
				// remove error style when input field is in focus
				container.on( 'focus', 'input', function() {
					$( this ).parents( '.form-group' ).removeClass( 'error' );
				} );						
			} );

			/////////////////////////////////////////////////////
			// login submit shortcode
			/////////////////////////////////////////////////////
			$( '.sc-login-form.login' ).each( function() {
				var container = $( this );

				// when forgot password is clicked
				$( 'a.forgot-password', container ).click( function( e ) {
					// prevent default behavior
					e.preventDefault();

					$( this ).parents( '.sc-login-form.login' ).fadeOut( 'fast', function() {
						$( this ).next( '.sc-login-form.forgot' ).fadeIn( 'fast' );
					} );
					
				} );

				$( 'form', container ).submit( function() {
					var form = $( this ).serialize(),
						show_error = false,
						$data = {
							action: 'sp_submit_login_form_ajax',
							form_items: form
						};

					// show spinner
					$( 'i.loader', container ).addClass( 'icon-refresh' ).addClass( 'icon-spin' ).show().css( 'display', 'inline-block' );	

					// remove all messages
					$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
					$( 'p.alert span', container ).html( '' );

					// validate fields
					$( 'input', this ).each( function() { 
						// initially remove all errors
						$( this ).parents( '.form-group' ).removeClass( 'error' ); 

						// get the fields that are required and not set
						if ( $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '' ) { 
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}
					} );

					// shows the error and stops form from submitting
					if ( show_error ) {
						// display alert message
						$( 'p.alert.main span', container ).html( sp_theme.enter_all_required_fields_msg ).parent().addClass( 'alert-danger' ).show();
						
						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();							
						
						return false;
					}

					// ajax the form
					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						// first hide all alerts
						$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
						$( 'p.alert span', container ).html( '' );

						if ( response.login === true ) {
							// check redirect
							if ( response.redirect.length ) {
								window.location = response.redirect;
								return false;
							}

							// display alert message
							$( 'p.alert.main span', container ).html( response.msg ).parent().addClass( 'alert-success' ).show();	
													
							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							// clear the form
							$( 'input[type=text], input[type=password]', container ).val( '' );

							return false;
						} else if ( response.login === false ) {
							// display alert message
							$( 'p.alert.main span', container ).html( response.msg ).parent().addClass( 'alert-danger' ).show();

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							return false;
						}
					} );
				
					return false;
				} );
				
				// remove error style when input field is in focus
				container.on( 'focus', 'input', function() {
					$( this ).parents( '.form-group' ).removeClass( 'error' );
				} );						
			} );

			/////////////////////////////////////////////////////
			// login forgot submit shortcode
			/////////////////////////////////////////////////////
			$( '.sc-login-form.forgot' ).each( function() {
				var container = $( this );

				// when remember password is clicked
				$( 'a.remember-password', container ).click( function( e ) {
					// prevent default behavior
					e.preventDefault();

					$( this ).parents( '.sc-login-form.forgot' ).fadeOut( 'fast', function() {
						$( this ).prev( '.sc-login-form.login' ).fadeIn( 'fast' );
					} );
					
				} );

				$( 'form', container ).submit( function() {
					var form = $( this ).serialize(),
						show_error = false,
						$data = {
							action: 'sp_submit_login_forgot_form_ajax',
							form_items: form
						};

					// show spinner
					$( 'i.loader', container ).addClass( 'icon-refresh' ).addClass( 'icon-spin' ).show().css( 'display', 'inline-block' );	

					// remove all messages
					$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
					$( 'p.alert span', container ).html( '' );

					// validate fields
					$( 'input', this ).each( function() { 
						// initially remove all errors
						$( this ).parents( '.form-group' ).removeClass( 'error' ); 

						// get the fields that are required and not set
						if ( $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '' ) { 
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}
					} );

					// shows the error and stops form from submitting
					if ( show_error ) {
						// display alert message
						$( 'p.alert.main span', container ).html( sp_theme.enter_all_required_fields_msg ).parent().addClass( 'alert-danger' ).show();
						
						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();							
						
						return false;
					}

					// ajax the form
					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						// first hide all alerts
						$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
						$( 'p.alert span', container ).html( '' );

						if ( response.sent === true ) {
							// display alert message
							$( 'p.alert.main span', container ).html( response.msg ).parent().addClass( 'alert-success' ).show();

							// clear the form
							$( 'input[type=text]', container ).val( '' );
						} else {
							// display alert message
							$( 'p.alert.main span', container ).html( response.msg ).parent().addClass( 'alert-danger' ).show();
						}

						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();

						return false;							
					} );
				
					return false;
				} );
				
				// remove error style when input field is in focus
				container.on( 'focus', 'input', function() {
					$( this ).parents( '.form-group' ).removeClass( 'error' );
				} );						
			} );

			/////////////////////////////////////////////////////
			// change password submit shortcode
			/////////////////////////////////////////////////////
			$( '.sc-change-password-form' ).each( function() {
				var container = $( this );

				$( 'form', container ).submit( function() {
					var form = $( this ).serialize(),
						show_error = false,
						$data = {
							action: 'sp_submit_change_password_form_ajax',
							form_items: form
						};

					// show spinner
					$( 'i.loader', container ).addClass( 'icon-refresh' ).addClass( 'icon-spin' ).show().css( 'display', 'inline-block' );	

					// remove all messages
					$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
					$( 'p.alert span', container ).html( '' );

					// validate fields
					$( 'input', this ).each( function() { 
						// initially remove all errors
						$( this ).parents( '.form-group' ).removeClass( 'error' ); 

						// get the fields that are required and not set
						if ( $( this ).attr( 'data-required' ) === 'required' && $( this ).val() === '' ) { 
							$( this ).parents( '.form-group' ).addClass( 'error' );
							show_error = true;
						}
					} );

					// shows the error and stops form from submitting
					if ( show_error ) {
						// display alert message
						$( 'p.alert.main span', container ).html( sp_theme.enter_all_required_fields_msg ).parent().addClass( 'alert-danger' ).show();
						
						// hide spinner
						$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();							
						
						return false;
					}

					// ajax the form
					$.post( sp_theme.ajaxurl, $data, function( response ) {
						response = $.parseJSON( response );

						// first hide all alerts
						$( 'p.alert', container ).removeClass( 'alert-danger alert-warning' ).hide();
						$( 'p.alert span', container ).html( '' );

						if ( typeof response.error_msg === 'object' && $.isEmptyObject( response.error_msg ) === false ) {

							// current password
							if ( typeof response.error_msg.current_password !== 'undefined' && response.error_msg.current_password.length ) {
								container.find( 'input[name=current_password]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.current_password ).parent().addClass( 'alert-danger' ).show();
							}

							// new password
							if ( typeof response.error_msg.new_password !== 'undefined' && response.error_msg.new_password.length ) {
								container.find( 'input[name=new_password]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.new_password ).parent().addClass( 'alert-danger' ).show();
							}

							// confirm password
							if ( typeof response.error_msg.confirm_password !== 'undefined' && response.error_msg.confirm_password.length ) {
								container.find( 'input[name=confirm_password]' ).parents( '.form-group' ).addClass( 'error' ).find( 'p.alert span' ).html( response.error_msg.confirm_password ).parent().addClass( 'alert-danger' ).show();
							}																				

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							return false;
						}

						if ( typeof response.success_msg !== 'undefined' && response.success_msg.length ) {
							// display successful message
							$( 'p.alert.main span', container ).html( response.success_msg ).parent().addClass( 'alert-success' ).show();

							// clear the form
							$( 'input[type=text], input[type=password]', container ).val( '' );

							// hide spinner
							$( 'i.loader', container ).removeClass( 'icon-refresh' ).removeClass( 'icon-spin' ).hide();	

							// reload the page
							setTimeout( function() { location.reload(); }, 6000 );

							return false;
						}
					} );
				
					return false;
				} );
				
				// remove error style when input field is in focus
				container.on( 'focus', 'input', function() {
					$( this ).parents( '.form-group' ).removeClass( 'error' );
				} );						
			} );

			/////////////////////////////////////////////////////
			// back to top shortcode
			/////////////////////////////////////////////////////
			$( '.sc-btt' ).each( function() {
				var animate = $( this ).hasClass( 'animate' ) ? true : false;

				$( this ).find( 'a' ).on( 'click', function( e ) {
					// prevent default behavior
					e.preventDefault();

					// scroll with animation
					if ( animate ) {
						$( 'body,html' ).animate( { scrollTop: 0 }, 400 );
					} else {
						window.scroll( 0, 0 );
					}

				} );
			} );

			/////////////////////////////////////////////////////
			// faq shortcode
			/////////////////////////////////////////////////////
			$( '.sc-faq' ).each( function() {
				var faq = $( this ),
					collapsible = $( 'input[name=collapsible]', faq ).val();

				faq.accordion( {
					collapsible: ( collapsible === 'true' ) ? true : false,
					heightStyle: 'content',
					active: false,
					header: 'h3',
					beforeActivate: function( event, ui ) {
						ui.newHeader.find( 'i' ).removeClass( 'icon-plus' ).addClass( 'icon-minus' );
						ui.oldHeader.find( 'i' ).removeClass( 'icon-minus' ).addClass( 'icon-plus' );
					},
					create: function( event, ui ) {
						if ( collapsible === 'false' ) {
							ui.header.find( 'i' ).removeClass( 'icon-plus' ).addClass( 'icon-minus' );
						}
					}
				} );
			} );

			/////////////////////////////////////////////////////
			// carousel slider shortcode
			/////////////////////////////////////////////////////
			function carouselOnBefore( thisContainer, slideElement ) {

				// hide the text block
				$( '.inner-container .textblock-container', thisContainer ).hide();

				// hide overlay if no text
				if ( $( '.textblock-container', slideElement ).length === 0 ) {
					$( '.overlay', thisContainer ).hide();
				} else {
					$( '.overlay', thisContainer ).show();
				}

				return true;
			}

			function carouselOnAfter( thisContainer ) {
				// bail if show on hover is on
				if ( $( '.inner-container.show-on-hover', thisContainer ).length ) {
					return true;
				}

				// fade in the text block after slide
				$( '.inner-container .slide:visible .textblock-container', thisContainer ).fadeIn( 500 ).css( 'z-index', '' );

				return true;
			}

			$( '.sc-carousel' ).each( function() {
				var container           = $( this ),
					sliderContainer		= $( '.carousel-container', container ),
					sliderType			= $( 'input[name=slider_type]', this ).val(),
					sliderMode			= $( 'input[name=slider_mode]', this ).val(),
					itemWidth			= $( 'input[name=slider_carousel_item_width]', this ).val(),
					easing				= $( 'input[name=slider_easing]', this ).val(),
					randomize			= $( 'input[name=slider_randomize]', this ).val(),
					autoscroll			= $( 'input[name=slider_autoscroll]', this ).val(),
					interval			= parseInt( $( 'input[name=slider_interval]', this ).val(), 10 ),
					circular			= $( 'input[name=slider_circular]', this ).val(),
					nav					= $( 'input[name=slider_nav]', this ).val(),
					dotNav				= $( 'input[name=slider_dot_nav]', this ).val(),
					pauseOnHover		= $( 'input[name=slider_pause_on_hover]', this ).val(),
					itemsPerClick		= parseInt( $( 'input[name=slider_items_per_click]', this ).val(), 10 ),
					transitionSpeed		= parseInt( $( 'input[name=slider_transition_speed]', this ).val(), 10 ),
					reverseDirection	= $( 'input[name=slider_reverse_direction]', this ).val(),
					touchSwipe			= $( 'input[name=slider_touchswipe]', this ).val(),
					itemsToShow			= parseInt( $( 'input[name=slider_items_to_show]', this ).val(), 10 );

				// pause on hover
				if ( autoscroll === 'on' && pauseOnHover === 'on' ) {
					container.on( {
						mouseenter: function() {
							sliderContainer.stopAuto();
						},

						mouseleave: function() {
							sliderContainer.startAuto();
						}
					}, sliderContainer );
				}

				sliderContainer.bxSlider( {
					mode: sliderType === 'single' ? sliderMode : 'horizontal',
					speed: transitionSpeed,
					randomStart: randomize === 'on' ? true : false,
					slideSelector: 'div.slide',
					infiniteLoop: circular === 'on' ? true : false,
					hideControlOnEnd: true,
					easing: easing,
					captions: false,
					ticker: false,
					tickerHover: true,
					slideMargin: sliderType === 'carousel' ? 20 : null,
					adaptiveHeight: sliderType === 'single' ? true : false,
					video: true,
					responsive: true,
					useCSS: false,
					touchEnabled: touchSwipe === 'on' ? true : false,
					oneToOneTouch: true,
					pager: dotNav === 'on' ? true : false,
					controls: nav === 'on' ? true : false,
					nextText: '<i class="icon-angle-right" aria-hidden="true"></i>',
					prevText: '<i class="icon-angle-left" aria-hidden="true"></i>',
					auto: autoscroll === 'on' ? true : false,
					pause: interval * 1000,
					autoHover: pauseOnHover === 'on' ? true : false,
					autoDirection: reverseDirection === 'on' ? 'prev' : 'next',
					minSlides: sliderType === 'single' ? 1 : 2,
					maxSlides: sliderType === 'single' ? 1 : itemsToShow,
					moveSlides: sliderType === 'single' ? 0 : itemsPerClick,
					slideWidth: sliderType === 'single' ? 0 : itemWidth,
					onSliderLoad: function() {
						// to prevent fouc
						sliderContainer.css( 'visibility', 'visible' ).hide().fadeIn( 'fast' );
					},					
					onSlideBefore: function( slideElement ) {
						carouselOnBefore( container, slideElement );
					},
					onSlideAfter: function() {
						carouselOnAfter( container );
					}
				} );
			} );	

			/////////////////////////////////////////////////////
			// product slider shortcode
			/////////////////////////////////////////////////////
			$( '.sc-product-slider' ).each( function() {
				var container = $( this ),
					sliderContainer	= $( 'ul.products', container ),
					options			= $.parseJSON( $( 'input[name="slider_options"]', this ).val() ),
					itemWidth		= parseInt( options.slider_carousel_item_width, 10 ) + 2,
					easing			= options.slider_easing,
					autoscroll		= options.slider_autoscroll,
					interval		= parseInt( options.slider_interval, 10 ),
					circular		= options.slider_circular,
					nav				= options.slider_nav,
					pauseOnHover	= options.slider_pause_on_hover,
					itemsPerClick	= parseInt( options.slider_items_per_click, 10 ),
					transitionSpeed	= parseInt( options.slider_transition_speed, 10 ),
					itemsToShow		= parseInt( options.slider_items_to_show, 10 ),
					minItems		= parseInt( options.slider_min_items, 10 );

				// pause on hover
				if ( autoscroll === 'on' && pauseOnHover === 'on' ) {
					container.on( {
						mouseenter: function() {
							sliderContainer.stopAuto();
						},

						mouseleave: function() {
							sliderContainer.startAuto();
						}
					}, sliderContainer );
				}

				sliderContainer.bxSlider( {
					mode: 'horizontal',
					speed: transitionSpeed,
					slideSelector: 'li.product',
					infiniteLoop: circular === 'true' ? true : false,
					hideControlOnEnd: true,
					easing: easing,
					captions: false,
					ticker: false,
					tickerHover: true,
					slideMargin: 20,
					adaptiveHeight: false,
					video: false,
					responsive: true,
					useCSS: false,
					touchEnabled: true,
					oneToOneTouch: true,
					pager: false,
					controls: nav === 'true' ? true : false,
					nextText: '<i class="icon-angle-right" aria-hidden="true"></i>',
					prevText: '<i class="icon-angle-left" aria-hidden="true"></i>',
					auto: autoscroll === 'true' ? true : false,
					pause: interval,
					autoHover: pauseOnHover === 'true' ? true : false,
					minSlides: minItems,
					maxSlides: itemsToShow,
					moveSlides: itemsPerClick,
					slideWidth: itemWidth,
					onSliderLoad: function() {
						// to prevent fouc
						sliderContainer.css( 'visibility', 'visible' ).hide().fadeIn( 'fast' );
					}
				} );				
			} );

			// facebook
			if ( $( '#fb-root' ).length ) {
				(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));				
			}

			// pinterest pinit
			if ( $( '.sc-pinit' ).length ) {
				(function(d){
				    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
				    p.type = 'text/javascript';
				    p.async = true;
				    p.src = '//assets.pinterest.com/js/pinit.js';
				    f.parentNode.insertBefore(p, f);
				}(document));
			}

			// google plus one
			if ( $( '.sc-gplusone' ).length ) {
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
			}

			// twitter tweet script
			if ( $( '.sc-tweet' ).length || $( '.twitter-follow-button' ).length ) {
				!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
			}
		}, // shortcode

		startSelect2: function() {
			// check if select2 function exists
			if ( $.fn.select2 ) {			
				$( '.select2-select' ).select2( {
					width: 'element',
					minimumResultsForSearch: 20
				} );

				$( '.woocommerce-ordering select.orderby' ).select2( {
					width: 'element',
					minimumResultsForSearch: 20,
					dropdownCssClass: 'woocommerce-ordering-select2-drop'
				} );				
			}
		},

		tooltip: function() {
			if ( sp_theme.is_mobile === 'no' ) {
				$( '.sp-tooltip' ).tooltip( { container: 'body' } );
			}
		},

		fitvids: function() {
			$( '.fitvids-video-wrapper' ).fitVids();
		}
	}; // close namespace
	
	$.sp_theme.init();
	$.sp_theme.mobileResize();

	// check if woo is active
	if ( sp_theme.woo_active ) {
		$.sp_theme.woocommerce();
	}

	$.sp_theme.shortcode();
	$.sp_theme.startSelect2();
	$.sp_theme.tooltip();
	$.sp_theme.fitvids();
// end document ready
} );						