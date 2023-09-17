<script>
    var appData = {
        uri_app: "<?= base_url() ?>",
        uri_ws: "<?= base_url() ?>../webservice/",
        accion: "",
        id: ""
    }
</script>

<div class="container d-flex justify-content-center">
    <div class="card mx-3 my-5" style="width: 30rem; color: #7dace4; ">
        <div class="card-header text-center" style="color: black; background: #7dace4 ">
            <h3><strong>QKey</strong></h3>
        </div>
        <div class="card-body ">
            <div class="form-group" id="group-correo" style="color: black">
                <input type="text" class="form-control" id="correo" placeholder="Correo " />
            </div>
            <div class="form-group" id="group-contra" style="color: black">
                <input type="password" class="form-control" id="contra" placeholder="Password" />
            </div>
            <button class="btn btn-outline-dark btn-block" id="btn-entrar">
                Login
            </button>
        </div>
    </div>

    <div class="card mx-3 my-5" style="width: 30rem; color: #7dace4; ">
        <div class="card-header text-center" style="color: black; background: #7dace4 ">
            <h3><strong>Registro</strong></h3>
        </div>
        <div class="card-body">
            <div class="form-group" id="group-modal-nombre" style="color: black">
                <input type="text" id="modal-nombre" class="form-control" placeholder="Nombre" />
            </div>
            <div class="form-group" id="group-modal-apellidos" style="color: black">
                <input type="text" id="modal-apellidos" class="form-control" placeholder="Apellidos" />
            </div>
            <div class="form-group" id="group-modal-correo" style="color: black">
                <input type="text" id="modal-correo" class="form-control" placeholder="Correo" />
            </div>
            <div class="form-group" id="group-modal-contra" style="color: black">
                <input type="password" id="modal-contra" class="form-control" placeholder="Password" />
            </div>
            <div class="form-group" id="group-modal-direccion" style="color: black">
                <input type="text" id="modal-direccion" class="form-control" placeholder="Direccion" />
            </div>
            <div class="form-group" id="group-modal-telefono" style="color: black">
                <input type="text" id="modal-telefono" class="form-control" placeholder="Celular" />
            </div>
            <!-- Otros campos del formulario de registro... -->
            <button class="btn btn-primary btn-block" id="btn-register-user">
                Registrar Usuario
            </button>
        </div>
    </div>

    <div class="card mx-3 my-5" style="width: 30rem; color: #7dace4; ">
        <div class="card-header text-center" style="color: black; background: #7dace4 ">
            <h3><strong>Validar Token</strong></h3>
        </div>
        <div class="card-body">
            <div class="form-group" style="color: black">
                <label for="token">Token:</label>
                <input type="text" class="form-control" id="token" placeholder="Ingrese el token" />
            </div>
            <div class="form-group" style="color: black">
                <label for="grupo">Ingrese el grupo:</label>
                <input type="text" class="form-control" id="grupo" placeholder="Ingrese el grupo" />
            </div>
            <button class="btn btn-primary btn-block" id="btn-validar-token">
                Validar Token
            </button>
        </div>
    </div>

</div>
</div>

	<div id="mensaje">
		<?php
		if ($this->session->flashdata("mensaje") != NULL) :
			$tipo_mensaje = $this->session->flashdata("tipo_mensaje");
			switch ($tipo_mensaje) {
				case "warning":
					$titulo = "Cuidado";
					break;
				case "danger":
					$titulo = "Error";
					break;
				case "success":
					$titulo = "Exito";
					break;
				case "info":
					$titulo = "Info";
					break;
				default:
					$titulo = "Error";
			}
		?>
			<div class="alert alert-<?= $tipo_mensaje ?> alert-dismissible fade show" role="alert" style="position:absolute;bottom:20px;right:20px;">
				<strong>¡<?= $titulo ?>!</strong> <?= $this->session->flashdata("mensaje") ?>.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php
		endif;
		?>
	</div>

</div>
