<?php t_startHead( 'Turnos' ); ?>

	<style>
		.is2-ascdescmenu, .is2-statusmenu {
			float: right;
			padding: 0;
		}
		.is2-ascdescmenu a.dropdown-toggle,
		.is2-statusmenu a.dropdown-toggle {
			padding: 0 6px;
			display: inline-block;
		}
		.is2-statusmenu .dropdown-menu {
			right: 0;
			left: inherit;
		}

		.is2-search-trigger {
			float: right;
			margin: 0 0 10px 0;
		}
		.is2-doctors-listbox {
			min-height: 150px;
		}
		.bootstrap-timepicker {
			display: inline-block;
		}
	</style>
		
<?php t_endHead(); ?>
<?php t_startBody( $username, 'appointments'  ); ?>

		<?php t_startWrapper(); ?>
			<?php if( $confirmSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido confirmado satisfactoriamente!
			</div>
			<?php elseif( $confirmError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido confirmar el turno! Vuelva a intentarlo.
			</div>
			<?php elseif( $cancelSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido cancelado satisfactoriamente!
			</div>
			<?php elseif( $cancelError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido cancelar el turno! Vuelva a intentarlo.
			</div>
			<?php elseif( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido borrado satisfactoriamente!
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido borar el turno! Vuelva a intentarlo.
			</div>
			<?php elseif( $resetSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido reiniciado satisfactoriamente!
			</div>
			<?php elseif( $resetError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido reiniciar el turno! Vuelva a intentarlo.
			</div>
			<?php elseif( $searchError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido realizar la búsqueda! Vuelva a intentarlo.
			</div>
			<?php endif; ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Turnos</h3>
				<a class="btn pull-right" href="/turnos/crear"><i class="icon-plus"></i> Crear un nuevo turno</a>
			</div>
			
			<div id="is2-search-appointments-wrapper" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" href="#is2-search-appointments" data-parent="#is2-search-appointments-wrapper">
							Buscar turnos...
						</a>
					</div>
					<div id="is2-search-appointments" class="accordion-body collapse<?php echo $searchError ? ' in ' : ' out'; ?>">
						<form class="accordion-inner" method="post" action="/turnos/buscar">
							<fieldset class="form-inline">
								<legend>Rango de fechas</legend>
								<div class="alert alert-info">
									Deje en blanco estos campos, si no desea buscar por rango de fechas
								</div>
								<label>Desde:
									<input type="text" class="input-small datepicker" name="fromDate" value="<?php echo __dateISOToLocale( __sanitizeValue( $persistValues['fromDate'] ) ); ?>">
								</label>
								<label>hasta:
									<input type="text" class="input-small datepicker" name="toDate" value="<?php echo __dateISOToLocale( __sanitizeValue( $persistValues['toDate'] ) ); ?>">
								</label>
							</fieldset>
							<fieldset class="form-inline">
								<legend>Rango de horas</legend>
								<div class="alert alert-info">
									Deje en blanco estos campos, si no desea buscar por rango de horas
								</div>
								<div class="bootstrap-timepicker">
									<label>Desde:
										<input type="text" class="input-mini timepicker" name="fromTime" value="<?php echo __timeISOToLocale( __sanitizeValue( $persistValues['fromTime'] ) ); ?>">
									</label>
								</div>
								<div class="bootstrap-timepicker">
									<label>hasta:
										<input type="text" class="input-mini timepicker" name="toTime" value="<?php echo __timeISOToLocale( __sanitizeValue( $persistValues['toTime'] ) ); ?>">
									</label>
								</div>
							</fieldset>
							<fieldset>
								<legend>Médicos</legend>
								<label class="radio">
									<input type="radio" name="doctorsSearch" value="all" class="is2-doctors-all" <?php echo !count( $persistValues['doctorsList'] ) ? 'checked' : ''; ?>>
									Todos
								</label>
								<label class="radio">
									<input type="radio" name="doctorsSearch" value="custom" class="is2-doctors-custom" <?php echo count( $persistValues['doctorsList'] ) ? 'checked' : ''; ?>>
									Solos los turnos que tenga asociados estos médicos...
								</label>
								<select multiple="multiple" class="input-xxlarge is2-doctors-listbox" name="doctorsList[]">
								<?php foreach( $doctors as $doctor ): ?>
									<option value="<?php echo $doctor['id']; ?>" <?php echo isset( $persistValues['doctorsList'][$doctor['id']] ) ? 'selected' : ''; ?>><?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?></option>
								<?php endforeach; ?>
								</select>
								<div class="alert alert-info">
									Mantenga apretada la tecla <strong>Ctrl (Control)</strong> para seleccionar multíples médicos a la vez cada vez que hace click sobre el nombre de algun médico
								</div>
							</fieldset>
							<fieldset>
								<legend>Pacientes</legend>
								<label class="radio">
									<input type="radio" name="patientsSearch" value="" <?php echo !$persistValues['patientsDNI'] ? 'checked' : ''; ?>>
									Todos
								</label>
								<label class="radio">
									<input type="radio" name="patientsSearch" value="custom" class="is2-patients-custom" <?php echo $persistValues['patientsDNI'] ? 'checked' : ''; ?>>
									Solos los turnos que tenga asociados estos pacientes con DNI...
								</label>
								<input class="input-xxlarge is2-patients-search" type="text" placeholder="Separe con espacios cada DNI de los pacientes" name="patientsList" value="<?php echo __sanitizeValue( $persistValues['patientsDNI'] ); ?>">
								<div class="alert alert-info">
									Si desea buscar varios pacientes a la vez, ingrese los DNI en cuestión separados por espacios, por ejemplo: <strong>7.432.211 4.533.667 7.667.888</strong> <em>(no es necesario que los escriba con puntos)</em>
								</div>
							</fieldset>
							<fieldset>
								<legend>Estado del turno</legend>
								<label class="radio">
									<input type="radio" name="status" value="" <?php echo !$persistValues['status'] ? 'checked' : ''; ?>>
									Mostrar todos los turnos
								</label>
								<label class="radio">
									<input type="radio" name="status" value="confirmados" <?php echo $persistValues['status'] == 'confirmados' ? 'checked' : ''; ?>>
									Mostrar solo los turnos que estén confirmados
								</label>
								<label class="radio">
									<input type="radio" name="status" value="cancelados" <?php echo $persistValues['status'] == 'cancelados' ? 'checked' : ''; ?>>
									Mostrar solo los turnos que estén cancelados
								</label>
							</fieldset>
							
							<button type="submit" class="btn btn-large btn-primary is2-search-trigger">Buscar</button>
						</form>
					</div>
				</div>
			</div>
			
			<?php if( $currentDate ): ?>
			<div class="alert">
				Se muestran los turnos desde día presente (<strong><?php echo $currentDate; ?></strong>) hasta los próximos 7 días.
			</div>
			<?php endif; ?>
			
			<?php if( count( $appointments ) ): ?>
			<table class="table table-striped is2-grid">
				<thead>
					<tr>
						<th>
							Fecha
							<?php t_ascDescMenu( 'fecha' ); ?>
						</th>
						<th>
							Hora
							<?php t_ascDescMenu( 'hora' ); ?>
						</th>
						<th>
							Médico
							<?php t_ascDescMenu( 'medico' ); ?>
						</th>
						<th>
							Paciente
							<?php t_ascDescMenu( 'paciente' ); ?>
						</th>
						<th>
							Acciones
							<?php t_statusMenu(); ?>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach( $appointments as $appointment ): ?>
					<tr data-appointment-id="<?php echo $appointment['id']; ?>">
						<td><?php echo date( 'd/m/Y', strtotime( $appointment['fecha'] ) ); ?></td>
						<td><?php echo substr( $appointment['hora'], 0, 5 ); ?></td>
						<td><?php echo $appointment['medicoApellidos'] . ', ' .  $appointment['medicoNombres']; ?></td>
						<td><?php echo $appointment['pacienteApellidos'] . ', ' .  $appointment['pacienteNombres']; ?></td>
						<td>
						<?php if( $appointment['estado'] == 'confirmado' ): ?>
							<button class="btn btn-success disabled"><i class="icon-ok"></i> Confirmado</button>
							<a class="btn btn-mini btn-link is2-trigger-restore" href="#is2-modal-restore" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>">Deshacer acción</a>
						<?php elseif( $appointment['estado'] == 'cancelado' ): ?>
							<button class="btn btn-warning disabled"><i class="icon-exclamation-sign"></i> Cancelado</button>
							<a class="btn btn-mini btn-link is2-trigger-restore" href="#is2-modal-restore" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>">Deshacer acción</a>
						<?php else: ?>
							<a class="btn is2-trigger-confirm" href="#is2-modal-confirm" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>">Confirmar</a>
							<a class="btn is2-trigger-cancel" href="#is2-modal-cancel" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>">Cancelar</a>
							<a class="btn btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>">Borrar</a>
						</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php else: ?>
			<div class="alert alert-error">
				No se han encontrado turnos según el criterio de búsqueda específicado
			</div>
			<?php endif; ?>

		<?php t_endWrapper(); ?>
		
		<!-- modals -->
		<form method="post" action="/turnos/confirmar" id="is2-modal-confirm" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que confirmar el turno?</strong></span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">No</button>
				<button class="btn btn-primary" type="submit">Sí</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<form method="post" action="/turnos/cancelar" id="is2-modal-cancel" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea cancelar el turno?</strong></span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">No</button>
				<button class="btn btn-primary" type="submit">Sí</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<form method="post" action="/turnos/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea borrar el turno?</strong></span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">No</button>
				<button class="btn btn-primary" type="submit">Sí</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<form method="post" action="/turnos/reiniciar" id="is2-modal-restore" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>Sepa que si confirma, el turno volverá a su estado original, ¿desea continuar?</strong></span>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">No</button>
				<button class="btn btn-primary" type="submit">Sí</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
<?php t_endBody(); ?>

<script>
(function() {
// *** ACA PARA CUANDO MUESTRO LOS MODALS *** //
	$( '.is2-grid' ).delegate( '.is2-trigger-confirm', 'click', function( e ) {
		// hay que poner el turno id en input hidden
		$( '#is2-modal-confirm input' ).val( $( this ).attr( 'data-appointment-id' ) );
	
	} ).delegate( '.is2-trigger-cancel', 'click', function( e ) {
		$( '#is2-modal-cancel input' ).val( $( this ).attr( 'data-appointment-id' ) );
	
	} ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove input' ).val( $( this ).attr( 'data-appointment-id' ) );
		
	} ).delegate( '.is2-trigger-restore', 'click', function( e ) {
		$( '#is2-modal-restore input' ).val( $( this ).attr( 'data-appointment-id' ) );
	} );
// *** ACA PARA CUANDO SORTEO LA GRID *** //
	$( '.is2-trigger-orderby' ).on( 'click', function( e ) {
		e.preventDefault();
		var $el = $( this ),
			fieldName = $el.attr( 'data-field-name' ),
			orderBy = $el.attr( 'data-orderby' ),
			res = getQueryString();

		window.location = '/turnos?' + ( res.length ? res.join( '&' ) + '&' : '' ) + fieldName + '=' + orderBy;
	} );
	
	$( '.is2-trigger-status' ).on( 'click', function( e ) {
		e.preventDefault();
		var $el = $( this ),
			fieldName = $el.attr( 'data-field-name' ),
			fieldValue = $el.attr( 'data-field-value' ),
			res = getQueryString();
			
		window.location = '/turnos?' + ( res.length ? res.join( '&' ) + '&' : '' ) + fieldName + '=' + fieldValue;
	} );
	
	var getQueryString = function() {
		// tiro un redirect
		var queryString = window.location.search.replace( /^\?/, '' ),
			segs = queryString ? queryString.split( '&' ) : [], seg,
			pat = /(?:(?:fecha|hora|medico|paciente)=(?:asc|desc)|estado=(?:confirmados|cancelados)|(?:exito|error)=[^$]+)/,
			res = [];
		
		while( segs.length ) {
			seg = segs.shift();
			if( !pat.test( seg ) ) {
				res.push( seg );
			}
		}
		
		return res;
	};
	
// *** ACA PARA LA BUSQUEDA DE TURNOS *** //
	$( '.datepicker' ).datepicker( {
		format: 'dd/mm/yyyy',
		language: 'es'
	} );
	$( '.timepicker' ).timepicker( {
		showInputs: false,
		disableFocus: true,
		defaultTime: false
	});
	$( '.is2-doctors-listbox' ).on( 'click', function( e ) {
		$( '.is2-doctors-custom' ).click();
	} );
	$( '.is2-doctors-all' ).on( 'click', function( e ) {
		$( '.is2-doctors-listbox' )[0].selectedIndex = -1;
	} );
	$( '.is2-patients-search' ).on( 'click', function( e ) {
		$( '.is2-patients-custom' ).click();
	} );
	
})();
</script>