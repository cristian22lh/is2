<?php
	
	// init
	require './assets/db.php';
	$db = new DB();
	// las funciones helpers tienen como prefijo __
	require './assets/helpers.php';
	// mas inits
	__initSession();
	
	// veo adodne quiere ir el usuario
	$reqURI = parse_url( $_SERVER['REQUEST_URI'] );
	$path = preg_replace( '/\/?index\.php\/?/', '/', $reqURI['path'] );
	$segs = explode( '/', $path );
	$page = $segs[count( $segs ) - 1];
	
	// routeamos
	if( !$page ) {
		// vamos a login
		require './controllers/login.php';
		
	} else if( $page == 'logout' ) {
		__endSession();
		__redirect( '/' );
	
	} else if( $page == 'app' ) {
		// vamos a app
		require './controllers/app.php';
	}

?>