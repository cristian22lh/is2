<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Climedis - <?php echo $page; ?></title>
		<?php t_setCustomTypeface(); ?>
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<script src="/js/jquery.bootstrap.min.js"></script>
		<link href="/css/is2.css" rel="stylesheet">
		<script src="/js/is2.js"></script>
		<style>
			.ar-clock {
				position: fixed;
				top: 110px;
				text-align: center;
				z-index: -1;
			}
			.ar-clock > span {
				display: block;
			}
			.ar-clock h1 {
				font-size: 100px;
				font-weight: 600;
				color: #ccc;
				text-shadow: 0 -2px 0 #fff;
				line-height: .7;
				opacity: .7;
			}
			.ar-clock-month {
				font-size: 50px;
				color: #fff;
				text-shadow: 0 -2px 0 #ccc;
				font-weight: 600;
				line-height: .4;
				position: relative;
				z-index: 100;
			}
			.ar-clock-year {
				font-size: 40px;
				font-weight: 600;
				color: #ddd;
				text-shadow: 0 -1px 0 #ccc;
				line-height: 1.5;
			}
			.ar-clock-time {
				font-size: 20px;
				font-weight: 600;
				color: #ddd;
				text-shadow: 0 -1px 0 #ccc;
			}
		</style>
		<script>
			$( function() {
				var $clock = $(
					'<div class="ar-clock">' +
						'<h1></h1>' +
						'<span class="ar-clock-month"></span>' +
						'<span class="ar-clock-year"></span>' +
						'<div class="ar-clock-time">' +
							'<span class="ar-clock-time-hours"></span>' +
							'<span>:</span>' +
							'<span class="ar-clock-time-minutes"></span>' +
						'</div>' +
					'</div>'
				);
				
				var padInteger = function( value ) {
					return value < 10 ? '0' + value : value;
				};
			
				var d = new Date(),
					date = d.getDate(),
					MONTHNAMES = [ 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' ],
					month = MONTHNAMES[d.getMonth()];
					
				$clock.find( 'h1' ).html( padInteger( date ) );
				$clock.find( '.ar-clock-month' ).html( month );
				$clock.find( '.ar-clock-year' ).html( d.getFullYear() );
				
				var $hours = $clock.find( '.ar-clock-time-hours' ),
					$minutes = $clock.find( '.ar-clock-time-minutes' );
				
				var updateClock = function() {
					var d = new Date(),
						hours = d.getHours(),
						minutes =  d.getMinutes();
						
					$hours.html( padInteger( hours ) );
					$minutes.html( padInteger( minutes ) );
					
					nextTick();
				};
				
				var nextTick = function() {
					window.setTimeout( function() {
						updateClock();
					}, 60000 );
				};
				
				updateClock();
				
				var clockWidth = $clock.css( 'visibility', 'hidden' ).appendTo( 'body' ).outerWidth();
				$clock.css( 'left', $( '.container' ).offset().left - clockWidth );
				$clock.css( 'visibility', 'visible' );
			} );
		</script>
		<script>
		var isFullscreen = false;
		(function() {
			var $document = $( document );
			$document.on( 'fullscreen', function( e ) {
				window.setTimeout( function() {
					isFullscreen = true;
					window.localStorage.setItem( 'is2-fullscreen', 1 );
					var $wrapper = $( '.container' ),
						prevHeight = $wrapper.innerHeight(),
						newHeight = window.innerHeight - $( 'header' ).outerHeight() - $( 'footer' ).outerHeight() - 3;
					if( newHeight <= prevHeight ) {
						return;
					}
					$wrapper.css( 'min-height', newHeight - parseFloat( $wrapper.css( 'padding-top' ) ) - parseFloat( $wrapper.css( 'padding-bottom' ) ) );
					var height = 0;
					$wrapper.children().filter( ':not( .is2-grid-wrapper )' ).each( function() {
						var $el = $( this );
						if( $el.css( 'display' ) !== 'none' ) {
							height += $el.outerHeight() + parseFloat( $el.css( 'margin-top' ) ) + parseFloat( $el.css( 'margin-bottom' ) );
						}
					} );
					var $grid = $( '.is2-grid-wrapper' );
					var gridHeight = $grid.height() + parseFloat( $grid.css( 'margin-top' ) ) + parseFloat( $grid.css( 'margin-bottom' ) );
					$grid.height( $wrapper.outerHeight() - gridHeight - height + gridHeight );
				}, 2000 );
			} );
			
			var checkFullScreen = function() {
				if( Math.abs( $( window ).height() - window.screen.height ) <= 1 && !isFullscreen ) {
					$document.trigger( 'fullscreen' );
				} else {
					isFullscreen = false;
					window.localStorage.removeItem( 'is2-fullscreen' );
				}
			};
			
			$document.on( 'keyup', function( e ) {
				// F11
				if( e.keyCode === 122 ) {
					checkFullScreen();
				}
			} );
			
			if( window.localStorage.getItem( 'is2-fullscreen' ) - 0 ) {
				checkFullScreen();
			}

		})();
		</script>