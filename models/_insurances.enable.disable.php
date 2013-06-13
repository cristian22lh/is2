<?php

	function m_getInsuranceID() {
		if( !__issetPOST( array( 'id' ) ) ) {
			__echoJSON( array( 'success' => false ) );
		}
	
		$id = __validateID( $_POST['id'] );
		if( !$id ) {
			__echoJSON( array( 'success' => false ) );
		}
		
		return $id;
	}
	
	function m_changeInsuranceStatus( $id, $status ) {
		$rowsAffected = DB::update(
			'
				UPDATE
					obrasSociales
				SET
					estado = ?
				WHERE
					id = ?
			',
			array( $status, $id )
		);
		
		if( !$rowsAffected ) {
			__echoJSON( array( 'success' => false ) );
		}
	
		__echoJSON( array( 
			'success' => true,
			'data' => array(
				'id' => $id
			)
		) );
	}
	
?>