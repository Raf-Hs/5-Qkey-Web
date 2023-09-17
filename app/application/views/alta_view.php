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
        <h1 class="modal-title fs-5 text-white" id="modal-baja-titulo">Eliminar Maestro</h1>
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
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary bg-opacity-75">
        <h1 class="modal-title fs-5 text-white" id="modal-editar-titulo">Editar alumno</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-editar-body">
        ¿Realmente desea dar de alta a la/el Maestro@ <strong id="modal-editar-nomalumno"></strong>?
        <!-- Aquí puedes agregar contenido adicional o el formulario de edición si lo deseas -->
      </div>    
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-confirmar-editar">
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
