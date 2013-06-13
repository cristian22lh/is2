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
			white-space: nowrap;
		}
		.is2-grid-row.is2-insurance-disabled {
			background: #f1f1f1;
		}
		.btn.is2-trigger-status {
			width: 60px;
		}
		.is2-insurances-togglestatus {
			display: inline-block;
		}
		.is2-insurances-crud {
			display: inline-block;
			margin: 0 0 0 15px;
		}
		
		.is2-grid-header-wrapper {
			position: relative;
			overflow: hidden;
		}
		.is2-grid-header-wrapper .alert {
			opacity: 1;
			box-shadow: none;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'insurances'  ); ?>

		<?php t_startWrapper(); ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Obra sociales</h3>
				<a class="is2-trigger-new btn pull-right btn-warning" href="#is2-modal-theform" data-toggle="modal"><i class="icon-plus"></i> Crear una nueva obra social</a>
			</div>

			<div class="alert">
				A continuación se muestran todas las obra sociales cargadas en el sistema
			</div>

			<div class="is2-insurances-crudmessages">
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
					¡La obra social ha sido borrada satisfactoriamente!
				</div>
				<div class="alert alert-success is2-status-enable-success is2-ajax-msg">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					¡La obra social ha sido habilitada satisfactoriamente!
				</div>
				<div class="alert alert-success is2-status-disable-success is2-ajax-msg">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					¡La obra social ha sido deshabilitada satisfactoriamente!
				</div>
			</div>
			<div class="is2-grid-wrapper">
				<table class="table is2-grid">
				<?php foreach( $insurances as $insurance ): ?>
					<tr class="is2-grid-row <?php echo $insurance['estado'] == 'deshabilitada' ? 'is2-insurance-disabled' : ''; ?>" data-insurance-id="<?php echo $insurance['id']; ?>" data-insurance-status="<?php echo $insurance['estado']; ?>">
						<td>
							<span class="is2-insurance-abbrname"><?php echo $insurance['nombreCorto']; ?></span>
							<span class="is2-insurance-fullname"><?php echo $insurance['nombreCompleto']; ?></span>
						</td>
						<td>
						<?php if( $insurance['id'] != 1 ): ?>
							<div class="is2-insurances-togglestatus">
								<a class="btn btn-small btn-warning is2-trigger-status is2-trigger-status-disable" href="#is2-modal-status-disable" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>" style="display:<?php echo $insurance['estado'] == 'habilitada' ? 'block' : 'none'; ?>">Deshabilitar</a>
								<a class="btn btn-small btn-link is2-trigger-status is2-trigger-status-enable" href="#is2-modal-status-enable" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>" style="display:<?php echo $insurance['estado'] == 'habilitada' ? 'none' : 'block'; ?>">Habilitar</a>
							</div>
							<div class="is2-insurances-crud">
								<a class="btn btn-small is2-trigger-edit" href="#is2-modal-theform" data-toggle="modal" data-insurance-id="<?php echo $insurance['id']; ?>">Editar</a>
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
		<form id="is2-modal-theform" class="modal hide fade form-horizontal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong class="is2-insurance-edit">Editar obra social</strong>
				<strong class="is2-insurance-new">Crear obra social</strong>
			</div>
			<div class="modal-body">
				<div class="alert is2-insurance-new">
					Sepa que no pueden existir dos obras sociales con el mismo nombre abreviado
				</div>
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-insurance-new-error" style="display:none">
					<strong>¡No se ha podido crear la nueva obra social!</strong>
					<div>Verifique no exista una con el mismo nombre abreviado ya cargada en el sistema</div>
				</div>
				<div class="control-group is2-insurances-abbr">
					<label class="control-label">Nombre abreviado:</label>
					<div class="controls">
						<input type="text" class="is2-insurances-abbr input-xlarge" name="abbr">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombre completo:</label>
					<div class="controls">
						<textarea class="is2-insurances-full input-xlarge" name="full"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary is2-insurance-edit" type="submit">Confirmar cambios</button>
				<button class="btn btn-primary is2-insurance-new" type="submit">Crear obra social</button>
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-newedit"></span>
			</div>
			<input class="is2-insurances-id" type="hidden" name="id">
		</form>
		
		<form id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-insurance-remove-error" style="display:none">
					<strong>¡No se ha podido borrar obra social!</strong>
					<div>Verifique no existan pacientes que tengan asociado esta obra social</div>
				</div>
				<button type="button" class="close is2-insurances-remove-close" data-dismiss="modal">&times;</button>
				<p><strong>¿Estás seguro que desea borrar esta obra social del sistema?</strong></p>
				<div class="alert">
					<strong>Tenga en cuenta que no puede borrar una obra social que tenga pacientes asociados</strong>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-remove"></span>
			</div>
			<input class="is2-insurances-remove-id" type="hidden" name="id">
		</form>
		
		<form id="is2-modal-status-disable" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close is2-insurances-status-close" data-dismiss="modal">&times;</button>
				<p><strong>¿Estás seguro que desea deshabilitar esta obra social?</strong></p>
				<div class="alert">
					Deshabilitar una obra social hace que no se puedan crear turnos con pacientes que tengan asociada esta obra social en cuestión
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Deshabilitar obra social</button>
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-status"></span>
			</div>
			<input class="is2-insurances-status-id" type="hidden" name="id">
		</form>
		
		<form id="is2-modal-status-enable" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close is2-insurances-status-close" data-dismiss="modal">&times;</button>
				<strong>¿Estás seguro que desea habilitar esta obra social?</strong>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Habilitar obra social</button>
				<span class="is2-preloader is2-preloader-bg pull-left is2-preloader-status"></span>
			</div>
			<input class="is2-insurances-status-id" type="hidden" name="id">
		</form>

<?php t_endBody(); ?>

<script>
(function() {

// *** crear/edicion obra social *** //
	var $theGrid = $( '.is2-grid-wrapper' );
	var $theForm = $( '#is2-modal-theform' );
	var $insuranceID = $( '.is2-insurances-id' );
	var $abbrName = $( 'input.is2-insurances-abbr' );
	var $fullName = $( '.is2-insurances-full' );
	var ajaxConfig;
	var $abbrNameControlGroup = $( '.control-group.is2-insurances-abbr' );
	var $preloader = $( '.is2-preloader-newedit' );
	var $insuranceCreateError = $( '.is2-insurance-new-error' );
	var isWaiting = false;
	var currentInsuranceID;

	
	// ** create insurance funcionality
	var ajaxCreate = function() {
		return {
			url: '/obras-sociales/crear',
			dataType: 'json',
			type: 'POST',
			data: {
				abbr: $abbrName.val(),
				full: $fullName.val()
			},
			success: createdInsurance,
			error: createdInsurance
		};
	};
	
	$( '.is2-trigger-new' ).on( 'click', function( e ) {
		$( '.is2-insurance-edit' ).hide();
		$( '.is2-insurance-new' ).show();
		
		ajaxConfig = ajaxCreate;
	} );

	var createdInsurance = function( dataResponse ) {
		isWaiting = false;
		$preloader.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			IS2.showCrudMsg( $insuranceCreateError, 0, 6000 );
			$abbrNameControlGroup.addClass( 'error' );
			return;
		}
		
		window.location = '/obras-sociales?exito=crear-obra-social&id=' + dataResponse.data.id;
	};

	$theForm.on( 'submit', function( e ) {
		e.preventDefault();
		if( IS2.lookForEmptyFields( $abbrName, true, true ) ) {
			return;
		}
		$abbrNameControlGroup.removeClass( 'error' );

		isWaiting = true;
		$preloader.css( 'visibility', 'visible' );
		
		$.ajax( ajaxConfig() );
	
	} );
	$( '#is2-modal-theform' ).on( 'hidden', function( e ) {
		$( 'tr.is2-record-new' ).removeClass( 'is2-record-new' );
	} );
	
	// *** edit insurance funcionality
	var editedInsurance = function( dataResponse ) {
		isWaiting = false;
		$preloader.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			IS2.showCrudMsg( $insuranceCreateError, 0, 6000 );
			$abbrNameControlGroup.addClass( 'error' );
			return;
		}
		
		window.location = '/obras-sociales?exito=editar-obra-social&id=' + dataResponse.data.id;
	};
	
	var ajaxEdit = function() {
		return {
			url: '/obras-sociales/' + currentInsuranceID + '/editar',
			dataType: 'json',
			type: 'POST',
			data: {
				abbr: $abbrName.val(),
				full: $fullName.val(),
				id: $insuranceID.val()
			},
			success: editedInsurance,
			error: editedInsurance
		};
	};
	
	$theGrid.delegate( '.is2-trigger-edit', 'click', function( e ) {
		$( '.is2-insurance-edit' ).show();
		$( '.is2-insurance-new' ).hide();
	
		var insuranceID = $( this ).attr( 'data-insurance-id' ),
			$row = $( 'tr[data-insurance-id=' + insuranceID + ']' );
			
		$row.addClass( 'is2-record-new' );
		$insuranceID.val( insuranceID );
		$abbrName.val( $row.find( '.is2-insurance-abbrname' ).html() );
		$fullName.val( $row.find( '.is2-insurance-fullname' ).html() );
		
		ajaxConfig = ajaxEdit;
		currentInsuranceID = insuranceID;
	} );
	
	// *** esto es caudnbo vegno de crear/editar una bora social
	var newInsuranceID;
	var $newInsurance;
	if( ( newInsuranceID = window.location.search.match( /id=(\d+)/ ) ) ) {
		$( '.is2-insurances-crudmessages' )[0].scrollIntoView();
		$newInsurance = $( '.is2-grid-row[data-insurance-id=' + newInsuranceID[1] + ']' );
		$theGrid.scrollTo( $newInsurance, 1000, { onAfter: function() {
			$newInsurance.addClass( 'is2-record-new' )[0].scrollIntoView();
			window.setTimeout( function() {
				$newInsurance.removeClass( 'is2-record-new' );
			}, 3000 );
		} } );
	}
	
// *** remover obra social funcionalidad *** //
	var $insuranceIDFoRemove = $( '.is2-insurances-remove-id' );
	var $preloaderForRemove = $( '.is2-preloader-remove' );
	var $insuranceRemoveError = $( '.is2-insurance-remove-error' );
	var $insuranceRemoveSuccess = $( '.is2-remove-success' );
	var $closeRemoveModal = $( '.is2-insurances-remove-close' );
	
	$theGrid.delegate( '.is2-trigger-remove', 'click', function( e ) {
		var insuranceID = $( this ).attr( 'data-insurance-id' ),
			$row = $( 'tr[data-insurance-id=' + insuranceID + ']' );
			
		$insuranceRemoveError.hide();
		$row.addClass( 'is2-record-new' );
		$insuranceIDFoRemove.val( insuranceID );
	} );
	$( '#is2-modal-remove' ).on( 'hidden', function( e ) {
		$( 'tr.is2-record-new' ).removeClass( 'is2-record-new' );
	} );
	
	var removedInsurance = function( dataResponse ) {
		isWaiting = false;
		$preloaderForRemove.css( 'visibility', 'hidden' );
		if( !dataResponse.success ) {
			IS2.showCrudMsg( $insuranceRemoveError, 0, 6000 );
			return;
		}
		
		$( 'tr[data-insurance-id=' + dataResponse.data.id + ']' ).addClass( 'is2-record-removed' ).find( 'a, button' ).css( 'visibility', 'hidden' );
		$closeRemoveModal.click();
		IS2.showCrudMsg( $insuranceRemoveSuccess );
	};
	
	$( '#is2-modal-remove' ).on( 'submit', function( e ) {
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		isWaiting = true;
		$preloaderForRemove.css( 'visibility', 'visible' );
		
		$.ajax( {
			url: '/obras-sociales/borrar',
			dataType: 'json',
			type: 'POST',
			data: {
				id: $insuranceIDFoRemove.val()
			},
			success: removedInsurance,
			error: removedInsurance
		} );
	} );
	
// *** habilitar/deshabilitar obra social funcionalidad *** //
	var $insuranceIDForStatus = $( '.is2-insurances-status-id' );
	var $preloaderForStatus = $( '.is2-preloader-status' );
	var $closeStatusModal = $( '.is2-insurances-status-close' );
	var $disableMsg = $( '.is2-status-disable-success' );
	var $enableMsg = $( '.is2-status-enable-success' );
	var toggleStatus;
	
	$theGrid.delegate( '.is2-trigger-status', 'click', function( e ) {
		var $el = $( this ),
			insuranceID = $el.attr( 'data-insurance-id' ),
			$row = $( 'tr[data-insurance-id=' + insuranceID + ']' ),
			status = $row.attr( 'data-insurance-status' );

		toggleStatus = status === 'habilitada' ? 'deshabilitar' : 'habilitar';

		$row.addClass( 'is2-record-new' );
		$insuranceIDForStatus.val( insuranceID );
		currentInsuranceID = insuranceID;
	} );
	
	var statusedInsurance = function( dataResponse ) {
		isWaiting = false;
		$preloaderForStatus.css( 'visibility', 'hidden' );
		
		if( !dataResponse.success ) {
			return;
		}
		
		var $row = $( 'tr[data-insurance-id=' + dataResponse.data.id + ']' );
		if( $row.attr( 'data-insurance-status' ) === 'habilitada' ) {
			$row.attr( 'data-insurance-status', 'deshabilitada' ).addClass( 'is2-insurance-disabled' );
			$row.find( '.is2-trigger-status-disable' ).hide();
			$row.find( '.is2-trigger-status-enable' ).show();
			IS2.showCrudMsg( $disableMsg );
		} else {
			$row.attr( 'data-insurance-status', 'habilitada' ).removeClass( 'is2-insurance-disabled' );
			$row.find( '.is2-trigger-status-disable' ).show();
			$row.find( '.is2-trigger-status-enable' ).hide();
			IS2.showCrudMsg( $enableMsg );
		}
		
		$row.effect( 'highlight', null, 3000 );
		$closeStatusModal.click();
	};
	
	$( '#is2-modal-status-enable, #is2-modal-status-disable' ).on( 'submit', function( e ) {
		e.preventDefault();
		if( isWaiting ) {
			return;
		}
		
		isWaiting = true
		$preloaderForStatus.css( 'visibility', 'visible' );
		
		$.ajax( {
			url: '/obras-sociales/' + currentInsuranceID + '/' + toggleStatus,
			dataType: 'json',
			type: 'POST',
			data: {
				id: $insuranceIDForStatus.val()
			},
			success: statusedInsurance,
			error: statusedInsurance
		} );
		
	} ).on( 'hidden', function( e ) {
		$( 'tr.is2-record-new' ).removeClass( 'is2-record-new' );
	} )
	
})();
</script>