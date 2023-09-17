<?php
function verifica_sesion( $idjugador, $token ) {
	// Referencia a mi propia aplicación
	$miApp = &get_instance();

	if ( !(	$miApp->session->has_userdata( "idjugador" ) &&
				$miApp->session->has_userdata( "token" ) &&
				$miApp->session->idjugador == $idjugador &&
				$miApp->session->token     == $token ) ) {
		// La sesión en inválida
		mensaje( "Sesión inválida", "danger" );
		redirect( base_url() );
	}
}
?>