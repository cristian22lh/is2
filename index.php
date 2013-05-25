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
	$page = preg_replace( '/\/?index\.php\/?/', '/', $reqURI['path'] );

	// debo saber si la pagina aonde ira el usuario
	// solo puede ser accedida por usuarios loguedaos
	// en este array tengo las paginas QUE NO!! necesitan
	// de que el usuario este loguedo para verlas
	$guestPages = array( '/', 'iniciar-sesion' );
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
		__redirect( '/iniciar-sesion' );
	}

	// routeamos
	if( $page === '/' || $page == '/iniciar-sesion' ) {
		require './controllers/login.php';
	} else if( $page == '/cerrar-sesion' ) {
		require './controllers/logout.php';
	
// *** TURNOS *** //
	} else if( $page == '/turnos' ) {
		require './controllers/appointments.php';
	} else if( $page == '/turnos/confirmar' ) {
		require './controllers/appointments.confirm.php';
	} else if( $page == '/turnos/cancelar' ) {
		require './controllers/appointments.cancel.php';
	} else if( $page == '/turnos/borrar' ) {
		require './controllers/appointments.remove.php';
	} else if( $page == '/turnos/reiniciar' ) {
		require './controllers/appointments.reset.php';
	}

?>