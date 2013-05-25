<?php
	
// ************** /
// ESTAS FUNCIONES SE USAN EN LAS VIEWS
// ************* /
	function t_headerTag( $username, $currentTab ) {
		echo <<<HEADER
		<header>
			<h1>Climedis</h1>
			<div class="alert alert-info is2-welcome">
				Hola, <strong>$username</strong>
				<a href="/cerrar-sesion" class="btn btn-info btn-mini">Salir</a>
			</div>
			<nav class="navbar">
				<div class="navbar-inner">
					<ul class="nav">
HEADER;
			echo 		'<li class="' . ( $currentTab == 'appointments' ? 'active' : '' ) . '">' .
							'<a href="/turnos">Turnos</a>' .
						'</li>';
			echo			'<li class="' . ( $currentTab == 'doctors' ? 'active' : '' ) . '">' .
							'<a href="/medicos">Médicos</a>' .
						'</li>';
			echo			'<li class="' . ( $currentTab == 'patients' ? 'active' : '' ) . '">' .
							'<a href="/pacientes">Pacientes</a>' .
						'</li>';
			echo			'<li class="' . ( $currentTab == 'insurances' ? 'active' : '' ) . '">' .
							'<a href="/obras-sociales">Obras sociales</a>' .
						'</li>';
			echo			'<li class="' . ( $currentTab == 'speciality' ? 'active' : '' ) . '">' .
							'<a href="/especialidades">Especialidades</a>' .
						'</li>';
			echo <<<HEADER
					</ul>
				</div>
			</nav>
		</header>
HEADER;
	}
	
	function t_footerTag() {
		echo <<<FOOTER
		<footer>
			<img src="/img/logo.footer.png">
			<span>Todos los derechos reservados &copy; 2013</span>
		</footer>
FOOTER;
	}
	
	function t_ascDescMenu( $fieldName ) {
		echo <<<DROPDOWNMENU
		<div class="is2-ascdescmenu btn btn-mini btn-group">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a tabindex="-1" href="#" class="is2-trigger-orderby" data-field-name="$fieldName" data-orderby="asc">Ordernar vía ascendente</a>
				</li>
				<li>
					<a tabindex="-1" href="#" class="is2-trigger-orderby" data-field-name="$fieldName" data-orderby="desc">Ordernar vía descendente</a>
				</li>
			</ul>
		</div>
DROPDOWNMENU;
	}
	
	function t_statusMenu() {
		echo <<<DROPDOWNMENU
		<div class="is2-statusmenu btn btn-mini btn-group">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a tabindex="-1" href="#" class="is2-trigger-status" data-field-name="estado" data-field-value="confirmados">Mostrar solo turnos confirmados</a>
				</li>
				<li>
					<a tabindex="-1" href="#" class="is2-trigger-status" data-field-name="estado" data-field-value="cancelados">Mostrar solo turnos cancelados</a>
				</li>
				<li>
					<a tabindex="-1" href="#" class="is2-trigger-status" data-field-name="estado" data-field-value="todos">Mostrar todos los turnos</a>
				</li>
			</ul>
		</div>
DROPDOWNMENU;
	}

?>