<?php t_startHead( 'Especialidades' ); ?>
	<style>
		label {
			cursor: default;
		}
		.is2-grid-header th:last-child {
			width: 150px;
		}
		.is2-grid td:last-child {
			width: 110px;
			vertical-align: middle;
			white-space: nowrap;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'specialities'  ); ?>
	
		<?php t_startWrapper(); ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Especialidades</h3>
				<a class="is2-trigger-new btn pull-right btn-warning" href="#is2-modal-theform" data-toggle="modal"><i class="icon-plus"></i> Crear una nueva especialidad</a>
			</div>

			<div class="alert">
				A continuación se muestran todas las especialidades cargadas en el sistema
			</div>
			
			<div class="is2-speciality-crudmessages">
				<?php if( $createSuccess ): ?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					¡La nueva especialidad ha sido creada satisfactoriamente!
				</div>
				<?php elseif( $editSuccess ): ?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					¡La especialidad ha sido editada satisfactoriamente!
				</div>
				<?php endif; ?>
			</div>
			
			<div class="is2-grid-header-wrapper">
				<table class="table is2-grid-header btn-inverse">
					<tr>
						<th>Nombre</th>
						<th>Acciones</th>
					</tr>
				</table>
				<div class="alert alert-success is2-remove-success is2-ajax-msg">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					¡La especialidad ha sido borrada satisfactoriamente!
				</div>
			</div>
			<div class="is2-grid-wrapper">
				<table class="table is2-grid">
				<?php foreach( $specialities as $speciality ): ?>
					<tr class="is2-grid-row" data-speciality-id="<?php echo $speciality['id']; ?>">
						<td class="is2-speciality-name"><?php echo $speciality['nombre']; ?></td>
						<td>
						<?php if( $speciality['id'] != 1 ): ?>
							<a class="btn btn-small is2-trigger-edit" href="#is2-modal-theform" data-toggle="modal" data-speciality-id="<?php echo $speciality['id']; ?>">Editar</a>
							<a class="btn btn-small btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-speciality-id="<?php echo $speciality['id']; ?>">Borrar</a>
						</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</table>
			</div>
			
		<?php t_endWrapper(); ?>
		
		<!-- los modals -->
		<form id="is2-modal-theform" class="modal hide fade form-horizontal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong class="is2-speciality-edit">Editar especialidad</strong>
				<strong class="is2-speciality-new">Crear especialidad</strong>
			</div>
			<div class="modal-body">
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-speciality-new-error" style="display:none">
					<strong>¡No se ha podido crear la nueva especialidad!</strong>
					<div>Verifique no exista una con el mismo nombre ya cargada en el sistema</div>
				</div>
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-speciality-edit-error" style="display:none">
					<strong>¡No se ha podido editar la especialidad!</strong>
					<div>Verifique no exista una con el mismo nombre ya cargada en el sistema</div>
				</div>
				<div class="control-group is2-speciality-name">
					<label class="control-label">Nombre de la especialidad:</label>
					<div class="controls">
						<input type="text" class="is2-speciality-name input-xlarge" name="name">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary is2-speciality-edit" type="submit">Confirmar cambios</button>
				<button class="btn btn-primary is2-speciality-new" type="submit">Crear especialidad</button>
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-newedit"></span>
			</div>
		</form>
		
		<form id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-speciality-remove-error" style="display:none">
					<strong>¡No se ha podido borrar la especialidad!</strong>
					<div>Verifique no existan médicos que tengan asociado esta especialidad</div>
				</div>
				<button type="button" class="close is2-speciality-remove-close" data-dismiss="modal">&times;</button>
				<p><strong>¿Estás seguro que desea borrar esta especialidad del sistema?</strong></p>
				<div class="alert">
					<strong>Tenga en cuenta que no puede borrar una especialidad que tenga médicos asociados</strong>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-remove"></span>
			</div>
		</form>
		
<?php t_endBody(); ?>

<script>
(function() {

	var $theGrid = $( '.is2-grid-wrapper' );
	var ajaxConfig;
	var isWaiting = false;
	var $preloader = $( '.is2-preloader-newedit' );
	var $theForm = $( '#is2-modal-theform' );
	var $specialityName = $( 'input.is2-speciality-name' );
	var $specialityNameControlGroup = $( '.control-group.is2-speciality-name' );
	
// *** create speciality funcionality *** //
	var $specialityCreateError = $( '.is2-speciality-new-error' );
	var ajaxCreateSpeciality = function() {
		return {
			url: '/especialidades/crear',
			dataType: 'json',
			type: 'POST',
			data: {
				name: $specialityName.val()
			},
			success: createdSpeciality,
			error: createdSpeciality	
		};
	};
	
	var createdSpeciality = function( dataResponse ) {
		isWaiting = false;
		$preloader.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			IS2.showCrudMsg( $specialityCreateError, 0, 6000 );
			$specialityNameControlGroup.addClass( 'error' );
			return;
		}
		
		window.location = '/especialidades?exito=crear-especialidad&id=' + dataResponse.data.id;
	};
	
	$( '.is2-trigger-new' ).on( 'click', function( e ) {
		$theForm.find( '.is2-speciality-edit' ).hide();
		$theForm.find( '.is2-speciality-new' ).show();

		$specialityName.val( '' );
		
		ajaxConfig = ajaxCreateSpeciality;
	} );
	
// *** edit especiality functionality *** //
	var currentSpecialityID;
	var ajaxEditSpeciality = function() {
		return {
			url: '/especialidades/' + currentSpecialityID + '/editar',
			dataType: 'json',
			type: 'POST',
			data: {
				name: $specialityName.val()
			},
			success: editedSpeciality,
			error: editedSpeciality
		}
	};
	
	$theGrid.delegate( '.is2-trigger-edit', 'click', function( e ) {
		$theForm.find( '.is2-speciality-edit' ).show();
		$theForm.find( '.is2-speciality-new' ).hide();
		
		var $el = $( this ),
			specialityID = $el.attr( 'data-speciality-id' ),
			$row = $( 'tr[data-speciality-id=' + specialityID + ']' );
		
		$row.addClass( 'is2-record-new' );
		$specialityName.val( $row.find( '.is2-speciality-name' ).html() );
		
		currentSpecialityID = specialityID;
		ajaxConfig = ajaxEditSpeciality;
	} );

	var $specialityEditError = $( '.is2-speciality-edit-error' );
	var editedSpeciality = function( dataResponse ) {
		isWaiting = false;
		$preloader.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			IS2.showCrudMsg( $specialityEditError, 0, 6000 );
			$specialityNameControlGroup.addClass( 'error' );
			return;
		}
		
		window.location = '/especialidades?exito=editar-especialidad&id=' + dataResponse.data.id;
	};
	
	$theForm.on( 'submit', function( e ) {
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		if( IS2.lookForEmptyFields( $specialityName, true, true ) ) {
			return;
		}
		
		isWaiting = true;
		$preloader.css( 'visibility', 'visible' );
		
		$.ajax( ajaxConfig() );
	
	} ).on( 'hidden', function( e ) {
		$( 'tr.is2-record-new' ).removeClass( 'is2-record-new' );
	} );
	
	// *** esto es cuando vengo de crear/editar una especialidad *** //
	var newSpecialityID;
	var $newSpeciality;
	if( ( newSpecialityID = window.location.search.match( /id=(\d+)/ ) ) ) {
		$( '.is2-speciality-crudmessages' )[0].scrollIntoView();
		$newSpeciality = $( '.is2-grid-row[data-speciality-id=' + newSpecialityID[1] + ']' );
		$theGrid.scrollTo( $newSpeciality, 1000, { onAfter: function() {
			$newSpeciality.addClass( 'is2-record-new' )[0].scrollIntoView();
			window.setTimeout( function() {
				$newSpeciality.removeClass( 'is2-record-new' );
			}, 3000 );
		} } );
	}
	
// *** remove speciality funcionality *** //
	var $preloaderForRemove = $( '.is2-preloader-remove' );
	var $specialityRemoveError = $( '.is2-speciality-remove-error' );
	var $specialityRemoveSuccess = $( '.is2-remove-success' );
	var $closeRemoveModal = $( '.is2-speciality-remove-close' );
	
	$theGrid.delegate( '.is2-trigger-remove', 'click', function( e ) {
		var $el = $( this ),
			specialityID = $el.attr( 'data-speciality-id' ),
			$row = $( 'tr[data-speciality-id=' + specialityID + ']' );
		
		$row.addClass( 'is2-record-new' );
		
		currentSpecialityID = specialityID;
	} );
	
	var removedSpeciality = function( dataResponse ) {
		isWaiting = false;
		$preloaderForRemove.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			IS2.showCrudMsg( $specialityRemoveError, 0, 6000 );
			return;
		}
		
		$( 'tr[data-speciality-id=' + dataResponse.data.id + ']' ).addClass( 'is2-record-removed' ).find( 'a, button' ).css( 'visibility', 'hidden' );
		$closeRemoveModal.click();
		IS2.showCrudMsg( $specialityRemoveSuccess );
	};

	$( '#is2-modal-remove' ).on( 'submit', function( e ) {
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		isWaiting = true;
		$preloaderForRemove.css( 'visibility', 'visible' );
		
		$.ajax( {
			url: '/especialidades/' + currentSpecialityID + '/borrar',
			dataType: 'json',
			type: 'POST',
			success: removedSpeciality,
			error: removedSpeciality
		} );
	
	} ).on( 'hidden', function( e ) {
		$( 'tr.is2-record-new' ).removeClass( 'is2-record-new' );
	} );

})();
</script>