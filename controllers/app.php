<?php

	// lo mando a login
	if( !__isUserLogged() ) {
		__redirect( '/' );
	}
	
	// render
	require './views/app.php';

?>