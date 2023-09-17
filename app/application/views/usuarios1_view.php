<script>
  var appData =  {
     uri_app     : "<?= base_url() ?>",
     uri_ws      : "<?= base_url() ?>../webservice/", 
     accion      : "",
     id          : ""
  }
</script>
  <?php 
$a = include ('consulta.php');
?>
<div>
    <label for="classroom-select">Seleccionar Grupo:</label>
    <select id="classroom-select">
        <option value="T207">T207</option>
        <option value="T208">T208</option>
    </select>
</div>

<table class="table table-bordered table-hover table-sm" id="tabla-alumnos">
    <thead>
        <tr class="bg-secondary text-white text-center">
            <th>ID</th>
	    <th>Matricula</th>
	   <th>Grupo</th>
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

<div>
  <figure class="highcharts-figure">
    <div id="container"></div>
    <script>
        var categorias = ['Lab 8', 'Lab 9', 'Lab 10'];
        var cantidadButacasVendidas = [38, 30, 35];

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Media de alumnos en laboratorio y Capacidad de laboratorio'
            },
            xAxis: {
                categories: categorias
            },
            yAxis: {
                title: {
                    text: 'Cantidad de alumnos y butacas'
                }
            },
            series: [
                {
                    name: 'Cantidad Butacas',
                    data: cantidadButacasVendidas
                },
                <?= $a ?>
            ],
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
        });
    </script>
</figure>
<style>
    .styled-table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    .styled-table th, .styled-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .styled-table th {
        background-color: #f2f2f2;
    }

    .styled-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .styled-table tr:hover {
        background-color: #ddd;
    }
</style>
<table class="styled-table">
    <thead>
        <tr>
            <th>Laboratorios</th>
            <th>Grupos</th>
            <th>Alumnos</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $servername = "dtai.uteq.edu.mx";
        $username = "rafher207";
        $password = "2022171029";
        $dbname = "bd_awos_rafher207";

        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "SELECT c.laboratorio, SUM(a.total_alumnos) AS total_alumnos, COUNT(DISTINCT a.id) AS cantidad_grupos,
                SUM(a.total_alumnos) / COUNT(DISTINCT a.id) AS promedio_alumnos_por_grupo
                FROM (
                SELECT laboratorio, id_ma AS id, COUNT(*) AS total_alumnos
                FROM clase
                GROUP BY laboratorio, id_ma
                ) AS a
                JOIN clase AS c ON a.id = c.id_ma
                GROUP BY c.laboratorio";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["laboratorio"] . "</td>";
                echo "<td>" . $row["cantidad_grupos"] . "</td>";
                echo "<td>" . $row["total_alumnos"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No se encontraron datos</td></tr>";
        }
        
        $conn->close();
        ?>
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
