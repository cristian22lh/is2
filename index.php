<?php

	// con este variable puedo tirale mensaje a FirePHP
	// https://addons.mozilla.org/en-US/firefox/addon/firephp
	// los mensajes se tiran llamando a la funcion __log( 'message' );
	$DEBUG = true;
	
	require './assets/db.php';
	// las funciones helpers tienen como prefijo __
	require './assets/helpers.php';
	// las funciones template tienen como prefijo t_
	require './views/_template.php';
	// las queries tienen como prefijo q_
	require './assets/queries.php';
	// init
	$db = new DB();
	__initSession();
	__initDebugging();
	
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
		require './models/login.php';
	} else if( $page == '/cerrar-sesion' ) {
		require './models/logout.php';
	
// *** TURNOS *** //
	} else if( $page == '/turnos' ) {
		require './models/appointments.php';
	} else if( $page == '/turnos/confirmar' ) {
		require './models/appointments.confirm.php';
	} else if( $page == '/turnos/cancelar' ) {
		require './models/appointments.cancel.php';
	} else if( $page == '/turnos/borrar' ) {
		require './models/appointments.remove.php';
	} else if( $page == '/turnos/reiniciar' ) {
		require './models/appointments.reset.php';
	} else if( $page == '/turnos/buscar' ) {
		require './models/appointments.search.php';
	} else if( $page == '/turnos/crear' ) {
		require './models/appointments.new.php';

// *** MEDICOS *** //
	} else if( $page == '/medicos/comprobar-horarios-disponibilidad' ) {
		require './models/doctors.check.availability.php';
	
// *** PACIENTES *** //
	} else if( $page == '/pacientes' ) {
		require './models/patients.php';
	} else if( $page == '/pacientes/buscar/dni' ) {
		require './models/patients.search.dni.php';
	} else if( $page == '/pacientes/borrar' ) {
		require './models/patients.remove.php';
	} else if( $page == '/pacientes/crear' ) {
		require './models/patients.new.php';
	
// *** ESPECIALIDADES *** //
	} else if( $page == '/especialidades' ) {
		require './models/specialities.php';
	} else if( $page == '/especialidades/crear' ) {
		require './models/specialities.new.php';
	} else if( $page == '/especialidades/editar' ) {
		require './models/specialities.edit.php';
	} else if( $page == '/especialidades/borrar' ) {
		require './models/specialities.remove.php';

// *** OBRA SOCIALES *** //
	} else if( $page == '/obras-sociales' ) {
		require './models/insurances.php';
	} else if( $page == '/obras-sociales/crear' ) {
		require './models/insurances.new.php';
	} else if( $page == '/obras-sociales/editar' ) {
		require './models/insurances.edit.php';
	} else if( $page == '/obras-sociales/borrar' ) {
		require './models/insurances.remove.php';
	}
	

?>