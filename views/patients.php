<?php t_startHead( 'Pacientes' ); ?>
		<style>
			label {
				cursor: default;
			}
			th {
				text-align: center !important;
				vertical-align: middle !important;
			}
			th:nth-child( 1 ),
			th:nth-child( 2 ) {
				width: 164px;
			}
			th:nth-child( 4 ) {
				width: 105px;
				text-align: left !important;
			}
			th:nth-child( 4 ) > span {
				display: inline-block;
				text-align: center;
				width: 77px;
			}
			th:nth-child( 4 ) .is2-dropdownmenu {
				position: relative;
				top: -10px;
			}
			th:nth-child( 5 ) {
				width: 80px;
			}
			td {
				text-align: center !important;
				font-size: 13px;
			}
			td span {
				display: block;
				word-wrap: break-word;
			}
			td:nth-child( 1 ) span,
			td:nth-child( 2 ) span {
				width: 155px;
				text-align: left;
			}
			td:nth-child( 3 ) {
				width: 65px;
			}
			td:nth-child( 4 ) {
				width: 65px;
			}
			td:nth-child( 5 ) {
				width: 100px;
			}
			td:nth-child( 6 ) span {
				width: 150px;
				text-align: left;
			}
			td:nth-child( 7 ) span {
				width: 100px;
				text-transform: uppercase;
			}
			td:nth-child( 8 ) span {
				width: 130px;
			}
			td:nth-child( 9 ) span {
				text-align: center;
			}
			td:last-child {
				width: 95px;
			}
			.pagination {
				margin: 20px 0 10px 0;
			}
			.pager {
				margin: 20px 0 0 0;
			}
			
			.is2-search-trigger {
				float: right;
				margin: 0 0 10px;
			}
			.is2-insurances-listbox {
				margin: 0 0 0 10px;
			}
		</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'patients'  ); ?>
	
		<?php t_startWrapper(); ?>
			<?php if( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El paciente junto con sus turnos asociados han sido borrados satisfactoriamente!
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido borrar al paciente! Vuelva a intentarlo.
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>No existe paciente con tal identificador cargado en el sistema.</strong>
			</div>
			<?php endif; ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Pacientes</h3>
				<a class="btn pull-right btn-warning" href="/pacientes/crear"><i class="icon-plus"></i> Crear un nuevo paciente</a>
			</div>
			
			<div id="is2-search-patients-wrapper" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" href="#is2-search-patients" data-parent="#is2-search-patients-wrapper">
							Búsqueda avanzada...
						</a>
					</div>
					<div id="is2-search-patients" class="accordion-body collapse in">
						<form class="accordion-inner" method="post" action="/pacientes/busqueda-avanzada">
							<div class="alert">
								Sepa que puede combinar los campos entre si para realizar búsquedas más precisas
							</div>
							<div class="alert alert-info">
								Deje en blanco los campos que los cuales no desea filtrar la búsqueda de pacientes
							</div>
							<fieldset>
								<legend>Buscar pacientes con apellidos</legend>

								<label>Apellidos:</label>
								<input type="text" class="input-xxlarge" name="" value="" placeholder="Para buscar por varios apellidos simplemente separelos con una , (coma)">
							</fieldset>
							<fieldset>
								<legend>Buscar pacientes con nombres</legend>
								<label>Nombres:</label>
								<input type="text" class="input-xxlarge" name="" value="" placeholder="Para buscar por varios nombres simplemente separelos con una , (coma)">
							</fieldset>
							<fieldset>
								<legend>Buscar pacientes con numero de DNI</legend>
								<label>Número de DNI:</label>
								<input type="text" class="input-xxlarge" name="" value="" placeholder="Para buscar por varios números de DNI simplemente separelos con un espacio">
							</fieldset>
							<fieldset class="form-inline">
								<legend>Buscar pacientes con fecha de nacimiento entre</legend>
								<div class="alert alert-info">
									Puede optar por dejar un limite vacío para realizar una busqueda sin limite superior/inferior
								</div>
								<label>Desde:
									<input type="text" class="input-small datepicker" name="" value="">
								</label>
								<label>hasta:
									<input type="text" class="input-small datepicker" name="" value="">
								</label>
							</fieldset>
							<fieldset>
								<legend>Buscar pacientes con obra social</legend>
								<label class="radio">
									<input type="radio" name="insuranceSearch">Incluir todas las obras sociales
								</label>
								<label class="radio">
									<input type="radio" name="insuranceSearch">Solo los pacientes con las obras sociales...
								</label>
								<div class="is2-insurances-listbox alert alert-info">
								<?php foreach( $insurances as $insurance ): ?>
									<label class="checkbox">
										<input type="checkbox" name="doctorsList[]" value="<?php echo $insurance['id']; ?>">
										<?php echo $insurance['nombreCorto'] . ' (' . $insurance['nombreCompleto'] . ')'; ?>
									</label>
								<?php endforeach; ?>
								</div>
							</fieldset>
							<fieldset>
								<legend>Buscar pacientes con número de afiliado</legend>
								<input type="text" class="input-xxlarge" name="" value="" placeholder="Separe con espacios para buscar por varios números de afiliado">
							</fieldset>
							<button type="submit" class="btn btn-large btn-primary is2-search-trigger">Buscar</button>
						</form>
					</div>
				</div>
			</div>
			
			<div class="pagination pagination-centered">
				<ul>
			<?php foreach( range( 'A', 'Z' ) as $char ): ?>
					<li class="<?php echo $char == $letter ? 'active' : ''; ?>">
						<a class="" href="/pacientes/listar-por-letra/<?php echo $char; ?>"><?php echo $char; ?></a>
					</li>
			<?php endforeach; ?>
				</ul>
			</div>
			
			<?php if( count( $patients ) ): ?>
			<table class="table is2-grid-header btn-inverse">
				<thead>
					<tr>
						<th>
							Apellidos
							<?php t_lastNameMenu(); ?>
						</th>
						<th>
							Nombres
							<?php t_firstNameMenu(); ?>
						</th>
						<th>DNI</th>
						<th>
							<span>Fecha de</span>
							nacimiento
							<?php t_birthDateMenu(); ?>
						</th>
						<th>Teléfono</th>
						<th>Obra social</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<div class="is2-grid-wrapper">
				<table class="table is2-grid">
					<tbody>
					<?php foreach( $patients as $patient ): ?>
						<tr data-patient-id="<?php echo $patient['id']; ?>">
							<td>
								<span title="<?php echo $patient['apellidos']; ?>"><?php echo $patient['apellidos']; ?></span>
							</td>
							<td>
								<span title="<?php echo $patient['nombres']; ?>"><?php echo $patient['nombres']; ?></span>
							</td>
							<td><?php echo $patient['dni']; ?></td>
							<td><?php echo __dateISOToLocale( $patient['fechaNacimiento'] ); ?></td>
							<td>
								<span title="<?php echo $patient['telefono']; ?>"><?php echo $patient['telefono']; ?></span>
							</td>
							<td>
								<span title="<?php echo $patient['obraSocialNombre']; ?>"><?php echo $patient['obraSocialNombre']; ?></span>
							<td>
								<a class="btn btn-mini" href="/pacientes/<?php echo $patient['id']; ?>/ver-en-detalle" title="Ver en detalle"><i class="icon-eye-open"></i></a>
								<a class="btn btn-mini" href="/pacientes/<?php echo $patient['id']; ?>/editar" title="Editar"><i class="icon-edit"></i></a>
								<a class="btn btn-mini btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-patient-id="<?php echo $patient['id']; ?>"><i class="icon-remove-sign" title="Borrar"></i></a>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			
			<?php if( !$isSingle ): ?>
			<ul class="pager">
				<li class="previous <?php echo $offset ? 'active': 'disabled'; ?>">
					<a href="<?php echo $offset == 0 ? '#' : $queryString . '&pagina=' . ($offset-1); ?>">&larr; Anterior</a>
				</li>
				<li class="next <?php echo $stillMorePages ? 'active': 'disabled'; ?>">
					<a href="<?php echo $stillMorePages ? $queryString . '&pagina=' . ($offset+1) : '#'; ?>">Siguiente &rarr;</a>
				</li>
			</ul>
			<?php endif; ?>
			
			<?php else: ?>
			<div class="alert alert-error">
				No se han encontrado pacientes según el criterio de búsqueda específicado
			</div>
			<?php endif; ?>

		<?php t_endWrapper(); ?>
		
		<!-- los modals -->
		<form method="post" action="/pacientes/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea borrar este paciente del sistema?</strong> Sepa que también se eleminarán sus turnos asociados.</span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
<?php t_endBody(); ?>

<script>
(function() {
	$( '.is2-grid' ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove' ).find( 'input[name="id"]' ).val( $( this ).attr( 'data-patient-id' ) );
	} );
	
// *** CUANDO SE SORTEA LA GRID *** //
	var getQueryString = function() {
		// tiro un redirect
		var queryString = window.location.search.replace( /^\?/, '' ),
			segs = queryString ? queryString.split( '&' ) : [], seg,
			pat = /(?:(apellido|nombre|fecha-de-nacimiento)=(asc|desc)|(exito|error|pagina)=([^$]+))/,
			res = {}, m, q = [], prop;
		
		while( segs.length ) {
			seg = segs.shift();
			m = pat.exec( seg );
			if( m ) {
				res[m[1] || m[3]] = m[2] || m[4];
			}
		}
		
		q = [];
		for( prop in res ) {
			q.push( prop + '=' + res[prop] );
		}
		
		return q.length ? q.join( '&' ) + '&' : '';
	};
	
	$( '.is2-dropdownmenu-trigger' ).on( 'click', function( e ) {
		e.preventDefault();
		var $el = $( this ),
			fieldName = $el.attr( 'data-field-name' ),
			orderBy = $el.attr( 'data-orderby' );
			
		window.location = window.location.pathname + '?' + getQueryString() + fieldName + '=' + orderBy;
	} );
})();
</script>