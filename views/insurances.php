<?php t_startHead( 'Obras sociales' ); ?>
	<style>
		label {
			cursor: default;
		}
		.is2-grid-header th:last-child {
			width: 245px;
		}
		.is2-grid td:first-child span {
			display: block;
		}
		.is2-grid td span.is2-insurance-abbrname {
			text-transform: uppercase;
		}
		.is2-grid td span.is2-insurance-fullname {
			color: #777;
			font-size: 12px;
		}
		.is2-grid td:not( :first-child ) {
			text-transform: none;
		}
		.is2-grid td:last-child {
			width: 215px;
			vertical-align: middle;
		}
		.is2-insurances-crud {
			display: inline-block;
			margin: 0 0 0 15px;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'insurances'  ); ?>

		<?php t_startWrapper(); ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Obra sociales</h3>
			</div>
			
			<form class="is2-insurances-new form-horizontal" method="post" action="/obras-sociales/crear">
				<fieldset>
					<legend>Crear una nueva obra social</legend>
					
					<div class="alert alert-info">
						Utilice este formulario para crear una nueva obra social en el sistema
					</div>
					<?php if( $createError ): ?>
					<div class="alert alert-error">
						<a class="close" data-dismiss="alert" href="#">&times;</a>
						<strong>¡No se ha podido crear la nueva obra social!</strong> Verifique no exista una con el mismo nombre corto ya cargada en el sistema.
					</div>
					<?php endif; ?>

					<div class="control-group">
						<label class="control-label">Nombre abreviado:</label>
						<div class="controls">
							<input type="text" class="is2-insurances-new-abbr input-xlarge" name="abbr">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Nombre completo:</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="full">
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-primary">Crear obra social</button>
						</div>
					</div>
				</fieldset>
			</form>
			
			<hr>
	
			<legend>Listado de obras sociales</legend>
			<div class="alert">
				A continuación se muestran todas las obra sociales cargadas en el sistema
			</div>
			<?php if( $createSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡La nueva obra social ha sido creada satisfactoriamente!
			</div>
			<?php elseif( $editSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡La obra social ha sido editada satisfactoriamente!
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡No se ha podido editar la obra social!</strong> Capaz ya exista una con el mismo nombre abreviado en el sistema.
			</div>
			<?php elseif( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡La obra social ha sido borrada satisfactoriamente!
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>¡No se ha podido borrar la obra social!</strong> Intentelo nuevamente.
			</div>
			<?php endif; ?>
			
			<table class="table is2-grid-header btn-inverse">
				<tr>
					<th>Nombre</th>
					<th>Acciones</th>
				</tr>
			</table>
			<div class="is2-grid-wrapper">
				<table class="table is2-grid">
				<?php foreach( $insurances as $insurance ): ?>
					<tr class="is2-grid-row" data-insurance-id="<?php echo $insurance['id']; ?>">
						<td>
							<span class="is2-insurance-abbrname"><?php echo $insurance['nombreCorto']; ?></span>
							<span class="is2-insurance-fullname"><?php echo $insurance['nombreCompleto']; ?></span>
						</td>
						<td>
						<?php if( $insurance['id'] != 1 ): ?>
							<a class="btn btn-small btn-warning">Deshabilitar</a>
							<div class="is2-insurances-crud">
								<a class="btn btn-small is2-trigger-edit" href="#is2-modal-edit" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>">Editar</a>
								<a class="btn btn-small btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>">Borrar</a>
							</div>
						<?php else: ?>
							&nbsp;
						<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</table>
			</div>
			
		<?php t_endWrapper(); ?>

		<!-- los modals -->
		<form method="post" action="/obras-sociales/editar" id="is2-modal-edit" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong>Editar obra social</strong>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label">Nombre abreviado:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="shortName">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombre completo:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="fullName">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Editar</button>
			</div>
			<input type="hidden" name="id">
		</form>
		
		<form method="post" action="/obras-sociales/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea borrar esta obra social del sistema?</strong></span>
				<p>Sepa que aquellos pacientes que tenga esta obra social asociada serán asociados a la obra social LIBRE automaticamente.</p>
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
	var $theGrid = $( '.is2-grid-wrapper' );
	$theGrid.delegate( '.is2-trigger-edit', 'click', function( e ) {
		var insuranceID = $( this ).attr( 'data-insurance-id' );
		$( '#is2-modal-edit input[name=id]' ).val( insuranceID );
		$( '#is2-modal-edit input[name=shortName]' ).val( $( 'tr[data-insurance-id=' + insuranceID + '] .is2-insurance-shortName'  ).html() );
		$( '#is2-modal-edit input[name=fullName]' ).val( $( 'tr[data-insurance-id=' + insuranceID + '] .is2-insurance-fullName'  ).html() );
		
	} ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove input[name=id]' ).val( $( this ).attr( 'data-insurance-id' ) );
	} );
	
// *** crear obra social *** //
	var $newForm = $( '.is2-insurances-new' );
	var $abbrName = $( '.is2-insurances-new-abbr' );

	if( window.location.search.indexOf( 'error' ) >= 0 ) {
		IS2.loadPrevState( 'is2-insurance-state', false, $newForm );
	}

	$newForm.on( 'submit', function( e ) {
		if( IS2.lookForEmptyFields( $abbrName, false, true ) ) {
			e.preventDefault();
			return;
		}
		
		IS2.savePrevState( 'is2-insurance-state', false, $newForm );
	} );
	
	var newInsuranceID;
	var $newInsurance;
	if( window.location.search.indexOf( 'exito=crear-obra-social' ) >= 0 && ( newInsuranceID = window.location.search.match( /id=(\d+)/ ) ) ) {
		$theGrid[0].scrollIntoView();
		$newInsurance = $( '.is2-grid-row[data-insurance-id=' + newInsuranceID[1] + ']' );
		$theGrid.scrollTo( $newInsurance, 1000, { onAfter: function() { 
			$newInsurance.addClass( 'is2-record-new' )[0].scrollIntoView();
			window.setTimeout( function() {
				$newInsurance.removeClass( 'is2-record-new' );
			}, 3000 );
		} } );
	}
	
})();
</script>