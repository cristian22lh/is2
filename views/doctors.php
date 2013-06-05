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
			box-shadow: 0 -2px 0 #555;
		}
		.is2-doctor-presentation:hover .is2-doctor-presentation-name h3 {
			opacity: 1;
			color: #fff;
			animation: moveFromTop 300ms ease-in-out;
			text-shadow: 0 -1px 0 #555;
		}
		.is2-doctor-presentation:hover .is2-doctor-presentation-name p {
			opacity: 1;
			animation: moveFromBottom 300ms ease-in-out;
			color: #fff;
			text-shadow: 0 -1px 0 #555;
		}
		
		/* modal */
		#is2-modal-doctor {
			background: #fff;
			padding: 0;
			width: 850px;
			height: 495px;
			z-index: 100000;
			overflow: hidden;
		}
		#is2-modal-doctor .modal-body {
			line-height: 0;
			overflow: hidden;
			padding: 0;
			position: absolute;
			right: 4px;
			top: 5px;
		}
		.is2-modal-details-body {
			height: 495px;
			overflow: hidden;
		}
		.is2-modal-details-body td:last-child {
			width: 60px;
		}
		.is2-modal-details-body h3 {
			margin: 5px 0 0 0;
		}
		
		.is2-modal-doctor-information {
			float: left;
			width: 200px;
			padding: 30px;
			height: 100%;
			text-align: center;
			text-shadow: 0 -1px 0 #555;
			border-right: 1px solid #58CAF5;
		}
		.is2-modal-doctor-information img {
			border-radius: 50px;
			display: block;
			margin: 0 auto;
			box-shadow: 0 -2px 0 #555;
		}
		
		.is2-modal-doctor-availability {
			border-left: 1px solid #0C688A;
			float: left;
			width: 300px;
			padding: 20px 10px;
			height: 100%;
			border-right: 1px solid #ddd;
		}
		.is2-modal-doctor-insurances {
			float: left;
			width: 250px;
			padding: 20px 0 20px 10px;
			height: 100%;
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
			<div class="is2-doctor-presentation" data-doctor-id="<?php echo $doctor['id']; ?>">
				<img src="/img/<?php echo $doctor['avatar']; ?>">
				<div class="is2-doctor-presentation-name">
					<h3><?php echo $doctor['apellidos'] . ', ' . $doctor['nombres']; ?></h3>
					<p><?php echo $doctor['especialidad']; ?></p>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		
		<a class="is2-modal-doctor-trigger" href="#is2-modal-doctor" data-toggle="modal" style="display:none"></a>
		<div id="is2-modal-doctor" class="modal hide fade">
			<div class="is2-modal-wrapper">
				<div class="progress progress-striped active is2-modal-preloader">
					<div class="bar"></div>
				</div>
				<div class="is2-modal-details-header">
					<div class="modal-body">
						<button class="btn btn-link is2-modal-close" data-dismiss="modal">
							<i class="icon-remove-sign"></i>
						</button>
					</div>
				</div>
				<div class="is2-modal-details-body">
					<div class="is2-modal-doctor-information btn-info">
						<img src="" class="is2-modal-doctor-avatar">
						<h3><span class="is2-modal-doctor-field" data-field-name="apellidos"></span>, <span class="is2-modal-doctor-field" data-field-name="nombres"></span></h3>
						<p class="is2-modal-doctor-field" data-field-name="especialidad"></p>
						<div class="is2-modal-doctor-information-misc">
							<p>Matricula: <strong class="is2-modal-doctor-field" data-field-name="matricula"></strong></p>
						</div>
					</div>
					
					<div class="is2-modal-doctor-availability">
						<h3>Horarios</h3>
						<table class="table is2-modal-doctor-availability-grid">
							<tr class="is2-modal-doctor-availability-record">
								<td class="is2-field" data-field-name="diaNombre"></td>
								<td class="is2-field" data-field-name="horaIngreso"></td>
								<td class="is2-field" data-field-name="horaEgreso"></td>
								<td>
									<a class="btn btn-mini" href="#" title="Editar" data-toggle="modal"><i class="icon-edit"></i></a>
									<a class="btn btn-mini btn-danger is2-trigger-remove" href="#" data-toggle="modal" title="Borrar"><i class="icon-remove-sign"></i></a>
								</td>
							</tr>
						</table>
					</div>
					
					<div class="is2-modal-doctor-insurances">
						<h3>Obras sociales</h3>
						<table class="table is2-modal-doctor-insurances-grid">
							<tr class="is2-modal-doctor-insurances-record">
								<td>
									<p class="is2-field" data-field-name="nombreCorto"></p>
									<p class="is2-field" data-field-name="nombreCompleto"></p>
								</td>
								<td>
									<a class="btn btn-mini" href="#" title="Editar" data-toggle="modal"><i class="icon-edit"></i></a>
									<a class="btn btn-mini btn-danger is2-trigger-remove" href="#" data-toggle="modal" title="Borrar"><i class="icon-remove-sign"></i></a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>

		<?php t_endWrapper(); ?>
	
<?php t_endBody(); ?>

<script>
(function() {

// *** modal functionality *** //
	var $triggerModal = $( '.is2-modal-doctor-trigger' );
	var $doctorModal = $( '#is2-modal-doctor' );
	$doctorModal.on( 'hidden', function( e ) {
		window.location.hash = '';
	} );
	
	$doctorModal .css( 'left', $( window ).outerWidth() /2 - 850 / 2 ).css( 'margin-left', 0 );
	var $doctorModalPreloader = $( '.is2-modal-preloader' );
	var $doctorModalPreloaderBar = $doctorModalPreloader.find( '.bar' );
	var isWaiting = false;
	
	var $doctorFields = $( '.is2-modal-doctor-field' );
	var $doctorAvatar = $( '.is2-modal-doctor-avatar' );
	
	var $doctorAvailabilitiesWrapper = $( '.is2-modal-doctor-availability-grid' );
	var $doctorAvailabilitiesRecord = $( '.is2-modal-doctor-availability-record' ).clone();
	$( '.is2-modal-doctor-availability-record' ).remove();
	
	var $doctorInsurancesWrapper = $( '.is2-modal-doctor-insurances-grid' );
	var $doctorInsurancesRecord = $( '.is2-modal-doctor-insurances-record' );
	$( '.is2-modal-doctor-insurances-record' ).remove();
	
	var populateGrid = function( $wrapper, $template, data, callback ) {
		$wrapper.empty();
		var recordData, $record, $fields, $field;
		while( data.length ) {
			recordData = data.shift();
			$record = $template.clone();
			
			$fields = $record.find( '.is2-field' );
			for( i = 0, l = $fields.length; i < l; i++ ) {
				$field = $fields.eq( i );
				$field.html( recordData[$field.attr( 'data-field-name' )] );
			}
			callback( $record, recordData );
			
			$wrapper.append( $record );
		}
	};
	
	var showDoctorDetails = function( dataResponse ) {
		isWaiting = false;
		$doctorModalPreloaderBar.css( 'width', '100%' );
		window.setTimeout( function() {
			$doctorModalPreloader.fadeOut( 'fast' );
		}, 500 );
		if( !dataResponse.success ) {
			return;
		}
		
		var data = dataResponse.data,
			doctorData = data.doctor,
			availabilities = data.availabilities,
			insurances = data.insurances;
			
		var i = 0, l = $doctorFields.length, $field;
		for( ; i < l; i++ ) {
			$field = $doctorFields.eq( i );
			$field.html( doctorData[$field.attr( 'data-field-name' )] );
		}
		$doctorAvatar.attr( 'src', '/img/' + doctorData['avatar'] );
		
		populateGrid( $doctorAvailabilitiesWrapper, $doctorAvailabilitiesRecord, availabilities, function( $record, data ) {
			$record.attr( 'data-availability-id', data['id'] ).attr( 'data-availability-day', data['dia'] );
		} );
		populateGrid( $doctorInsurancesWrapper, $doctorInsurancesRecord, insurances, function( $record, data ) {
			$record.attr( 'data-insurance-id', data['id'] );
		} );
		
	};
	
	$( '.is2-doctor-presentation' ).on( 'click', function( e ) {
		if( isWaiting ) {
			return;
		}
		
		// show modal
		$triggerModal.click();
		$doctorModalPreloaderBar.css( 'width', '1%' );
		$doctorModalPreloader.fadeIn( 'fast' );
		isWaiting = true;

		var doctorID = $( this ).attr( 'data-doctor-id' );
		window.location.hash = 'id=' + doctorID;
		// get doctor availabilities and insurances support
		$.ajax( {
			url: '/medicos/' + doctorID,
			dataType: 'json',
			type: 'GET',
			success: showDoctorDetails,
			error: showDoctorDetails
		} );
	} );
	
// *** change hash listener *** //
	var $window = $( window );
	$window.on( 'hashchange', function( e ) {
		var hash = window.location.hash,
			doctorID = hash.match( /id=(\d+)/ );
			
		if( doctorID ) {
			doctorID = doctorID[1];
			$( '.is2-doctor-presentation[data-doctor-id=' + doctorID + ']' ).click();
			
		} else {
			$doctorModal.find( '.is2-modal-close' ).click();
		}
		
	} );
	
	window.setTimeout( function() {
		$window.trigger( 'hashchange' );
	}, 500 );
	
})();
</script>