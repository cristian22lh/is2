<?php

	if( !__issetPOST( array( 'keyword' ) ) ) {
		__redirect( '/pacientes?error=buscar-paciente-rapido' );
	}
	
	$keyword = __sanitizeValue( $_POST['keyword'] );
	if( !$keyword ) {
		__redirect( '/pacientes?error=buscar-paciente-rapido' );
	}
	
	// es una fecha ?
	if( ( $value = __toISODate( $keyword ) ) ) {
		$field = 'fechaNacimiento';
		
	// es un dni ?
	} else if( ( $value = __cleanDNI( $keyword ) ) || ( $value = __cleanTel( $keyword ) ) ) {
		$field = 'dni|telefono';
	
	// es un "lopez, marcos" ?
	} else if( ( $value = explode( ',', $keyword ) ) && count( $value ) == 2 ) {
		$field = 'fullname';
		$value = $keyword;

	// aca es tanto un nombre, apellido o nombre de la obra social
	} else {
		$field = 'comodin';
		$value = trim( $keyword );
	}
	
	__redirect( '/pacientes?busqueda=' . base64_encode( $field . '=' . $value ) );
	
?>