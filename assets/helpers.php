<?php

	function __redirect( $url ) {
		if( $url{0} !== '/' ) {
			$url = '/' + $url;
		}
		header( 'Location: ' . $url );
		die();
	}
	
	function __issetPOST( $fields ) {
		return $_SERVER['REQUEST_METHOD'] == 'POST' && count( $_POST ) > 0 && count( array_diff( $fields, array_keys( $_POST ) ) ) == 0;
	}
	
	function __initSession() {
		session_start();
	}
	
	function __endSession() {
		session_destroy();
	}
	
	function __setSessionItem( $key, $value ) {
		$_SESSION[$key] = $value;
	}
	
	function __isUserLogged() {
		return isset( $_SESSION['is_logged'] ) && $_SESSION['is_logged'] == true;
	}
	
	function __setUserLogin() {
		$_SESSION['is_logged'] = true;
	}

?>