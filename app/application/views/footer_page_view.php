<div id="mensaje" class="d-flex flex-column-reverse position-fixed" style="bottom:20px;right:20px">
<?php
if ( $this->session->flashdata( "mensaje" ) !== NULL ) {
	//echo $this->session->flashdata( "mensaje" );
	alert( 
		$this->session->flashdata( "tipo" ), 
		$this->session->flashdata( "mensaje" ) 
	);
}
?>
</div>

</div>
</body>
</html>