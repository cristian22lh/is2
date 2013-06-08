<?php

	$doctorID = Router::seg( 2 );
	
	if( !__issetPOST( array( 'start', 'end' ) ) ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$start = $_POST['start'];
	$startISODate = __toISODate( $start );
	$end = $_POST['end'];
	$endISODate = __toISODate( $end );
	if( !$startISODate || !$endISODate ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	$insertId = DB::insert( 
		'
			INSERT INTO
				licencias
			VALUES
				( null, ?, ?, ? )
		',
		array( $doctorID, $startISODate, $endISODate )
	);
	
	if( $insertId <= 0 ) {
		__echoJSON( array( 'success' => false ) );
	}
	
	__echoJSON( array( 
		'success' => true,
		'data' => array(
			'start' => $start,
			'end' => $end
		)
	) );

	
?>