<?php t_startHead( 'Turnos - Crear' ); ?>
	<style>
		label {
			cursor: default;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'appointments'  ); ?>
	
		<?php t_startWrapper(); ?>
			<?php if( $createError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<p><strong>¡Ha fallado la creación del nuevo turno!</strong></p>
				<ul>
					<li>Verifique que la fecha del turno este dentro del rango de 7 días hacia adelante a partir de hoy</li>
					<li>No puede crear un turno con un mismo médico a la misma hora y fecha que ya exista en el sistema</li>
					<li>Verifique que la hora esté dentro del rango de horarios que posee el médico</li>
				</ul>
			</div>
			<?php endif; ?>
			<div class="is2-pagetitle clearfix">
				<h3>Turnos - Crear</h3>
				<a class="btn pull-right" href="/turnos"><i class="icon-arrow-left"></i> Listar turnos</a>
			</div>
			
			<form class="form-horizontal is2-appointment-form" method="post" action="">
				<div class="alert">
					Sepa que no se pueden dar turnos más allá de la próxima semana desde la fecha actual
				</div>
				<div class="control-group is2-date">
					<label class="control-label">Fecha</label>
					<div class="controls">
						<input type="text" class="input-small datepicker is2-availability-date" placeholder="Fecha" name="fecha">
					</div>
				</div>
				<div class="control-group is2-time">
					<label class="control-label">Hora</label>
					<div class="controls bootstrap-timepicker">
						<input type="text" class="input-small timepicker is2-availability-time" placeholder="Hora" name="hora">
					</div>
				</div>
				<div class="control-group">
					<div class="alert alert-info">
						Tenga en cuenta debe estar disponible en la fecha y hora especifícadas para poder crear el turno
					</div>
					<label class="control-label">Medico</label>
					<div class="controls">
						<select class="input-xlarge is2-availability-doctor" name="idMedico">
						<?php foreach( $doctors as $doctor ): ?>
							<option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?></option>
						<?php endforeach; ?>
						</select>
						<button type="button" class="btn btn-info is2-availability-trigger">Comprobar disponibilidad</button>
						<span class="is2-preloader is2-availability-preloader"></span>
					</div>
				</div>
				<div class="alert alert-error is2-availability-error" style="display:none">
					<strong>El medico no esta disponible para la fecha y hora especifícado</strong>
				</div>
				<div class="alert alert-success is2-availability-success" style="display:none">
					<strong>El medico esta disponible para la fecha y hora especifícado</strong>
				</div>
				<div class="control-group is2-dni">
					<div class="alert alert-info">
						Utilice este campo para buscar el paciente mediante su número de DNI para poder asociarlo a éste turno
					</div>
					<label class="control-label">Paciente</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-patients-search-value" placeholder="Buscar paciente por DNI...">
						<input type="hidden" class="is2-patients-search-result" name="idPaciente">
						<button type="button" class="btn btn-info is2-patients-search-trigger">Buscar paciente</button>
						<span class="is2-preloader is2-patients-search-preloader"></span>
					</div>
				</div>
				<div class="alert is2-patient-search-info">
					Aquí va a aparecer el paciente que se asociará a este turno en cuestión si la búsqueda es satisfactoria
				</div>
				<div class="alert alert-error is2-patient-search-error" style="display:none">
					<strong>¡No se ha encontrado paciente con tal número de DNI!</strong>
					<p>Intentelo nuevamente</p>
				</div>
				<div class="alert alert-success is2-patient-search-success" style="display:none">
					<strong>¡Paciente encontrado!</strong>
					<p>Acontinuación se muestran los datos del paciente que se asociará a éste turno</p>
					<ul>
						<li>
							<strong>Nombre completo:</strong>
							<span data-field-name="nombreCompleto"></span>
						</li>
						<li>
							<strong>Sexo:</strong>
							<span data-field-name="sexo"></span>
						</li>
						<li>
							<strong>Número de DNI:</strong>
							<span data-field-name="dni"></span>
						</li>
						<li>
							<strong>Fecha de nacimiento:</strong>
							<span data-field-name="fechaNacimiento"></span>
						</li>
						<li>
							<strong>Edad:</strong>
							<span data-field-name="edad"></span>
						</li>
						<li>
							<strong>Teléfono:</strong>
							<span data-field-name="telefono"></span>
						</li>
						<li>
							<strong>Correo electrónico:</strong>
							<span data-field-name="email"></span>
						</li>
						<li>
							<strong>Obra social:</strong>
							<span data-field-name="obraSocialNombre"></span>
						</li>
						<li>
							<strong>Número de afiliado:</strong>
							<span data-field-name="nroAfiliado"></span>
						</li>
					</ul>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary btn-large">Crear turno</button>
					</div>
				</div>
			</form>
		<?php t_endWrapper(); ?>
		
<?php t_endBody(); ?>

<script>
(function() {
	$( '.datepicker' ).datepicker( {
		format: 'dd/mm/yyyy',
		language: 'es'
	} ).datepicker( 'setValue', new Date() );
	$( '.timepicker' ).timepicker( {
		showInputs: false,
		disableFocus: true,
	});
	
// *** LA BUSQUEDA DE PACIENTE SE HACE MEDIATE AJAX *** //
	var isWaiting = false;
	var $dni = $( '.is2-patients-search-value' );
	var $dniGroupControl = $( '.control-group.is2-dni' );
	var $preloaderSearch = $( '.is2-patients-search-preloader' );
	var $search = $( '.is2-patients-search-trigger' );
	var $errorMsg = $( '.is2-patient-search-error' );
	var $successMsg = $( '.is2-patient-search-success' );
	var $patientID = $( '.is2-patients-search-result' );
	
	var searchedPatient = function( dataResponse ) {
		isWaiting = false;
		$preloaderSearch.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			return;
		}
		
		var patientData = dataResponse.data;
		$( '.is2-patient-search-info' ).hide();
		if( !patientData ) {
			// no hubo match
			$successMsg.hide();
			$errorMsg.show();
			// con esto se que no hay paciente elegido
			$patientID.val( '' );
			
		} else {
			$errorMsg.hide();
			$successMsg.find(  'span' ).each( function() {
				var $el = $( this );
				$el.html( patientData[$el.attr( 'data-field-name' )] );
			} );
			$successMsg.show();
			
			// dejo la marca
			$patientID.val( patientData['id'] );
		}
	};
	
	$search.bind( 'click', function( e ) {
		if( isWaiting ) {
			return;
		}
		
		var dni = $dni.val().trim();
		if( !dni ) {
			$dniGroupControl.addClass( 'error' );
			return;
		}
		
		$dniGroupControl.removeClass( 'error' );
		$preloaderSearch.css( 'visibility', 'visible' );
		isWaiting = true;
		
		$.ajax( {
			url: '/pacientes/buscar/dni',
			data: {
				dni: dni
			},
			dataType: 'json',
			type: 'POST',
			success: searchedPatient,
			error: searchedPatient
		} );
		
	} );
	
// *** EL CHECKEO DE DISPONIBLIDAD SE HACE MEDIANTE AJAX *** //
	var $date = $( '.is2-availability-date' );
	var $dateGroupControl = $( '.is2-date' );
	var $time = $( '.is2-availability-time' );
	var $timeGroupControl = $( '.is2-date' );
	var $doctor = $( '.is2-availability-doctor' );
	var $preloaderAvailability = $( '.is2-availability-preloader' );
	var $availabilityErrorMsg = $( '.is2-availability-error' );
	var $availabilitySuccessMsg = $( '.is2-availability-success' );
	
	var checkedAvailability = function( dataResponse ) {
		isWaiting = false;
		$preloaderAvailability.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			$availabilitySuccessMsg.hide();
			$availabilityErrorMsg.show();
			
		} else {
			$availabilitySuccessMsg.show();
			$availabilityErrorMsg.hide();
		}
	};
	
	$( '.is2-availability-trigger' ).on( 'click', function( e ) {
		if( isWaiting ) {
			return;
		}
		
		var date = $date.val().trim(),
			time = $time.val().trim(),
			doctorID = $doctor.val();
			
		if( !date ) {
			$dateGroupControl.addClass( 'error' );
			return;
		}
		$dateGroupControl.removeClass( 'error' );
		if( !time ) {
			$timeGroupControl.addClass( 'error' );
			return;
		}
		$timeGroupControl.removeClass( 'error' );
		
		$preloaderAvailability.css( 'visibility', 'visible' );
		isWaiting = true;
		
		$.ajax( {
			url: '/medicos/comprobar-horarios-disponibilidad',
			data: {
				date: date,
				time: time,
				doctorID: doctorID
			},
			dataType: 'json',
			type: 'POST',
			success: checkedAvailability,
			error: checkedAvailability
		} );
	} );
	
// *** OTRAS YERBAS *** //
	// esto es por si apreta <ENTER> estando en DNI, evito que submitte el form
	$dni.on( 'keydown', function( e ) {
		if( e.keyCode === 13 ) {
			e.stopPropagation();
			e.preventDefault();
			$search.click();
		}
	} );
	
	// si no ha paciente elegido, no contunio
	$( '.is2-appointment-form' ).on( 'submit', function( e ) {
		if( !$patientID.val().trim() ) {
			e.preventDefault();
			$dniGroupControl.addClass( 'error' );
			return;
		}
		$dniGroupControl.removeClass( 'error' );
		
		var date = $date.val(),
			target,
			base = new Date();
		
		date = date.split( '/' );
		if( date.length !== 3 ) {
			e.preventDefault();
			$dateGroupControl.addClass( 'error' );
			return;
		}
		target = new Date();
		target.setDate( 1 );
		target.setFullYear( date[2] );
		target.setMonth( date[1]-1 );
		target.setDate( date[0] );

		if( base > target || target - base > 604800000 ) {
			e.preventDefault();
			$dateGroupControl.addClass( 'error' );
			return;
		}
		$dateGroupControl.removeClass( 'error' );
	} );
	
})();
</script>