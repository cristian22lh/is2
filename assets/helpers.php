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

?>