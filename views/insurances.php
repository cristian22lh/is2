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
		.is2-insurances-crud > .btn:not( last-child ) {
			margin: 0 5px 0 0;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'insurances'  ); ?>

		<?php t_startWrapper(); ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Obras sociales</h3>
				<a class="is2-trigger-create btn pull-right btn-warning" href="#is2-modal-theform" data-toggle="modal"><i class="icon-plus"></i> Crear una nueva obra social</a>
				<form class="form-search pull-right is2-search-quick-form">
					<div class="is2-search-quick-control input-append control-group">
						<input type="text" class="input-large search-query is2-search-quick-input" placeholder="Buscar por nombre abreviado..." name="keyword">
						<button type="submit" class="btn"><i class="icon-search"></i></button>
					</div>
				</form>
			</div>

			<div class="is2-crud-messages">
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
							<span class="is2-insurance-abbrname" data-insurance-id="<?php echo $insurance['id']; ?>" data-field-name="abbr"><?php echo $insurance['nombreCorto']; ?></span>
							<span class="is2-insurance-fullname" data-field-name="full"><?php echo $insurance['nombreCompleto']; ?></span>
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
		<form id="is2-modal-theform" class="is2-modal-create is2-modal-edit modal hide fade form-horizontal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<strong class="is2-edit">Editar obra social</strong>
				<strong class="is2-create">Crear obra social</strong>
			</div>
			<div class="modal-body">
				<div class="alert is2-create">
					Sepa que no pueden existir dos obras sociales con el mismo nombre abreviado
				</div>
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-create-error" style="display:none">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<strong>¡No se ha podido crear la nueva obra social!</strong>
					<div>Verifique no exista una con el mismo nombre abreviado ya cargada en el sistema</div>
				</div>
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-edit-error" style="display:none">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<strong>¡No se ha podido editar la obra social!</strong>
					<div>Verifique no exista una con el mismo nombre abreviado ya cargada en el sistema</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombre abreviado:</label>
					<div class="controls">
						<input type="text" class="is2-field input-xlarge" name="abbr" data-field-required="true">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombre completo:</label>
					<div class="controls">
						<textarea class="is2-field input-xlarge" name="full"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary is2-edit" type="submit">Confirmar cambios</button>
				<button class="btn btn-primary is2-create" type="submit">Crear obra social</button>
				<span class="is2-preloader is2-preloader-bg pull-left"></span>
			</div>
		</form>
		
		<form id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-remove-error" style="display:none">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<strong>¡No se ha podido borrar obra social!</strong>
					<div>Verifique no existan pacientes que tengan asociado esta obra social</div>
				</div>
				<button type="button" class="close is2-close-button" data-dismiss="modal">&times;</button>
				<p><strong>¿Estás seguro que desea borrar esta obra social del sistema?</strong></p>
				<div class="alert">
					<strong>Tenga en cuenta que no puede borrar una obra social que tenga pacientes asociados</strong>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
				<span class="is2-preloader is2-preloader-bg pull-left"></span>
			</div>
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
		</form>

<?php t_endBody(); ?>

<script>
(function() {
	
	var crud = new IS2.CRUD( 'obras-sociales', 'data-insurance-id' );
	// look if the user comes from a create/edit redirection
	crud.lookForCRUD();
	
// *** create *** //
	new crud.Create( crud );
// *** edit *** //
	new crud.Edit( crud );
// *** remove *** //
	new crud.Remove( crud );
	
// *** habilitar/deshabilitar obra social funcionalidad *** //
	var $theGrid = $( '.is2-grid-wrapper' );
	var $preloaderForStatus = $( '.is2-preloader-status' );
	var $closeStatusModal = $( '.is2-insurances-status-close' );
	var $disableMsg = $( '.is2-status-disable-success' );
	var $enableMsg = $( '.is2-status-enable-success' );
	var toggleStatus;
	var isWaiting = false;
	
	$theGrid.delegate( '.is2-trigger-status', 'click', function( e ) {
		var $el = $( this ),
			insuranceID = $el.attr( 'data-insurance-id' ),
			$row = $( 'tr[data-insurance-id=' + insuranceID + ']' ),
			status = $row.attr( 'data-insurance-status' );

		toggleStatus = status === 'habilitada' ? 'deshabilitar' : 'habilitar';

		$row.addClass( 'is2-record-new' );
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
			success: statusedInsurance,
			error: statusedInsurance
		} );
		
	} ).on( 'hidden', function( e ) {
		$( 'tr.is2-record-new' ).removeClass( 'is2-record-new' );
	} );
	
// *** search functionality *** //
	var $keyword = $( '.is2-search-quick-input' );
	var $keywordGroupControl = $( '.is2-search-quick-control' );
	var $allAbbrNames = $( 'tr .is2-insurance-abbrname' );
	var currentMatch = 0;
	var curKeyword;
	var matches = [];
	$( '.is2-search-quick-form' ).on( 'submit', function( e ) {
		e.preventDefault();
		
		var keyword = $keyword.val().trim().toLowerCase();
		
		if( keyword && keyword !== curKeyword ) {
			// reset
			curKeyword = keyword;
			currentMatch = 0;
			matches = [];
		
			var $abbrName,
				i = 0, l = $allAbbrNames.length;

			for( ; i < l; i++ ) {
				$abbrName = $allAbbrNames.eq( i );
				if( $abbrName.html().toLowerCase().indexOf( keyword ) >= 0 ) {
					matches.push( $abbrName );
				}
			}
		}
		
		if( matches.length ) {
			$keywordGroupControl.removeClass( 'error' );
		
			var $row,
				$prevRow;
				
			$abbrName = matches[currentMatch++];
			if( currentMatch === matches.length ) {
				currentMatch = 0;
			}
			$row = $( 'tr[data-insurance-id=' + $abbrName.attr( 'data-insurance-id' ) + ']' );
			$row.effect( 'highlight' );
			$prevRow = $row.prev();
			if( !$prevRow.length ) {
				$prevRow = $row;
			}
			$prevRow[0].scrollIntoView();
			
		// not matches
		} else {
			$keywordGroupControl.addClass( 'error' );
		}
		
	} );
	
})();
</script>