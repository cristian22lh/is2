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
		<?php t_headerTag( $username, 'patients' ); ?>
	
		<div class="container">
			<?php if( $createError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<p><strong>¡Ha fallado la creación del nuevo paciente!</strong></p>
				<ul>
					<li>Sepa que no puede crear un paciente con un DNI el cual ya exista otro paciente con ese mismo DNI en el sistema</li>
					<li>Verifique que la fecha de nacimiento sea válida y con el formato: dd/mm/yyyy</li>
					<li>Verifique que el correo electrónico sea uno válido</li>
				</ul>
			</div>
			<?php endif; ?>
			<div class="is2-pagetitle clearfix">
				<h3>Pacientes - Crear</h3>
				<a class="btn pull-right" href="/pacientes"><i class="icon-arrow-left"></i> Listar pacientes</a>
			</div>
			
			<form class="form-horizontal is2-patient-form" method="post" action="">
				<div class="control-group">
					<label class="control-label">Apellidos</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Apellidos" name="lastName">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombres</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Nombres" name="firstName">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Sexo</label>
					<div class="controls">
						<select type="text" class="input-mini" name="gender">
							<option value="f">F</option>
							<option value="m">M</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">DNI</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Número de DNI" name="dni">
					</div>
				</div>
				<div class="control-group is2-patient-birthdate-wrapper">
					<label class="control-label">Fecha de nacimiento</label>
					<div class="controls">
						<input type="text" class="input-xlarge datepicker is2-patient-birthdate" placeholder="Fecha de nacimiento" name="birthDate">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Teléfono</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Teléfono" name="phone">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Correo electrónico</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Correo electrónico" name="email">
					</div>
				</div>
				<div class="alert">
					Si el paciente no tiene obra social, eliga la option <strong>LIBRE</strong>
				</div>
				<div class="control-group">
					<label class="control-label">Obra social</label>
					<div class="controls">
						<select type="text" class="input-xlarge is2-insurances-list" name="insuranceID">
						<?php foreach( $insurances as $insurance ): ?>
							<option value="<?php echo $insurance['id']; ?>"><?php echo $insurance['nombreCorto'] . ' (' . $insurance['nombreCompleto'] . ')'; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Número de afiliado</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-insurance-number" placeholder="Número de afiliado" name="insuranceNumber">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn">Crear paciente</button>
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
	} );

// *** POPULATE THE FIELDS *** //
	var prevState = JSON.parse( localStorage.getItem( 'is2-patient-state' ) );
	if( prevState ) {
		for( var fieldName in prevState ) {
			$( 'input[name=' + fieldName + ']' ).val( prevState[fieldName] );
			localStorage.removeItem(  'is2-patient-state' );
		}
	}

// *** NORMAL THINGS *** //
	var $insurancesList = $( '.is2-insurances-list' );
	var $insuranceNumber = $( '.is2-insurance-number' );
	$insurancesList.on( 'click', function( e ) {
		// es LIBRE
		if( $insurancesList.find( 'option' ).eq( $insurancesList[0].selectedIndex ).val() == 1 ) {
			$insuranceNumber.val( '---' );
		} else {
			$insuranceNumber.val( '' );
		}
	} );
	
	var $birthDate = $( '.is2-patient-birthdate' );
	var $birthDateGroupError = $( '.is2-patient-birthdate-wrapper' );
	var $theForm = $( '.is2-patient-form' );
	$theForm.on( 'submit', function( e ) {
		// check birthDate validity
		var date = $birthDate.val().split( '/' );
		if( date.length != 3 ) {
			e.preventDefault();
			$birthDateGroupError.addClass( 'error' );
			return;
		}
		var target = new Date();
		target.setDate( 1 );
		target.setFullYear( date[2] );
		target.setMonth( date[1]-1 );
		target.setDate( date[0] );
		var base = new Date();
		base.setDate( base.getDate() + 1 );
		if( target >= base ) {
			e.preventDefault();
			$birthDateGroupError.addClass( 'error' );
			return;
		}
		$birthDateGroupError.removeClass( 'error' );
		
		// ahora debo guardar los valores de los inputs
		var prevState = {};
		$theForm.find( 'input' ).each( function( e ) {
			var $el = $( this );
			prevState[$el.attr( 'name' )] = $el.val().replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' );
		} );
		window.localStorage.setItem( 'is2-patient-state', JSON.stringify( prevState ) );
	} );
})();
</script>