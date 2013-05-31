<?php t_startHead( 'Pacientes - Editar' ); ?>
	<style>
		label {
			cursor: default;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'patients'  ); ?>
	
		<?php t_startWrapper(); ?>
			<?php if( $editSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡El paciente ha sido editado con satisfactoriamente!</strong>
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<p><strong>¡Ha fallado la edición del paciente en cuestión!</strong></p>
				<ul>
					<li>Sepa que el número de DNI debe ser único</li>
					<li>Verifique que la fecha de nacimiento sea válida y con el formato: dd/mm/yyyy</li>
				</ul>
			</div>
			<?php endif; ?>
			<div class="is2-pagetitle clearfix">
				<h3>Pacientes - Editar</h3>
				<a class="btn pull-right" href="/pacientes"><i class="icon-arrow-left"></i> Listar pacientes</a>
			</div>
			
			<form class="form-horizontal is2-patient-form" method="post" action="">
				<div class="control-group">
					<label class="control-label">Apellidos</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Apellidos" name="lastName" value="<?php echo $patient['apellidos']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombres</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Nombres" name="firstName" value="<?php echo $patient['nombres']; ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Sexo</label>
					<div class="controls">
						<select type="text" class="input-mini" name="gender">
							<option value="F" <?php echo $patient['sexo'] == 'F' ? 'selected' : ''; ?>>F</option>
							<option value="M" <?php echo $patient['sexo'] == 'M' ? 'selected' : ''; ?>>M</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">DNI</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Número de DNI" name="dni" value="<?php echo $patient['dni']; ?>">
					</div>
				</div>
				<div class="control-group is2-patient-birthdate-wrapper">
					<label class="control-label">Fecha de nacimiento</label>
					<div class="controls">
						<input type="text" class="input-xlarge datepicker is2-patient-birthdate" placeholder="Fecha de nacimiento" name="birthDate" value="<?php echo __dateISOToLocale( $patient['fechaNacimiento'] ); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Teléfono</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder="Teléfono" name="phone" value="<?php echo $patient['telefono']; ?>">
					</div>
				</div>
				<div class="alert">
					Si el paciente no tiene obra social, eliga la opción <strong>LIBRE</strong>
				</div>
				<div class="control-group">
					<label class="control-label">Obra social</label>
					<div class="controls">
						<select type="text" class="input-xlarge is2-insurances-list" name="insuranceID">
						<?php foreach( $insurances as $insurance ): ?>
							<option value="<?php echo $insurance['id']; ?>" <?php echo $insurance['id'] == $patient['idObraSocial'] ? 'selected' : ''; ?>><?php echo $insurance['nombreCorto'] . ' (' . $insurance['nombreCompleto'] . ')'; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Número de afiliado</label>
					<div class="controls">
						<input type="text" class="input-xlarge is2-insurance-number" placeholder="Número de afiliado" name="insuranceNumber" value="<?php echo $patient['nroAfiliado']; ?>">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn">Editar paciente</button>
					</div>
				</div>
				<input type="hidden" name="id" value="<?php echo $patient['id']; ?>">
			</form>
			
		<?php t_endWrapper(); ?>
		
<?php t_endBody(); ?>

<script>
(function() {
	$( '.datepicker' ).datepicker( {
		format: 'dd/mm/yyyy',
		language: 'es'
	} );

// *** POPULATE THE FIELDS *** //
	var prevState = JSON.parse( localStorage.getItem( 'is2-patient-state' ) );
	if( prevState ) {
		if( window.location.search.indexOf( 'error' ) >= 0 ) {
			for( var fieldName in prevState ) {
				$( 'input[name=' + fieldName + ']' ).val( prevState[fieldName] );
			}
		}
		localStorage.removeItem(  'is2-patient-state' );
	}

// *** NORMAL THINGS *** //
	var $insurancesList = $( '.is2-insurances-list' );
	var $insuranceNumber = $( '.is2-insurance-number' );
	$insurancesList.on( 'click', function( e ) {
		// es LIBRE
		if( $insurancesList.find( 'option' ).eq( $insurancesList[0].selectedIndex ).val() == 1 ) {
			$insuranceNumber.val( '---' );
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