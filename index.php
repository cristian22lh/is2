<?php

	require './assets/db.php';
	// las funciones helpers tienen como prefijo __
	require './assets/helpers.php';
	// las funciones template tienen como prefijo __
	require './views/_template.php';
	// init
	$db = new DB();
	__initSession();
	
	// veo adonde quiere ir el usuario
	$reqURI = parse_url( $_SERVER['REQUEST_URI'] );
	$page = preg_replace( '/\/?index\.php\/?/', '/', $reqURI['path'] );

	// debo saber si la pagina aonde ira el usuario
	// solo puede ser accedida por usuarios loguedaos
	// en este array tengo las paginas QUE NO!! necesitan
	// de que el usuario este loguedo para verlas
	$guestPages = array( '/', '/iniciar-sesion' );
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
	} else if( $page == '/turnos/buscar' ) {
		require './controllers/appointments.search.php';
	} else if( $page == '/turnos/crear' ) {
		require './controllers/appointments.new.php';

// *** MEDICOS *** //
	} else if( $page == '/medicos/comprobar-horarios-disponibilidad' ) {
		require './controllers/doctors.check.availability.php';
	
// *** PACIENTES *** //
	} else if( $page == '/pacientes' ) {
		require './controllers/patients.php';
	} else if( $page == '/pacientes/buscar/dni' ) {
		require './controllers/patients.search.dni.php';
	
// *** ESPECIALIDADES *** //
	} else if( $page == '/especialidades' ) {
		require './controllers/specialities.php';
	} else if( $page == '/especialidades/crear' ) {
		require './controllers/specialities.new.php';
	} else if( $page == '/especialidades/editar' ) {
		require './controllers/specialities.edit.php';
	} else if( $page == '/especialidades/borrar' ) {
		require './controllers/specialities.remove.php';

// *** OBRA SOCIALES *** //
	} else if( $page == '/obras-sociales' ) {
		require './controllers/insurances.php';
	} else if( $page == '/obras-sociales/crear' ) {
		require './controllers/insurances.new.php';
	} else if( $page == '/obras-sociales/editar' ) {
		require './controllers/insurances.edit.php';
	} else if( $page == '/obras-sociales/borrar' ) {
		require './controllers/insurances.remove.php';
	}
	

?>