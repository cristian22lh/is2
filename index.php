<?php

	// con este variable puedo tirale mensaje a FirePHP
	// https://addons.mozilla.org/en-US/firefox/addon/firephp
	// los mensajes se tiran llamando a la funcion __log( 'message' );
	$DEBUG = true;
	
	require './assets/db.php';
	require './assets/router.php';
	// las funciones helpers tienen como prefijo __
	require './assets/helpers.php';
	// las funciones template tienen como prefijo t_
	require './views/_template.php';
	// las queries tienen como prefijo q_
	require './assets/queries.php';
	// mis globales
	$g_db = new DB();
	$g_router = new Router();
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
	
	$routes = array(
		'/' => 'login',
		'/iniciar-sesion' => 'login',
		'/cerrar-sesion' => 'logout',
		
// *** TURNOS *** //
		'/turnos' => 'appointments',
		'/turnos/confirmar' => 'appointments.confirm',
		'/turnos/cancelar' => 'appointments.cancel',
		'/turnos/borrar' => 'appointments.remove',
		'/turnos/reiniciar' => 'appointments.reset',
		'/turnos/buscar' => 'appointments.search',
		'/turnos/crear' => 'appointments.new',

// *** MEDICOS *** //
		'/medicos/comprobar-horarios-disponibilidad' => 'doctors.check.availability',
		
// *** PACIENTES *** //
		'/pacientes' => 'patients',
		'/pacientes/buscar/dni' => 'patients.search.dni',
		'/pacientes/borrar' => 'patients.remove',
		'/pacientes/crear' => 'patients.new',
		'/pacientes/editar/:id' => 'patients.edit',

// *** ESPECIALIDADES *** //
		'/especialidades' => 'specialities',
		'/especialidades/crear' => 'specialities.new',
		'/especialidades/editar' => 'specialities.edit',
		'/especialidades/borrar' => 'specialities.remove',

// *** OBRA SOCIALES *** //
		'/obras-sociales' => 'insurances',
		'/obras-sociales/crear' => 'insurances.new',
		'/obras-sociales/editar' => 'insurances.edit',
		'/obras-sociales/borrar' => 'insurances.remove'
	);
	
	foreach( $routes as $route => $model ) {
		if( $g_router->test( $route, $page ) ) {
			$path = './models/' . $model . '.php';
			if( !file_exists( $path ) ) {
				die( 'Specified model "' . $model . '" does not exists at "' . $path . '"' );
			}
			require $path;
		}
	}

?>