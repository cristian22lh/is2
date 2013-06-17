<?php t_startHead( 'Turnos' ); ?>

	<style>
		.table th:first-child {
			width: 90px;
		}
		.is2-statusmenu .dropdown-menu {
			right: 0;
			left: inherit;
		}
		.btn-inverse .dropdown-toggle .caret {
			border-bottom-color: #000;
			border-top-color: #000;
		}

		.is2-search-trigger {
			float: right;
			margin: 0 0 10px 0;
		}
		
		.is2-doctors-listbox {
			margin: 0 0 0 10px;
		}
		.bootstrap-timepicker {
			display: inline-block;
		}
		
		tr.is2-appointments-dayrow td {
			background: #f1f1f1;
			font-weight: 600;
			color: #555;
			text-shadow: 0 -1px 0 #fff;
			text-transform: none !important;
		}
		tr.is2-appointments-newrow:first-of-type {	
			display: none;
		}
		tr.is2-appointments-newrow td {	
			padding: 2px;
			background: #fbfbfb;
		}
		a.is2-appointments-newtrigger {
			text-align: right;
			display: block;
		}
		tr.is2-appointments-row td:nth-child( 3 ),
		tr.is2-appointments-row td:nth-child( 4 ) {
			width: 220px;
		}
		tr.is2-appointments-row td:last-child {
			width: 205px;
			white-space: nowrap;
		}
		tr.is2-appointments-row td:last-child > div > .btn:not( :last-child ) {
			margin: 0 5px 0 0;
		}
		tr.is2-appointments-monthbreak td {
			background: #84d2db;
			border-bottom: 1px solid #defcff;
			border-top: 1px solid #fff;
			font-weight: 600;
			text-shadow: 0 -1px 0 #008494;
			color: #fff;
		}
		tr.is2-appointments-monthbreak:not( :first-child ) td {
			border-top: 0;
		}
		tr.is2-appointments-monthbreak td:nth-child( 3 ) {
			text-align: right;
		}
		tr.is2-appointments-monthbreak td:nth-child( 4 ) {
			text-align: left;
		}
		.btn.disabled {
			width: 110px;
		}
		/* overwrite new record style */
		.is2-record-new {
			border-bottom: 0;
		}
		
		.is2-doctor-img {
			border: 2px solid #84D2DB;
			border-radius: 20px;
			display: inline-block;
			margin: 0 5px 0 0;
		}
		
		.is2-appointments-export {
			border-radius: 0 0 5px 5px;
			padding: 5px;
		}
		.is2-appointments-export a {
			margin: 0 10px 0 0;
			vertical-align: middle;
		}
	</style>

<?php t_endHead(); ?>
<?php t_startBody( $username, 'appointments'  ); ?>

		<?php t_startWrapper(); ?>

			<div class="alert alert-success is2-confirm-success is2-ajax-msg">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido confirmado satisfactoriamente!
			</div>
			<div class="alert alert-error is2-confirm-error is2-ajax-msg">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido confirmar el turno! Vuelva a intentarlo.
			</div>
			<div class="alert alert-success is2-cancel-success is2-ajax-msg">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido cancelado satisfactoriamente!
			</div>
			<div class="alert alert-error is2-cancel-error is2-ajax-msg">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido cancelar el turno! Vuelva a intentarlo.
			</div>
			<div class="alert alert-success is2-remove-success is2-ajax-msg">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido borrado satisfactoriamente!
			</div>
			<div class="alert alert-error is2-remove-error is2-ajax-msg">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido borar el turno! Vuelva a intentarlo.
			</div>
			<div class="alert alert-success is2-restore-success is2-ajax-msg">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El turno ha sido reiniciado satisfactoriamente!
			</div>
			<div class="alert alert-error is2-restore-error is2-ajax-msg">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido reiniciar el turno! Vuelva a intentarlo.
			</div>
			<?php if( $searchError || $searchQuickError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido realizar la búsqueda! Vuelva a intentarlo.
			</div>
			<?php endif; ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Turnos</h3>
				<a class="btn pull-right btn-warning" href="/turnos/crear"><i class="icon-plus"></i> Crear un nuevo turno</a>
				<form class="form-search pull-right is2-search-quick-form">
					<div class="is2-search-quick-control input-append control-group <?php echo $searchQuickError ? 'error': ''; ?>">
						<input type="text" class="input-large search-query is2-search-quick-input" placeholder="Búsqueda rápida" name="keyword" value="<?php echo $quickSearchValue; ?>">
						<button type="submit" class="btn"><i class="icon-search"></i></button>
					</div>
				</form>
			</div>
			<div id="is2-search-appointments-wrapper" class="accordion">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" href="#is2-search-appointments" data-parent="#is2-search-appointments-wrapper">
							Búsqueda avanzada...
						</a>
					</div>
					<div id="is2-search-appointments" class="accordion-body collapse<?php echo $searchError ? ' in ' : ' out'; ?>">
						<form class="accordion-inner is2-search-advanced-form">
							<fieldset class="form-inline">
								<legend>Rango de fechas</legend>
								<div class="alert alert-info">
									Deje en blanco estos campos, si no desea buscar por rango de fechas
								</div>
								<label>Desde:
									<input type="text" class="input-small datepicker" name="fromDate" value="<?php echo __dateISOToLocale( $persistValues['fromDate'] ); ?>">
								</label>
								<label>hasta:
									<input type="text" class="input-small datepicker" name="toDate" value="<?php echo __dateISOToLocale( $persistValues['toDate'] ); ?>">
								</label>
							</fieldset>
							<fieldset class="form-inline">
								<legend>Rango de horas</legend>
								<div class="alert alert-info">
									Deje en blanco estos campos, si no desea buscar por rango de horas
								</div>
								<div class="bootstrap-timepicker">
									<label>Desde:
										<input type="text" class="input-mini timepicker" name="fromTime" value="<?php echo __timeISOToLocale( $persistValues['fromTime'] ); ?>">
									</label>
								</div>
								<div class="bootstrap-timepicker">
									<label>hasta:
										<input type="text" class="input-mini timepicker" name="toTime" value="<?php echo __timeISOToLocale( $persistValues['toTime'] ); ?>">
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
								<div class="is2-doctors-listbox alert alert-info">
								<?php foreach( $doctors as $doctor ): ?>
									<label class="checkbox">
										<input type="checkbox" name="doctorsList[]" value="<?php echo $doctor['id']; ?>" <?php echo isset( $persistValues['doctorsList'][$doctor['id']] ) ? 'checked' : ''; ?>>
										<?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?>
									</label>
								<?php endforeach; ?>
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
								<input class="input-xxlarge is2-patients-search" type="text" placeholder="Separe con espacios cada DNI de los pacientes" name="patientsList" value="<?php echo $persistValues['patientsDNI']; ?>">
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
			
			<?php if( $tooMuchRecords ): ?>
			<div class="alert">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				La búsqueda realizada a devuelto demasiados turnos, solo se muestran los primeros <strong>20</strong> turnos econtrados, trate de ser más específico en su criterio de búsqueda
			</div>
			<?php elseif( $currentDate ): ?>
			<div class="alert">
				Se muestran los turnos desde día presente (<strong><?php echo $currentDate; ?></strong>) hasta los próximos 7 días.
			</div>
			<?php endif; ?>
			
			<?php if( $appointments && $appointments->rowCount() ): ?>
			<table class="table is2-grid-header btn-inverse">
				<tr>
					<th>
						Fecha
						<?php t_dateMenu(); ?>
					</th>
					<th>Hora</th>
					<th>Médico</th>
					<th>Paciente</th>
					<th>Acciones</th>
				</tr>
			</table>
			<div class="is2-grid-wrapper">
				<table class="table is2-grid">
				<?php $currentDate = null; ?>
				<?php $currentMonth = null; ?>
				
				<?php foreach( $appointments as $appointment ): ?>
				
					<?php if( $appointment['fecha'] != $currentDate ): ?>

						<?php $currentDate = $appointment['fecha']; ?>
						<?php $currentAppointmentMilliseconds = strtotime( $currentDate ); ?>
						<?php $appointmentDateData = explode( '-', date( 'm-d-Y-M-D-j', $currentAppointmentMilliseconds ) ); ?>
						<?php $dateLocale = $appointmentDateData[1] . '/' . $appointmentDateData[0] . '/' . $appointmentDateData[2]; ?>

					<?php t_appointmentNewRow( date( 'd/m/Y',  strtotime( $currentDate . ' previous day' ) ) ); ?>
					
						<?php if( !$currentMonth || $currentMonth != $appointmentDateData[0] ): ?>
							<?php $currentMonth = $appointmentDateData[0]; ?>

					<tr class="is2-appointments-monthbreak" data-appointment-group="<?php echo $currentMonth; ?>">
						<td></td>
						<td></td>
						<td><?php echo $MONTHNAME[$appointmentDateData[3]]; ?></td>
						<td><?php echo $appointmentDateData[2]; ?></td>
						<td></td>
					</tr>
					
						<?php endif; ?>
					
					<tr class="is2-appointments-dayrow" data-appointment-date="<?php echo $dateLocale; ?>" data-appointment-group="<?php echo $currentMonth; ?>" data-appointment-timestamp="<?php echo $currentAppointmentMilliseconds; ?>">
						<td><?php echo $DAYNAME[$appointmentDateData[4]] . ', ' . $appointmentDateData[5]; ?></td>
						<td><?php t_timeMenu(); ?></td>
						<td></td>
						<td></td>
						<td><?php t_statusMenu(); ?></td>
					</tr>
					
					<?php endif; ?>
					
					<?php if( $appointment['hora'] ): ?>
					
					<tr class="is2-appointments-row" data-appointment-id="<?php echo $appointment['id']; ?>" data-appointment-date="<?php echo $dateLocale; ?>" data-appointment-status="<?php echo $appointment['estado']; ?>">
						<td>&nbsp;</td>
						<td class="is2-appointment-time"><?php echo __trimTime( $appointment['hora'] ); ?></td>
						<td>
							<img class="is2-doctor-img" src="/img/<?php echo $appointment['medicoAvatar']; ?>">
							<a href="/medicos#id=<?php echo $appointment['idMedico']; ?>" target="_blank"><?php echo $appointment['medicoApellidos'] . ', ' .  $appointment['medicoNombres']; ?></a>
						</td>
						<td>
							<a href="/pacientes?id=<?php echo $appointment['idPaciente']; ?>" target="_blank">
							<?php echo $appointment['pacienteApellidos'] . ', ' .  $appointment['pacienteNombres']; ?>
							</a>
						</td>
						<td data-appointment-id="<?php echo $appointment['id']; ?>" class="is2-appointment-status">
							<button class="btn btn-small btn-success disabled" style="display:<?php echo $appointment['estado'] == 'confirmado' ? 'inline-block' : 'none'; ?>" data-appointment-id="<?php echo $appointment['id']; ?>"><i class="icon-ok"></i> Confirmado</button>
							<button class="btn btn-small btn-warning disabled" style="display:<?php echo $appointment['estado'] == 'cancelado' ? 'inline-block' : 'none'; ?>" data-appointment-id="<?php echo $appointment['id']; ?>"><i class="icon-exclamation-sign"></i> Cancelado</button>
							<?php $isWaiting = $appointment['estado'] == 'esperando'; ?>
							<a class="btn btn-mini btn-link is2-trigger-restore" href="#is2-modal-restore" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>" style="display:<?php echo !$isWaiting ? 'inline-block' : 'none'; ?>">Deshacer acción</a>
							<div style="display:<?php echo $isWaiting ? 'block' : 'none'; ?>" data-appointment-id="<?php echo $appointment['id']; ?>">
								<a class="btn btn-small is2-trigger-confirm" href="#is2-modal-confirm" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>">Confirmar</a>
								<a class="btn btn-small is2-trigger-cancel" href="#is2-modal-cancel" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>">Cancelar</a>
								<a class="btn btn-small btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-appointment-id="<?php echo $appointment['id']; ?>">Borrar</a>
							</div>
						</td>
					</tr>
					
					<?php endif; ?>
					
				<?php endforeach; ?>
				
					<?php t_appointmentNewRow( $dateLocale ); ?>
					
				</table>
			</div>
			
			<div class="is2-appointments-export btn-inverse clearfix">
				<div class="pull-right">
					<a class="is2-icon is2-icon-print" href="/turnos/exportar/imprimir?<?php echo $listingData; ?>" title="Ver listado en formato imprimible" target="_blank"></a>
					<?php if( __AmI( 5.3 ) ): ?>
					<a class="is2-icon is2-icon-excel" href="/turnos/exportar/excel?<?php echo $listingData; ?>" title="Descargar listado en un archivo excel" target="_blank"></a>
					<?php endif; ?>
					<a class="is2-icon is2-icon-pdf" href="/turnos/exportar/pdf?<?php echo $listingData; ?>" title="Descargar listado en un archivo pdf" target="_blank"></a>
				</div>
			</div>

			<?php else: ?>
			
			<div class="alert alert-error">
				No se han encontrado turnos según el criterio de búsqueda específicado
			</div>
			
			<?php endif; ?>

			<div class="is2-popover">
				<div class="alert">
					<strong>¡Nuevo turno ha sido creado satisfactoriamente!</strong>
				</div>
				<a class="btn btn-block" href="/turnos">
					<i class="icon-arrow-left"></i>
					Listar turnos
				</a>
				<button class="btn btn-link btn-mini is2-popover-close">¡Entendido!</button>
			</div>

		<?php t_endWrapper(); ?>
		
		<!-- modals -->
		<form id="is2-modal-confirm" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button> 
				<strong>¿Estás seguro que desea confirmar el turno?</strong>
			</div>
			<div class="modal-footer">
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-confirm"></span>
				<button class="btn is2-modal-confirm-close" data-dismiss="modal">No</button>
				<button class="btn btn-primary" type="submit">Sí</button>
			</div>
		</form>
		
		<form id="is2-modal-cancel" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong>¿Estás seguro que desea cancelar el turno?</strong>
			</div>
			<div class="modal-footer">
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-cancel"></span>
				<button class="btn is2-modal-cancel-close" data-dismiss="modal">No</button>
				<button class="btn btn-primary" type="submit">Sí</button>
			</div>
		</form>
		
		<form id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong>¿Estás seguro que desea borrar el turno?</strong>
			</div>
			<div class="modal-footer">
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-remove"></span>
				<button class="btn is2-modal-remove-close" data-dismiss="modal">No</button>
				<button class="btn btn-primary" type="submit">Sí</button>
			</div>
		</form>
		
		<form id="is2-modal-restore" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong>¿Estás seguro que desea que el turno vuelva a su estado original?</strong>
			</div>
			<div class="modal-footer">
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-restore"></span>
				<button class="btn is2-modal-restore-close" data-dismiss="modal">No</button>
				<button class="btn btn-primary" type="submit">Sí</button>
			</div>
		</form>
		
<?php t_endBody(); ?>
<script>
(function() {
	IS2.cleanPrevState();

// *** ACA PARA CUANDO MUESTRO LOS MODALS *** //
	$( '.is2-grid' ).delegate( '.is2-trigger-confirm', 'click', function( e ) {
		$( '#is2-modal-confirm' ).attr( 'data-appointment-id', $( this ).attr( 'data-appointment-id' ) );
	
	} ).delegate( '.is2-trigger-cancel', 'click', function( e ) {
		$( '#is2-modal-cancel' ).attr( 'data-appointment-id', $( this ).attr( 'data-appointment-id' ) );
	
	} ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove' ).attr( 'data-appointment-id', $( this ).attr( 'data-appointment-id' ) );
		
	} ).delegate( '.is2-trigger-restore', 'click', function( e ) {
		$( '#is2-modal-restore' ).attr( 'data-appointment-id', $( this ).attr( 'data-appointment-id' ) );
	} );
	
// *** ACA PARA CUANDO SORTEO LA GRID *** //
	// POR FECHA
	$( '.is2-trigger-date' ).on( 'click', function( e ) {
		// dont append the #
		e.preventDefault();
		var $el = $( this ),
			orderBy = $el.attr( 'data-orderby' ),
			monthsTree = new BinaryTree(),
			daysTree = new BinaryTree(),
			orderedGridRows = [];

		var makeDaysTree = function( key, $monthRow ) {
			var $daysRow = $( 'tr.is2-appointments-dayrow[data-appointment-group=' + $monthRow.attr( 'data-appointment-group' ) + ']' ), $dayRow,
				i = 0, l = $daysRow.length;
			
			orderedGridRows.push( $monthRow );
			// orderno los dias
			for( ; i < l; i++ ) {
				$dayRow = $daysRow.eq( i );
				daysTree.add( $dayRow.attr( 'data-appointment-timestamp' ), $dayRow );
			}
			
			if( orderBy === 'asc' ) {
				daysTree.walkAsc( orderDays );
			} else {
				daysTree.walkDesc( orderDays );
			}
		};
		
		var orderDays = function( key, $dayRow  ) {
			orderedGridRows.push( $dayRow );
			
			var appointmentDate = $dayRow.attr( 'data-appointment-date' );
			// pido los turnos respectivos y la newrow
			orderedGridRows.push( 
				$( 'tr.is2-appointments-row[data-appointment-date="' + appointmentDate + '"], tr.is2-appointments-newrow[data-appointment-date="' + appointmentDate + '"]' )
			);
		};

		// select the column
		IS2.markChosenOrder( '.is2-trigger-date', $el );
		
		// ordeno los meses
		$( 'tr.is2-appointments-monthbreak' ).each( function() {
			var $row = $( this );
			monthsTree.add( $row.attr( 'data-appointment-group' ), $row );
		} );
		
		// pido los dias de los meses
		if( orderBy === 'asc' ) {
			// pido sus dias respectivos
			monthsTree.walkAsc( makeDaysTree );
		} else {
			monthsTree.walkDesc( makeDaysTree );
		}
		
		$( '.is2-appointments-newrow:first' ).after( orderedGridRows );
	} );

	// POR HORA
	$( '.is2-grid' ).delegate( '.is2-trigger-time', 'click', function( e ) {
		// dont append the #
		e.preventDefault();
		var $el = $( this ),
			orderBy = $el.attr( 'data-orderby' ),
			$row = $el,
			$cells;
			
		var reorderRows = function( key, $el ) {
			$row = $row.after( $el ).next();
		};

		// select the column
		IS2.markChosenOrder( '.is2-trigger-time', $el );

		while( ( $row = $row.parent() ).length && !$row.hasClass( 'is2-appointments-dayrow' ) );
		
		// hay que buscar los times especificos de la $row
		var $cells = $( 'tr.is2-appointments-row[data-appointment-date="' + $row.attr( 'data-appointment-date' ) + '"] td.is2-appointment-time' ),
			i = 0, l = $cells.length,
			timeTree = new BinaryTree();
			
		if( l > 1 ) {
			for( ; i < l; i++ ) {
				$cell = $cells.eq( i );
				timeTree.add( $cell.html().replace( ':', '' ) - 0, $cell.parent() );
			}

			if( orderBy === 'asc' ) {
				timeTree.walkAsc( reorderRows );
			} else {
				timeTree.walkDesc( reorderRows );
			}
		}
	
	// POR ESTADO
	} ).delegate( '.is2-trigger-status', 'click', function( e ) {
		// dont append the #
		e.preventDefault();
		var $el = $( this ),
			fieldValue = $el.attr( 'data-field-value' ),
			$target = $el,
			$cells;

		IS2.markChosenOrder( '.is2-trigger-status', $el );	
			
		while( ( $target = $target.parent() ).length && !$target.hasClass( 'is2-appointments-dayrow' ) );

		var $rows =$( 'tr.is2-appointments-row[data-appointment-date="' + $target.attr( 'data-appointment-date' ) + '"]' ), $row,
			i = 0, l = $rows.length,
			rows = [];

		if( l > 1 ) {
			for( ; i < l; i++ ) {
				$row = $rows.eq( i );
				if( $row.attr( 'data-appointment-status' ) === fieldValue ) {
					rows.splice( 0, 0, $row );
				} else {
					rows.push( $row );
				}
			}
			$target.after( rows );
		}
	} );

// *** ACA PARA LA BUSQUEDA DE TURNOS *** //
	IS2.initDatepickers();
	IS2.initTimepickers( { defaultTime: false } );
	$( '.is2-doctors-listbox label' ).on( 'click', function( e ) {
		$( '.is2-doctors-custom' ).click();
	} );
	$( '.is2-patients-search' ).on( 'click', function( e ) {
		$( '.is2-patients-custom' ).click();
	} );
	
// *** APPOINTMENTS AJAX FUNCIONALITY *** //
	var showAppointmentAction = function( id, type ) {
	
		var $row = $( 'tr[data-appointment-id=' + id + ']' ),
			status;
	
		$row.find( 'td:last-child > *' ).hide();
	
		if( type === 'restore' ) {
			$row.find( 'div' ).show();
			status = 'esperando';
			
		} else if( type === 'confirm' ) {
			$row.find( 'button.btn-success' ).show();
			$row.find( '.is2-trigger-restore' ).show();
			status = 'confirmado';
			
		} else if( type === 'cancel' ) {
			$row.find( 'button.btn-warning' ).show();
			$row.find( '.is2-trigger-restore' ).show();
			status = 'cancelado';
		
		} else if( type === 'remove' ) {
			$row.addClass( 'is2-record-removed' );
			status = 'borrado';
		}
		
		$row.effect( 'highlight', null, 1500 );
		$row.attr( 'data-appointment-status', status );
	};
	
	var AppointmentActionAjax = function( type, action ) {
		this.type = type;
		this.action = action;
		this.$preloader = $( '.is2-preloader-' + type );
		this.$closeModal = $( '.is2-modal-' + type + '-close' );
		this.$successMsg = $( '.is2-' + type + '-success' );
		this.$errorMsg = $( '.is2-' + type + '-error' );
		this.$theForm = $( '#is2-modal-' + type );
		this.$theForm.on( 'submit', $.proxy( this.send, this ) );
	};
	AppointmentActionAjax.isWaiting = false;
	AppointmentActionAjax.$allMsgs = $( '.is2-ajax-msg' );
	AppointmentActionAjax.prototype = {
	
		send: function( e ) {
			e.preventDefault();
			
			if( AppointmentActionAjax.isWaiting ) {
				return false;
			}
			AppointmentActionAjax.isWaiting = true;
			this.$preloader.css( 'visibility', 'visible' );
			
			var appointmentID = this.$theForm.attr( 'data-appointment-id' );
			
			$.ajax( {
				url: '/turnos/' + appointmentID + '/' + this.action,
				type: 'GET',
				dataType: 'json',
				success: this.response,
				error: this.response,
				context: this
			} );
		},
		
		response: function( dataResponse ) {
			AppointmentActionAjax.isWaiting = false;
			this.$preloader.css( 'visibility', 'hidden' );
			this.$theForm.removeAttr( 'data-appointment-id' );
			this.$closeModal.click();
			
			AppointmentActionAjax.$allMsgs.hide();
			
			var $msg;
			if( !dataResponse.success ) {
				$msg = this.$errorMsg;
				return;
			}
			$msg = this.$successMsg;
			IS2.showCrudMsg( $msg );
			
			showAppointmentAction( dataResponse.data.id, this.type );
		}
	};
	
	new AppointmentActionAjax( 'confirm', 'confirmar' );
	new AppointmentActionAjax( 'cancel', 'cancelar' );
	new AppointmentActionAjax( 'remove', 'borrar' );
	new AppointmentActionAjax( 'restore', 'reiniciar' );

// *** ACA MUESTRO UN POPOVER CUANDO SE ACABA DE CREAR UN TURNO NUEVO *** //
	var $newlyAppointment, 
		appointmentID = window.location.search.match( /id=(\d+)/ );

	if( appointmentID && ( $newlyAppointment = $( '.is2-appointments-row[data-appointment-id=' + appointmentID[1] + ']' ) ).length && window.location.search.indexOf( 'exito=crear-turno' ) >= 0 ) {
		IS2.showNewRecord( $newlyAppointment );
	}

// *** BUSQUEDA AVANZADA *** //
	var $advancedForm = $( '.is2-search-advanced-form' );
	$advancedForm.on( 'submit', function( e ) {
		/** @todo: validate fields */
		e.preventDefault();

		var formData = IS2.getFormFields( $advancedForm );

		formData.fromDate = IS2.getISODate( formData.fromDate );
		formData.toDate = IS2.getISODate( formData.toDate );
		formData.fromTime = IS2.getISOTime( formData.fromTime );
		formData.toTime = IS2.getISOTime( formData.toTime );

		formData.patientsList = formData.patientsList ? formData.patientsList.replace( /\./g, '' ).split( /\s+/ ) : [];

		// make the query
		var query = formData.fromDate + '@' + formData.toDate + '|' + formData.fromTime + '@' + formData.toTime + '|' + ( formData.doctorsList.length ? formData.doctorsList.join( '-' ) : '' ) + '|' + ( formData.patientsList.length ? patientsList.join( '-' ) : '' ) + '|' + formData.status;

		window.location = '/turnos?busqueda-avanzada=' + btoa( query );
	} );

// *** BUSQUEDA RAPIDA *** //
	var $searchQuery = $( '.is2-search-quick-input' );
	var $searchControlGroup = $( '.is2-search-quick-control' );
	$( '.is2-search-quick-form' ).on( 'submit', function( e ) {
		e.preventDefault();

		var keyword = $searchQuery.val().trim();
		if( !keyword ) {
			$searchControlGroup.addClass( 'error' );
			return;
		}
		$searchControlGroup.removeClass( 'error' );

		var field;
		var value;

		// is a date?
		if( ( value = IS2.getISODate( keyword ) ) ) {
			field = 'fecha';
		
		// is a time?
		} else if( ( value = IS2.getISOTime( keyword ) ) ) {
			field = 'hora';
		
		} else if( ( value = keyword.match( /(confirmado|cancelado)s?/ ) ) ) {
			field = 'estado';
			value = value[1];
		
		} else {
			field = 'comodin';
			value = keyword;
		}

		window.location = '/turnos?busqueda=' + btoa( field + '=' + value );
	} );

})();
</script>