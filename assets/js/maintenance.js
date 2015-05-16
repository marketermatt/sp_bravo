// @codekit-prepend "countdown.js"

jQuery( document ).ready( function( $ ) { 
	$.sp_theme_on_ready = {
		init: function() {
			var	datetime = $( 'input.maintenance-datetime' ).val(),
				timezone = $( 'input.maintenance-timezone' ).val();
			
			if ( datetime === '0' ) {	
				datetime = new Date();
			} else {
				datetime = new Date( datetime );
			}
			
			$( '#countdown' ).countdown( { until:$.countdown.UTCDate( timezone, datetime ), format: 'dHMS', layout: 
			'<div id="timer">' +
				'<ul class="clearfix">' +
				'<li><span class="timer-numbers">{dnn}</span><p>' + days + '</p></li>'+
				'<li><span class="timer-numbers">{hnn}</span><p>' + hours + '</p></li>'+ 
				'<li><span class="timer-numbers">{mnn}</span><p>' + minutes + '</p></li>'+
				'<li><span class="timer-numbers">{snn}</span><p>' + seconds + '</p></li>'+
				'</ul>' +
			'</div>'			  
			} );
		} // close init
	} // close namespace

	$.sp_theme_on_ready.init();
} );