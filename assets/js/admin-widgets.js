// @codekit-prepend "timepicker.js"
// @codekit-prepend "select2.js"

jQuery( document ).ready( function( $ ) {
	'use strict';

	// create namespace to avoid any possible conflicts
	$.SPWidgets = {	
		init: function() {
			// check if select2 function exists
			if ( $.fn.select2 ) {					
				$( '#widgets-right .select2-select' ).select2( { width: 'element', minimumResultsForSearch: 20 } );
			}

			/////////////////////////////////////////////////////
			// facebook switch settings on plugin type
			/////////////////////////////////////////////////////
			function fbTypeSwitch() {
				$( '.fb-plugin-type' ).each( function() {
					$( this ).on( 'change', function() {
						var type = $( this ).val();

						if ( type === 'activity_feed' ) {
							$( this ).parents().find( '.type-activity-feed' ).show();
							$( this ).parents().find( '.type-like-box' ).hide();
						} else if ( type === 'like_box' ) {
							$( this ).parents().find( '.type-activity-feed' ).hide();
							$( this ).parents().find( '.type-like-box' ).show();
						}
					} );
				} );
			}
			fbTypeSwitch();

			/////////////////////////////////////////////////////
			// bind datepicker for promotional widget
			/////////////////////////////////////////////////////
			function loadPromotionalWidgetDateTimePicker() {
				$( '#widgets-right input.promotional-widget.datepicker' ).each( function() {
						$( this ).datetimepicker();
						$( '#ui-datepicker-div' ).wrap( '<div class="jquery-ui-style" />' );
				} );					
			}
			loadPromotionalWidgetDateTimePicker();

			/////////////////////////////////////////////////////
			// rebind scripts after ajax callback from widgets save function
			/////////////////////////////////////////////////////
			$( document ).ajaxSuccess( function( e, xhr, settings ) {	
				if ( $.fn.select2 ) {
					$( '#widgets-right .select2-select' ).select2( { width: 'element', minimumResultsForSearch: 20 } );
				}
									
				if ( settings.data.search( 'action=save-widget' ) !== -1 && settings.data.search( 'id_base=sp-promotional-widget' ) !== -1 ) {
					loadPromotionalWidgetDateTimePicker();
				}	

				if ( settings.data.search( 'action=save-widget' ) !== -1 && settings.data.search( 'id_base=sp-facebook-widget' ) !== -1 ) {
					fbTypeSwitch();
				}							
			} );	
		}  // close init
	}; // close namespace
	
	$.SPWidgets.init();
// end document ready
} );