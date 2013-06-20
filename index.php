<?php

	// con este variable puedo tirale mensaje a FirePHP
	// https://addons.mozilla.org/en-US/firefox/addon/firephp
	// los mensajes se tiran llamando a la funcion __log( 'message' );
	$DEBUG = true;
	if( $DEBUG ) {
		ini_set( 'display_errors', 1 );
		ini_set( 'display_startup_errors', 1 );
		error_reporting( -1 );
	}
	
	$PWD = getcwd();
	require $PWD . '/assets/db.php';
	require $PWD . '/assets/router.php';
	// las funciones helpers tienen como prefijo __
	require $PWD . '/assets/helpers.php';
	// las funciones template tienen como prefijo t_
	require $PWD . '/views/_template.php';
	// las queries tienen como prefijo q_
	require $PWD . '/assets/common.queries.php';
	// init some things
	DB::init();
	Router::init();
	__initSession();
	__initMinifyingProcess();

	// enforce utf8 output
	__forceUTF8Enconding();
	
	// hago a que no pueda acceder a una pagina que necesite
	// de que el usuario este logueado para verla
	Router::auth( array( '/', '/iniciar-sesion' ), '/iniciar-sesion' );

	$routes = array(
		'/' => 'login',
		'/iniciar-sesion' => 'login',
		'/cerrar-sesion' => 'logout',
		'/404' => '404',
		
// *** TURNOS *** //
		'/turnos' => 'appointments',
		'/turnos/:id/confirmar' => 'appointments.confirm',
		'/turnos/:id/cancelar' => 'appointments.cancel',
		'/turnos/:id/borrar' => 'appointments.remove',
		'/turnos/:id/reiniciar' => 'appointments.reset',
		'/turnos/crear' => 'appointments.new',
		'/turnos/exportar/excel' => 'appointments.export.excel',
		'/turnos/exportar/imprimir' => 'appointments.export.print',
		'/turnos/exportar/pdf' =>  'appointments.export.pdf',

// *** MEDICOS *** //
		'/medicos/comprobar-horarios-disponibilidad' => 'doctors.check.availability',
		'/medicos' => 'doctors',
		'/medicos/:id' => 'doctors.details',
		'/medicos/:id/crear-horario' => 'doctors.availability.new',
		'/medicos/:id/borrar-horario' => 'doctors.availability.remove',
		'/medicos/:id/actualizar-obras-sociales-admitidas' => 'doctors.insurances.update',
		'/medicos/:id/turnos' => 'doctors.appointments',
		'/medicos/:id/crear-licencia' => 'doctors.license.new',
		'/medicos/:id/licencias' => 'doctors.license',
		'/medicos/:id/borrar-licencia' => 'doctors.license.remove',
		'/medicos/crear' => 'doctors.new',
		'/medicos/:id/editar' => 'doctors.edit',
		'/medicos/:id/borrar' => 'doctors.remove',
		
// *** PACIENTES *** //
		'/pacientes' => 'patients',
		'/pacientes/:id/borrar' => 'patients.remove',
		'/pacientes/crear' => 'patients.new',
		'/pacientes/:id/editar' => 'patients.edit',
		'/pacientes/listar-por-letra/:char' => 'patients',
		'/pacientes/:id' => 'patients.details',
		'/pacientes/buscar-para-turno' => 'patients.search.for.appointment',

// *** ESPECIALIDADES *** //
		'/especialidades' => 'specialities',
		'/especialidades/crear' => 'specialities.new',
		'/especialidades/:id/editar' => 'specialities.edit',
		'/especialidades/:id/borrar' => 'specialities.remove',

// *** OBRA SOCIALES *** //
		'/obras-sociales' => 'insurances',
		'/obras-sociales/crear' => 'insurances.new',
		'/obras-sociales/:id/editar' => 'insurances.edit',
		'/obras-sociales/:id/borrar' => 'insurances.remove',
		'/obras-sociales/:id/habilitar' => 'insurances.status',
		'/obras-sociales/:id/deshabilitar' => 'insurances.status'
	);
	
	require $PWD . '/models/' . Router::start( $routes, '/404' ) . '.php';

?>