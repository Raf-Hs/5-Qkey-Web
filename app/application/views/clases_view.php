<script>
  var appData =  {
     uri_app     : "<?= base_url() ?>",
     uri_ws      : "<?= base_url() ?>../webservice/", 
     accion      : "",
     id          : ""
  }
</script>

<table class="table table-bordered table-hover table-sm" id="tabla-clase">
    <thead>
        <tr class="bg-secondary text-white text-center">
            <th>ID</th>
            <th>ID Maestro</th>
            <th>ID Grupo</th>
            <th>Materia</th>
            <th>Laboratorio</th>
            <th>Hora Entrada</th>
            <th>Hora Salida</th>
            <th>Código</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div class="row p-3">
    <button class="btn btn-lg btn-success p-2 col-md-4"
        data-bs-toggle="modal"
        data-bs-target="#modal-editar"
        id="btn-agregar">
        <i class="fas fa-book fa-2x"></i>
        Agregar Clase
    </button>
</div>

<div id="grafica1" style="width: 50%; float: left;"></div>

    <!-- Contenedor de la segunda gráfica -->
    <div id="grafica2" style="width: 50%; float: left;"></div>
<div id="container"></div>

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
        <h1 class="modal-title fs-5 text-white" id="modal-editar-titulo"><span id="modal-editar-accion"></span> clase</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="form-clase">
        <div class="modal-body" id="modal-editar-body">
          <div class="row">
            <div class="form-group col-md-2" id="group-id">
              <label for="id"><strong>ID:</strong></label>
              <input type="text" class="form-control" id="id" disabled/>
            </div>
            <div class="form-group col-md-5" id="group-id_ma">
              <label for="id_ma"><strong>ID Maestro:</strong></label>
              <input type="text" class="form-control" id="id_ma" />
            </div>
            <div class="form-group col-md-5" id="group-id_gr">
              <label for="id_gr"><strong>ID Grupo:</strong></label>
              <input type="text" class="form-control" id="id_gr" />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6" id="group-materia">
              <label for="materia"><strong>Materia:</strong></label>
              <input type="text" class="form-control" id="materia" />
            </div>
            <div class="form-group col-md-6" id="group-laboratorio">
              <label for="laboratorio"><strong>Laboratorio:</strong></label>
              <input type="text" class="form-control" id="laboratorio" />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6" id="group-horaE">
              <label for="horaE"><strong>Hora Entrada:</strong></label>
              <input type="text" class="form-control" id="horaE" />
            </div>
            <div class="form-group col-md-6" id="group-horaS">
              <label for="horaS"><strong>Hora Salida:</strong></label>
              <input type="text" class="form-control" id="horaS" />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12" id="group-codigo">
              <label for="codigo"><strong>Código:</strong></label>
              <input type="text" class="form-control" id="codigo" />
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

