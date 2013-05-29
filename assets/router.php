<?php

	class Router {
	
		// aca se guarda el matcheo de la url
		private $m;
		
		function __construct() {
		}
		
		function start( $routes, $page, $fallbackRoute ) {			
			$count = 0;
			foreach( $routes as $route => $model ) {
				if( $this->test( $route, $page ) ) {
					$path = './models/' . $model . '.php';
					if( !file_exists( $path ) ) {
						die( 'Specified model "' . $model . '" does not exists at "' . $path . '"' );
					}
					return $path;
				} else {
					$count++;
				}
			}
			// la pagina que se quiere acceder no existe
			if( $count == count( $routes ) ) {
				if( $fallbackRoute{0} != '/' ) {
					$fallbackRoute = '/' . $fallbackRoute;
				}
				__redirect( $fallbackRoute . '?destino=' . $page );
			}
		}
		
		function test( $pat, $page ) {
			$this->m = array();
		
			// just a /clients/list == /clients/list
			if( $pat == $page ) {
				return true;
			}
			// aca tengo algo como /clients/edit/:id
			$pat = explode( '/', $pat );
			// aca tengo algo cmo /clients/edit/123
			$page = explode( '/', $page );
			$l = count( $page );
			if( count( $pat ) == $l ) {
				for( $i = 0; $i < $l; $i++ ) {
					// aca tengo 123
					$seg = $page[$i];
					// aca tengo :id
					$cmp = $pat[$i];
					// es :id entonces seg debe un entero
					if( $cmp == ':id' ) {
						if( $seg <= 0 ) {
							return false;
						}
					} else if( $cmp == ':char' ) {
						if( !in_array( strtoupper( $seg ), range( 'A', 'Z' ) ) ) {
							return false;
						}
					// si $cmp no es algo como :id entonces es
					// $seg y $cmp deben ser iguales para poder continuar
					} else if( $seg != $cmp ) {
						return false;
					}
					// keep saving the matches
					$this->m[] = $seg;
				}
				return true;
			}
			return false;
		}
		
		function seg( $i ) {
			return isset( $this->m[$i] ) ? $this->m[$i] : null;
		}
		
	}

?>