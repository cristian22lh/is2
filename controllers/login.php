<?php

	// se quiere hacer el pillo
	if( __isUserLogged() ) {
		__redirect( '/turnos' );
	}

	// defaults variales que son usadas en la view
	$isErrorLogin = false;

	// el usuario ha hecho click en el button "Iniciar sesion"
	// procedemos a validar sus credenciales
	if( __issetPOST( array( 'username', 'password' ) ) ) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// vemos si el usuario existe en la db
		$res = $db->select(
			'SELECT id FROM usuarios WHERE usuario = ? AND clave = SHA( ? )', 
			array( $username, $password )
		);
		
		// hubo exito en la query
		if( count( $res ) == 1 ) {
			__setUserLogin();
			__setUsername( $username );
			// tiro un redirect a la aplicacion
			__redirect( '/turnos' );
		}
		
		$isErrorLogin = true;
	}
	
	// render
	require './views/login.php';

?>