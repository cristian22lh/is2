<?php
	
	// init
	require './assets/db.php';
	$db = new DB();
	// las funciones helpers tienen como prefijo __
	require './assets/helpers.php';
	// mas inits
	__initSession();
	
	// veo adonde quiere ir el usuario
	$reqURI = parse_url( $_SERVER['REQUEST_URI'] );
	$path = preg_replace( '/\/?index\.php\/?/', '/', $reqURI['path'] );
	$segs = explode( '/', $path );
	$page = $segs[count( $segs ) - 1];
	
	// debo saber si la pagina aonde ira el usuario
	// solo puede ser accedida por usuarios loguedaos
	// en este array tengo las paginas QUE NO!! necesitan
	// de que el usuario este loguedo para verlas
	$guestPages = array( '', 'login' );
	for( $i = 0, $l = count( $guestPages ); $i < $l; $i++ ) {
		$guest = $guestPages[$i];
		// la pagina que quiere ver el usuario no necesita
		// de que el usuario este logueado para verla, terminado
		if( $guest == $page ) {
			break;
		}
	}
	// la pagina que quiere ver el usuario es protegida
	// vemos si el usuario esta logueado
	if( $i == $l && !__isUserLogged() ) {
		__redirect( '/login' );
	}
	
	// routeamos
	if( !$page || $page == 'login' ) {
		require './controllers/login.php';
		
	} else if( $page == 'logout' ) {
		require './controllers/logout.php';
	
	} else if( $page == 'app' ) {
		require './controllers/app.php';
	}

?>