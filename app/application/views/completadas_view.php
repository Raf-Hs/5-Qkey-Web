	<script>
  var appData =  {
     uri_app     : "<?= base_url() ?>",
     uri_ws      : "<?= base_url() ?>../webservice/", 
     accion      : "",
     matricula   : ""
  }
</script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Firebase Test</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      border: 1px solid #ddd;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
 


  <table>
    <thead>
      <tr id="tableHeader">
        <!-- Encabezados de la tabla se llenarán dinámicamente -->
      </tr>
    </thead>
    <tbody id="userData">
      <!-- Aquí se agregarán las filas de la tabla con los datos de Firebase -->
    </tbody>
  </table>


	


   

<!-- Modal calificaciones-->
<div class="modal fade" id="modal-calif" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-warning bg-opacity-75">
        <h1 class="modal-title fs-5 text-white" id="modal-calif-titulo">Calificaciones <br/>

        <small><small><small class="fw-normal mt-1" id="modal-calif-nomalumno"></small>
        <small></small></h1> 
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="form-calif">
        
        <div class="modal-body" id="modal-calif-body">
          <div class="d-flex justify-content-between">
              <div class="form-group col-md-2" id="group-calif-1">
                  <label for="calif-1"><strong>Calif 1:</strong></label>
                  <input type="number" min="0" max="10" step="0.1" class="form-control input-calif" id="calif-1"/>
              </div>
              <div class="form-group col-md-2" id="group-calif-2">
                  <label for="calif-2"><strong>Calif 2:</strong></label>
                  <input type="number" min="0" max="10" step="0.1" class="form-control input-calif" id="calif-2"/>
              </div>
              <div class="form-group col-md-2" id="group-calif-3">
                  <label for="calif-3"><strong>Calif 3:</strong></label>
                  <input type="number" min="0" max="10" step="0.1" class="form-control input-calif" id="calif-3"/>
              </div>
              <div class="form-group col-md-2" id="group-calif-4">
                  <label for="calif-4"><strong>Calif 4:</strong></label>
                  <input type="number" min="0" max="10" step="0.1" class="form-control input-calif" id="calif-4"/>
              </div>
              <div class="form-group col-md-2" id="group-calif-5">
                  <label for="calif-5"><strong>Calif 5:</strong></label>
                  <input type="number" min="0" max="10" step="0.1" class="form-control input-calif" id="calif-5"/>
              </div>
          </div>    
        </div>    
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btn-guardar-calif">
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
<div id="barChartContainer" style="width: 100%; height: 400px;"></div>