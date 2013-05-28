<?php

	class Matcher {
	
		// aca se guarda el matcheo de la url
		private $m = array();
		
		function __construct() {
		}
		
		function test( $pat, $page ) {
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