<?php

	function __redirect( $url ) {
		if( $url{0} != '/' ) {
			$url = '/' . $url;
		}
		header( 'Location: ' . $url );
		die();
	}
	
	function __issetPOST( $fields ) {
		return $_SERVER['REQUEST_METHOD'] == 'POST' && count( $_POST ) > 0 && count( array_diff( $fields, array_keys( $_POST ) ) ) == 0;
	}
	
	// con este function me fijo si en el $_GET, existe $_GET[$name] = $value
	function __issetGETField( $name, $value ) {
		return count( $_GET ) > 0 && isset( $_GET[$name] ) && $_GET[$name] == $value;
	}

	function __GETField( $name ) {
		return count( $_GET ) > 0 && isset( $_GET[$name] ) ? $_GET[$name] : null;
	}
	
// ************** /
// TODO ESTO HACE USO $_SESSION
// ************* /
	function __initSession() {
		session_start();
	}
	
	function __endSession() {
		session_destroy();
	}
	
	function __isUserLogged() {
		return isset( $_SESSION['is_logged'] ) && $_SESSION['is_logged'] == true;
	}
	
	function __setUserLogin() {
		$_SESSION['is_logged'] = true;
	}
	
	function __setUsername( $username ) {
		$_SESSION['username'] = $username;
	}
	
	function __getUsername() {
		return $_SESSION['username'];
	}
	
// ************** /
// ACA TAN LOS SANITIZERS
// ************* /
	function __toISODate( $value ) {
		$value = explode( '/', trim( $value ) );
		if( count( $value ) != 3 ) {
			return false;
		}
		$year = $value[2];
		if( $year < 0 ) {
			return false;
		}
		$month = $value[1];
		if( $month < 0 ) {
			return false;
		}
		if( $month < 10 ) {
			$month = '0' . (int) $month;
		}
		$date = $value[0];
		if( $date < 0 ) {
			return false;
		}
		if( $date < 10 ) {
			$date = '0' . (int) $date;
		}
		
		return $year . '-' . $month . '-' . $date;
	}
	
	function __toISOTime( $value ) {
		if( !preg_match( '/^(\d{2}):(\d{2}) (PM|AM)$/i', trim( $value ), $m ) ) {
			return false;
		}
		$hours = $m[1];
		$minutes = $m[2];
		$meridian = $m[3];
		if( $hours > 12 || $minutes > 59 ) {
			return false;
		}
		if( $meridian == 'PM' ) {
			$hours += 12;
		}
		
		return $hours . ':' . $minutes . ':00';
	}

	function __cleanDNI( $value ) {
		return str_replace( '.', '', $value );
	}

?>