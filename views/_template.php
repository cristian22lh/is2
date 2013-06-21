<?php
	
// ************** /
// ESTAS FUNCIONES SE USAN EN LAS VIEWS
// ************* /
	function t_startHead( $page ) {
		global $PWD;
		require $PWD . '/views/_head.start.php';
	}
	
	function t_endHead() {
		global $PWD;
		require $PWD . '/views/_head.end.php';
	}
	
	function t_startBody( $username, $currentTab ) {
		global $PWD;
		require $PWD . '/views/_body.start.php';
	}
	
	function t_endBody() {
		global $PWD;
		require $PWD . '/views/_body.end.php';
	}
	
	function t_startWrapper() {
		global $PWD;
		require $PWD . '/views/_wrapper.start.php';
	}
	
	function t_endWrapper() {
		global $PWD;
		require $PWD . '/views/_wrapper.end.php';
	}
	
	function t_dateMenu() {
		global $PWD;
		require $PWD . '/views/_appointments.date.menu.php';
	}
	
	function t_timeMenu() {
		global $PWD;
		require $PWD . '/views/_appointments.time.menu.php';
	}
	
	function t_statusMenu() {
		global $PWD;
		require $PWD . '/views/_appointments.status.menu.php';
	}
	
	function t_appointmentNewRow( $appointmentDateLocale ) {
		global $PWD;
		require $PWD . '/views/_appointments.row.new.php';
	}
	
	function t_lastNameMenu( $orderByType ) {
		global $PWD;
		require $PWD . '/views/_patients.lastname.menu.php';
	}
	
	function t_firstNameMenu( $orderByType ) {
		global $PWD;
		require $PWD . '/views/_patients.firstname.menu.php';
	}

	function t_birthDateMenu( $orderByType ) {
		global $PWD;
		require $PWD . '/views/_patients.birthname.menu.php';
	}
	
	function t_setCustomTypeface() {
		global $PWD;
		require $PWD . '/views/_custom.fontface.php';
	}

?>