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
		.is2-grid td:last-child > .btn:not( :last-child ) {
			margin: 0 5px 0 0;
		}
	</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'specialities'  ); ?>
	
		<?php t_startWrapper(); ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Especialidades</h3>
				<a class="is2-trigger-create btn pull-right btn-warning" href="#is2-modal-theform" data-toggle="modal"><i class="icon-plus"></i> Crear una nueva especialidad</a>
			</div>

			<div class="is2-crud-messages">
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
						<td class="is2-speciality-name" data-field-name="name"><?php echo $speciality['nombre']; ?></td>
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
		<form id="is2-modal-theform" class="is2-modal-create is2-modal-edit modal hide fade form-horizontal">
			<div class="modal-header">
				<a class="close" data-dismiss="modal">&times;</a>
				<strong class="is2-edit">Editar especialidad</strong>
				<strong class="is2-create">Crear especialidad</strong>
			</div>
			<div class="modal-body">
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-create-error" style="display:none">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<strong>¡No se ha podido crear la nueva especialidad!</strong>
					<div>Verifique no exista una con el mismo nombre ya cargada en el sistema</div>
				</div>
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-edit-error" style="display:none">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<strong>¡No se ha podido editar la especialidad!</strong>
					<div>Verifique no exista una con el mismo nombre ya cargada en el sistema</div>
				</div>
				<div class="control-group">
					<label class="control-label">Nombre de la especialidad:</label>
					<div class="controls">
						<input type="text" class="is2-field input-xlarge" name="name" data-field-required="true">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary is2-edit" type="submit">Confirmar cambios</button>
				<button class="btn btn-primary is2-create" type="submit">Crear especialidad</button>
				<span class="is2-preloader is2-preloader-bg pull-left"></span>
			</div>
		</form>
		
		<form id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<div class="alert alert-error is2-ajax-msg is2-ajax-msg-full is2-remove-error" style="display:none">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<strong>¡No se ha podido borrar la especialidad!</strong>
					<div>Verifique no existan médicos que tengan asociado esta especialidad</div>
				</div>
				<button type="button" class="close is2-close-button" data-dismiss="modal">&times;</button>
				<p><strong>¿Estás seguro que desea borrar esta especialidad del sistema?</strong></p>
				<div class="alert">
					<strong>Tenga en cuenta que no puede borrar una especialidad que tenga médicos asociados</strong>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit">Borrar</button>
				<span class="is2-preloader is2-preloader-bg pull-left"></span>
			</div>
		</form>
		
<?php t_endBody(); ?>

<script>
(function() {

	var crud = new IS2.CRUD( 'especialidades', 'data-speciality-id' );
	// look if the user comes from a create/edit redirection
	crud.lookForCRUD();
	
// *** create *** //
	new crud.Create( crud );
// *** edit *** //
	new crud.Edit( crud );
// *** remove *** //
	new crud.Remove( crud );
	
})();
</script>