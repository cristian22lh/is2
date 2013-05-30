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
	// init some things
	__initSession();
	__initDebugging();
	// enforce utf8 output
	__forceUTF8Enconding();
	
	// veo adonde quiere ir el usuario
	$url = parse_url( $_SERVER['REQUEST_URI'] );
	$page = preg_replace( '/\/?index\.php\/?/', '/', $url['path'] );
	// hago a que no pueda acceder a una pagina que necesite
	// de que el usuario este logueado para verla
	$g_router->auth( $page, array( '/', '/iniciar-sesion' ), '/iniciar-sesion' );

	$routes = array(
		'/' => 'login',
		'/iniciar-sesion' => 'login',
		'/cerrar-sesion' => 'logout',
		'/404' => '404',
		
// *** TURNOS *** //
		'/turnos' => 'appointments',
		'/turnos/confirmar' => 'appointments.confirm',
		'/turnos/cancelar' => 'appointments.cancel',
		'/turnos/borrar' => 'appointments.remove',
		'/turnos/reiniciar' => 'appointments.reset',
		'/turnos/busqueda-rapida' => 'appointments.search.quick',
		'/turnos/busqueda-avanzada' => 'appointments.search.advanced',
		'/turnos/crear' => 'appointments.new',

// *** MEDICOS *** //
		'/medicos/comprobar-horarios-disponibilidad' => 'doctors.check.availability',
		
// *** PACIENTES *** //
		'/pacientes' => 'patients',
		'/pacientes/buscar/dni' => 'patients.search.dni',
		'/pacientes/borrar' => 'patients.remove',
		'/pacientes/crear' => 'patients.new',
		'/pacientes/:id/editar' => 'patients.edit',
		'/pacientes/listar-por-letra/:char' => 'patients',

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
	
	require $g_router->start( $routes, $page, '/404' );

?>