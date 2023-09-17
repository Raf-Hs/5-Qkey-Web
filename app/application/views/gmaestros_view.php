<script>
  var appData =  {
     uri_app     : "<?= base_url() ?>",
     uri_ws      : "<?= base_url() ?>../webservice/", 
     accion      : "",
     id          : ""
  }
</script>
  
<table class="table table-bordered table-hover table-sm" id="tabla-alumnos">
    <thead>
        <tr class="bg-secondary text-white text-center">
            <th>ID</th>
            <th>Correo</th>
            <th>Password</th>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Token</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<!-- VENTANAS MODALES -->

<!-- Modal Baja-->
<div class="modal fade" id="modal-baja" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-danger bg-opacity-75">
        <h1 class="modal-title fs-5 text-white" id="modal-baja-titulo">Eliminar alumno</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-baja-body">
        ¿Realmente desea eliminar la/el alumn@ <strong id="modal-baja-nomalumno"></strong>?
      </div>    
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-confirmar-baja">
            <i class="fas fa-check"></i>
            Confirmar
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i>
            Cancelar
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="modal-editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary bg-opacity-75">
        <h1 class="modal-title fs-5 text-white" id="modal-editar-titulo"><span id="modal-editar-accion"></span> alumno</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="form-alumno">
        <div class="modal-body" id="modal-editar-body">
          <div class="row">
            <div class="form-group col-md-2" id="group-id">
              <label for="id"><strong>ID:</strong></label>
              <input type="text" class="form-control" id="id" disabled/>
            </div>
            <div class="form-group col-md-5" id="group-correo">
              <label for="correo"><strong>Correo:</strong></label>
              <input type="text" class="form-control" id="correo" />
            </div>
            <div class="form-group col-md-5" id="group-contrasenia">
              <label for="contrasenia"><strong>Contraseña:</strong></label>
              <input type="text" class="form-control" id="contrasenia" />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-2" id="group-tipo">
              <label for="tipo"><strong>Tipo:</strong></label>
              <input type="text" class="form-control" id="tipo" />
            </div>
            <div class="form-group col-md-5" id="group-nombre">
              <label for="nombre"><strong>Nombre:</strong></label>
              <input type="text" class="form-control" id="nombre" />
            </div>
            <div class="form-group col-md-5" id="group-apellidos">
              <label for="apellidos"><strong>Apellidos:</strong></label>
              <input type="text" class="form-control" id="apellidos" />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6" id="group-direccion">
              <label for="direccion"><strong>Dirección:</strong></label>
              <input type="text" class="form-control" id="direccion" />
            </div>
            <div class="form-group col-md-6" id="group-telefono">
              <label for="telefono"><strong>Teléfono:</strong></label>
              <input type="text" class="form-control" id="telefono" />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12" id="group-token">
              <label for="token"><strong>Token:</strong></label>
              <input type="text" class="form-control" id="token" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btn-guardar">
            <i class="fas fa-save"></i>
            Guardar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i>
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
