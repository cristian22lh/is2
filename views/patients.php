<?php t_startHead( 'Pacientes' ); ?>
		<style>
			label {
				cursor: default;
			}
			th {
				text-align: center !important;
			}
			td span {
				display: block;
				word-wrap: break-word;
				font-size: 12px;
			}
			td:nth-child( 1 ) span,
			td:nth-child( 2 ) span {
				width: 80px;
			}
			td:nth-child( 4 ) span {
				width: 65px;
			}
			td:nth-child( 6 ) span {
				width: 65px;
			}
			td:nth-child( 7 ) span {
				width: 100px;
				text-transform: none;
			}
			td:nth-child( 8 ) span {
				width: 100px;
				text-transform: uppercase;
			}
			td:nth-child( 9 ) span {
				width: 130px;
			}
			td:nth-child( 10 ) span {
				text-align: center;
			}
			td:nth-child( 10 ) span a:first-child {
				margin: 0 0 3px 0;
			}
			.pagination {
				margin: 20px 0 0 0;
			}
		</style>
<?php t_endHead(); ?>
<?php t_startBody( $username, 'patients'  ); ?>
	
		<?php t_startWrapper(); ?>
			<?php if( $removeSuccess ): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡El paciente junto con sus turnos asociados han sido borrados satisfactoriamente!
			</div>
			<?php elseif( $removeError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				¡No se ha podido borrar al paciente! Vuelva a intentarlo.
			</div>
			<?php elseif( $editError ): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				<strong>No existe paciente con tal identificador cargado en el sistema.</strong>
			</div>
			<?php endif; ?>
		
			<div class="is2-pagetitle clearfix">
				<h3>Pacientes</h3>
				<a class="btn pull-right" href="/pacientes/crear"><i class="icon-plus"></i> Crear un nuevo paciente</a>
			</div>
			
			<div class="pagination pagination-centered">
				<ul>
			<?php foreach( range( 'A', 'Z' ) as $char ): ?>
					<li class="<?php echo $char == $letter ? 'active' : ''; ?>">
						<a href="/pacientes/listar-por-letra/<?php echo $char; ?>"><?php echo $char; ?></a>
					</li>
			<?php endforeach; ?>
				</ul>
			</div>
			
			<?php if( count( $patients ) ): ?>
			<table class="table table-striped is2-grid">
				<thead>
					<tr>
						<th>Apellidos</th>
						<th>Nombres</th>
						<th>Sexo</th>
						<th>DNI</th>
						<th>Fecha de nacimiento</th>
						<th>Teléfono</th>
						<th>Correo electrónico</th>
						<th>Obra social</th>
						<th>Número de afiliado</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach( $patients as $patient ): ?>
					<tr data-patient-id="<?php echo $patient['id']; ?>">
						<td>
							<span title="<?php echo $patient['apellidos']; ?>"><?php echo $patient['apellidos']; ?></span>
						</td>
						<td>
							<span title="<?php echo $patient['nombres']; ?>"><?php echo $patient['nombres']; ?></span>
						</td>
						<td><?php echo $patient['sexo']; ?></td>
						<td>
							<span title="<?php echo $patient['dni']; ?>"><?php echo $patient['dni']; ?></span>
						</td>
						<td><?php echo __dateISOToLocale( $patient['fechaNacimiento'] ); ?></td>
						<td>
							<span title="<?php echo $patient['telefono']; ?>"><?php echo $patient['telefono']; ?></span>
						</td>
						<td>
							<span title="<?php echo $patient['email']; ?>"><?php echo $patient['email']; ?></span>
						</td>
						<td>
							<span title="<?php echo $patient['obraSocialNombre']; ?>"><?php echo $patient['obraSocialNombre']; ?></span>
						<td>
							<span title="<?php echo $patient['nroAfiliado']; ?>"><?php echo $patient['nroAfiliado']; ?></span>
						</td>
						<td>
							<span>
								<a class="btn btn-mini" href="/pacientes/<?php echo $patient['id']; ?>/editar" title="Editar" data-placement="left"><i class="icon-edit"></i></a>
								<a class="btn btn-mini btn-danger is2-trigger-remove" href="#is2-modal-remove" data-toggle="modal" data-patient-id="<?php echo $patient['id']; ?>" data-placement="right"><i class="icon-remove-sign" title="Borrar"></i></a>
							</span>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			
			<?php if( !$isSingle ): ?>
			<ul class="pager">
				<li class="previous <?php echo $offset ? 'active': 'disabled'; ?>">
					<a href="<?php echo $offset == 0 ? '#' : '?pagina=' . ($offset-1); ?>">&larr; Anterior</a>
				</li>
				<li class="next <?php echo $stillMorePages ? 'active': 'disabled'; ?>">
					<a href="<?php echo $stillMorePages ? '?pagina=' . ($offset+1) : '#'; ?>">Siguiente &rarr;</a>
				</li>
			</ul>
			<?php endif; ?>
			
			<?php else: ?>
			<div class="alert alert-error">
				No se han encontrado pacientes según el criterio de búsqueda específicado
			</div>
			<?php endif; ?>

		<?php t_endWrapper(); ?>
		
		<!-- los modals -->
		<form method="post" action="/pacientes/borrar" id="is2-modal-remove" class="modal hide fade">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<span><strong>¿Estás seguro que desea borrar este paciente del sistema?</strong> Sepa que también se eleminarán sus turnos asociados.</span>
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
	$( '.is2-grid' ).delegate( '.is2-trigger-remove', 'click', function( e ) {
		$( '#is2-modal-remove' ).find( 'input[name="id"]' ).val( $( this ).attr( 'data-patient-id' ) );
	} );
})();
</script>