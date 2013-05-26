<!DOCTYPE html>
<html lang="es">
	<head>
		<?php t_headTag( 'Turnos - Crear' ); ?>
		<style>
			label {
				cursor: default;
			}
		</style>
	</head>
	<body>
		<?php t_headerTag( $username, 'appointments' ); ?>
	
		<div class="container">
			<?php if( $createError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡Ha fallado la creación del nuevo turno!</strong>
				<span>Verifique que todos los campos sean correctos</span>
			</div>
			<?php endif; ?>
			<div class="is2-pagetitle clearfix">
				<h3>Turnos - Crear</h3>
				<a class="btn pull-right" href="/turnos"><i class="icon-arrow-left"></i> Listar turnos</a>
			</div>
			
			<form class="form-horizontal is2-appointment-form" method="post" action="">
				<div class="control-group">
					<label class="control-label">Fecha</label>
					<div class="controls">
						<input type="text" class="input-small datepicker" placeholder="Fecha" name="fecha">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Hora</label>
					<div class="controls bootstrap-timepicker">
						<input type="text" class="input-small timepicker" placeholder="Hora" name="hora">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Medico</label>
					<div class="controls">
						<select class="input-xlarge" name="idMedico">
						<?php foreach( $doctors as $doctor ): ?>
							<option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="control-group is2-dni">
					<div class="alert alert-info">
						Utilice este campo para buscar el paciente mediante su número de DNI para poder asociarlo a éste turno
					</div>
					<label class="control-label">Paciente</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-patients-search-value" placeholder="Buscar paciente por DNI...">
						<input type="hidden" class="is2-patients-search-result" name="idPaciente">
						<button type="button" class="btn btn-info is2-patients-search-trigger">Buscar</button>
						<span class="is2-preloader"></span>
					</div>
				</div>
				<div class="alert is2-patient-search-info">
					Aquí aparecer el paciente en cuestión si la búsqueda es satisfactoria
				</div>
				<div class="alert alert-error is2-patient-search-error" style="display:none">
					<strong>¡No se ha encontrado paciente con tal número de DNI!</strong>
					<p>Intentelo nuevamente</p>
				</div>
				<div class="alert alert-success is2-patient-search-success" style="display:none">
					<strong>¡Paciente encontrado!</strong>
					<p>Acontinuación se muestran los datos del paciente a asociar con éste turno</p>
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
		</div>
		
		<?php t_footerTag(); ?>
	</body>
</html>
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
	
// *** LA BUSQUEDA SE HACE EN AJAX *** //
	var isWaiting = false;
	var $dni = $( '.is2-patients-search-value' );
	var $dniGroupControl = $( '.control-group.is2-dni' );
	var $preloader = $( '.is2-preloader' );
	var $search = $( '.is2-patients-search-trigger' );
	var $errorMsg = $( '.is2-patient-search-error' );
	var $successMsg = $( '.is2-patient-search-success' );
	var $patientID = $( '.is2-patients-search-result' );
	
	var searchedPatient = function( dataResponse ) {
		isWaiting = false;
		$preloader.css( 'visibility', 'hidden' );
		
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
		$preloader.css( 'visibility', 'visible' );
		isWaiting = true;
		
		$.ajax( {
			url: '/pacientes/buscar/dni',
			data: {
				dni: dni
			},
			dataType: 'json',
			type: 'POST',
			success: searchedPatient
		} );
		
	} );
	
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
		} else {
			$dniGroupControl.removeClass( 'error' );
		}
	} );
	
})();
</script>