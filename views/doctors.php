<?php t_startHead( 'Médicos' ); ?>
		<style>
			.is2-doctor-presentation {
				display: inline-block;
				width: 300px;
				padding: 5px;
				margin: 0 0 20px 0;
				white-space: nowrap;
				border-radius: 10px;
				cursor: pointer;
				transition: all 300ms ease-in-out;
			}
			.is2-doctor-presentation img {
				border-radius: 50px;
				display: inline-block;
				margin: 0 10px 0 0;
				border: 2px solid #fff;
				vertical-align: middle;
			}
			.is2-doctor-presentation-name {
				display: inline-block;
				vertical-align: bottom;
			}
			.is2-doctor-presentation-name h3 {
				display: block;
				font-size: 20px;
				white-space: pre-wrap;
				width: 210px;
				word-wrap: break-word;
				transition: all 300ms linear;
			}
			.is2-doctor-presentation-name p {
				transition: all 300ms linear; 
			}
			
		/* animation effect */
			@keyframes moveFromBottom {
			    from {
				opacity: 0;
				transform: translateY(200%);
			    }
			    to {
				opacity: 1;
				transform: translateY(0%);
			    }
			}
			@keyframes moveFromTop {
			    from {
				opacity: 0;
				transform: translateY(-200%);
			    }
			    to {
				opacity: 1;
				transform: translateY(0%);
			    }
			}
			
			.is2-doctor-presentation:hover {
				background: #5BC0DE;
				box-shadow: 0 2px 0 #32a2c3;
			}
			.is2-doctor-presentation:hover img {
				border-color: #000;
			}
			.is2-doctor-presentation:hover .is2-doctor-presentation-name h3 {
				opacity: 1;
				color:#fff;
				animation: moveFromTop 300ms ease-in-out;
			}
			.is2-doctor-presentation:hover .is2-doctor-presentation-name p {
				opacity: 1;
				animation: moveFromBottom 300ms ease-in-out;
			}
		</style>

<?php t_endHead(); ?>
<?php t_startBody( $username, 'doctors'  ); ?>
	
		<?php t_startWrapper(); ?>
		
		<div class="is2-pagetitle clearfix">
			<h3>Médicos</h3>
			<a class="btn pull-right btn-warning" href="/medicos/crear"><i class="icon-plus"></i> Crear un nuevo médico</a>
		</div>
		
		<div class="is2-doctors-grid">
		<?php foreach( $doctors as $doctor ): ?>
			<div class="is2-doctor-presentation">
				<img src="/img/<?php echo $doctor['avatar']; ?>">
				<div class="is2-doctor-presentation-name">
					<h3><?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?></h3>
					<p><?php echo $doctor['especialidad']; ?></p>
				</div>
			</div>
		<?php endforeach; ?>
		</div>

		<?php t_endWrapper(); ?>
	
<?php t_endBody(); ?>

<script>
(function() {

})();
</script>