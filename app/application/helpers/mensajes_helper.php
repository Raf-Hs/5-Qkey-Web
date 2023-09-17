<?php
function mensaje( $mensaje, $tipo = "info" ) {
	$miApp = &get_instance();
	$miApp->session->set_flashdata( "mensaje", $mensaje );
	$miApp->session->set_flashdata( "tipo",    $tipo );
}

function alert( $tipo, $mensaje ) {
	switch( $tipo ) {
		case "success":
			$icono = "fa-check-circle";
			break;

		case "primary":
		case "secondary":
		case "light":
		case "dark":
		case "info":
			$icono = "fa-info-circle";
			break;

		case "warning":
			$icono = "fa-exclamation-triangle";
			break;

		case "danger":
			$icono = "fa-ban";
			break;

	}
?>
	<div class="alert alert-<?= $tipo ?> alert-dismissible fade show col-md-6 mt-4" role="alert">
	  <i class="fas <?= $icono ?> fa-2x"></i> <?= $mensaje ?>.
	  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php
}
?>