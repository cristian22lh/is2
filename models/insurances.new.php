<?php

	if( !__issetPOST( array( 'abbr', 'full' ) ) ) {
		__redirect( '/obras-sociales?error=crear-obra-social' );
	}
	
	$abbr = __sanitizeValue( $_POST['abbr'] );
	$full = __sanitizeValue( $_POST['full'] );
	if( !$abbr || !$full ) {
		__redirect( '/obras-sociales?error=crear-obra-social' );
	}
	
	$insertId = DB::insert(
		'
			INSERT INTO
				obrasSociales
			VALUES
				( null, ?, ?, ? )
		',
		array( strtolower( $abbr ), $full, 'habilitada' )
	);
	
	// maybe a constraint error
	if( !$insertId ) {
		__redirect( '/obras-sociales?error=crear-obra-social' );
	}
	
	__redirect( '/obras-sociales?exito=crear-obra-social&id=' . $insertId );
	
?>
