<?php

	__throw404Error();

	$targetPage = __sanitizeValue( __GETField( 'destino' ) );

	__render(
		'404',
		array(
			'targetPage' => $targetPage
		)
	);

?>