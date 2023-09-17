<!DOCTYPE html>
<html>
<head>
	<title>DMs</title>
	<meta charset="UTF-8">
	

	<link rel="stylesheet"
			href="<?= base_url() ?>static/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet"
			href="<?= base_url() ?>static/fontawesome/css/all.min.css" />
	<link rel="stylesheet"href="<?= base_url() ?>static/css/portal.css">

  <link rel="stylesheet"href="<?= base_url() ?>static/css/estilo.css">
      <link rel="shortcut icon" href="http://dtai.uteq.edu.mx/~rafher207/DAPPS/assests/heart.png">
      

	<script src="<?= base_url() ?>static/js/jquery-3.5.1.min.js"></script>
	<script src="<?= base_url() ?>static/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>static/js/portal.js"></script>
	<script src="<?= base_url() ?>static/js/error.min.js"></script>
	<script src="<?= base_url() ?>static/js/mensajes.min.js"></script>
	<script src="<?= base_url() ?>static/js/input-spinner.min.js"></script>
	<script>
		var appData = {
			base_url    : "<?= base_url() ?>",
			ws_url      : "<?= base_url() ?>../webservice/",
			idtipo        : 0,
			nomproducto : "",
      correo      : "<?= $this->session->userdata( "correo" ) ?>",
      idusuario   : 0
		}
	</script>
</head>
<body>


<script>
  var appData =  {
     uri_app     : "<?= base_url() ?>",
     uri_ws      : "<?= base_url() ?>../webservice/", 
     accion      : "",
     matricula   : ""
  }
</script>
 <table class="table table-bordered table-hover" id="tabla-clases">
      <thead>
        <tr class="bg-secondary text-white text-center">
          <th>Matricula</th>
          <th>Maestro</th>
          <th>Grupo</th>
          <th>Materia</th>
          <th>Laboratorio</th>
          <th>Hora de Entrada</th>
          <th>Hora de Salida</th>
          </tr>
      </thead>
      <tbody>
      </tbody>
    </table>



     </div>
<!-- Modal Baja -->
<div class="modal fade" id="modal-baja" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-opacity-75">
                <h1 class="modal-title fs-5 text-white" id="modal-baja-titulo">Eliminar clase</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-baja-body">
                ¿Realmente desea eliminar la clase con matrícula <strong id="modal-baja-nomclase"></strong>?
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
                        <div class="form-group col-md-2" id="group-matricula">
                            <label for="matricula"><strong>Matrícula:</strong></label>
                            <input type="text" class="form-control" id="matricula" disabled/>
                        </div>
                        <div class="form-group col-md-4" id="group-maestro">
                            <label for="maestro"><strong>Maestro:</strong></label>
                            <input type="text" class="form-control" id="maestro"/>
                        </div>
                        <div class="form-group col-md-4" id="group-grupo">
                            <label for="grupo"><strong>Grupo:</strong></label>
                            <input type="text" class="form-control" id="grupo"/>
                        </div>
                        <div class="form-group col-md-2" id="group-codigo">
                            <label for="codigo"><strong>Código:</strong></label>
                            <input type="text" class="form-control" id="codigo"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4" id="group-materia">
                            <label for="materia"><strong>Materia:</strong></label>
                            <input type="text" class="form-control" id="materia"/>
                        </div>
                        <div class="form-group col-md-4" id="group-laboratorio">
                            <label for="laboratorio"><strong>Laboratorio:</strong></label>
                            <input type="text" class="form-control" id="laboratorio"/>
                        </div>
                        <div class="form-group col-md-2" id="group-horaE">
                            <label for="horaE"><strong>Hora de Entrada:</strong></label>
                            <input type="time" class="form-control" id="horaE"/>
                        </div>
                        <div class="form-group col-md-2" id="group-horaS">
                            <label for="horaS"><strong>Hora de Salida:</strong></label>
                            <input type="time" class="form-control" id="horaS"/>
                        </div>
                    </div>
                </div>    
            </form>

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
        </div>
    </div>
</div>

<!-- MODAL GRAFICA-->
<div class="modal fade" id="modal-grafica" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-info bg-opacity-75">
        <h1 class="modal-title fs-5 text-white" id="modal-grafica-titulo"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        
      <div class="modal-body text-center" id="modal-grafica-body">

      <div id="div-grafica" style="width:80%;height:100%;display:inline-block;"></div>
      </div>    
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i>
            Cerrar
        </button>
      </div>
      </form>
    </div>
  </div>
</div>


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

</div>-->
</body>
</html>
