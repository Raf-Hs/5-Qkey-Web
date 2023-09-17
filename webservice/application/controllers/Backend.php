<?php
class Backend extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model( "Usuarios_model" );
 		$this->load->model("clase_model");
       		 header("Access-Control-Allow-Origin: *");
        	header("Access-Control-Allow-Methods: GET, OPTIONS");

		$this->output->set_content_type( "application/json" );
	}
	public function index(){
		echo "<h4>Acceso no permitido</h4>";
	}

public function alumnos()
{
    $data = $this->clase_model->get_alumnos();

    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " alumnos" : "No hay alumnos";
    $obj["alumnos"] = $data;

    echo json_encode($obj);
}

public function cambiar_grupo_y_validar_token() {
    // Obtén los datos del formulario o solicitud
    $token = $this->input->post("token"); // Cambié "$matricula" por "$token"
    $id_grupo = $this->input->post("grupo");

    // Llama a la función en el modelo para cambiar el grupo y validar el token
    $result = $this->Usuarios_model->cambiar_grupo_y_validar_token($token, $id_grupo);

    if ($result) {
        $response = array(
            'resultado' => true,
            'mensaje' => 'Cambio de grupo y validación de token exitosos.'
        );
    } else {
        $response = array(
            'resultado' => false,
            'mensaje' => 'Hubo un error en el proceso de cambio de grupo y validación de token.'
        );
    }

    echo json_encode($response);
}
 public function alumnos_por_grupo() {
        // Asegúrate de validar que la solicitud AJAX se ha realizado correctamente
        if ($this->input->is_ajax_request()) {
            // Obtenemos el valor del grupo seleccionado desde la solicitud AJAX
            $grupo = $this->input->post('grupo');

            // Llama a un modelo o realiza la consulta necesaria para obtener los alumnos del grupo
            $alumnos = $this->Clase_model->obtener_alumnos_por_grupo($grupo);

            // Prepara la respuesta para enviar al frontend
            $response = array(
                'resultado' => true,
                'mensaje' => 'Alumnos filtrados por grupo',
                'alumnos' => $alumnos
            );

            // Devuelve la respuesta como JSON
            echo json_encode($response);
        } else {
            // Si no es una solicitud AJAX válida, devuelve una respuesta de error
            $response = array(
                'resultado' => false,
                'mensaje' => 'Solicitud no válida'
            );

            // Devuelve la respuesta de error como JSON
            echo json_encode($response);
        }
    }


	public function gettipos() {
		$data = $this->Productos_model->get_tipos_producto();
		$obj[ "resultado" ] = $data != NULL;
		if ( $obj[ "resultado" ] ) {
			$obj[ "mensaje" ] = "Se recuperaron ".count( $data )." tipo(s)";
			$obj[ "tipos" ]   = $data;
		}
		else {
			$obj[ "mensaje" ] = "No hay tipos"; 
		}
		echo json_encode( $obj );
	}

	
		
	
	public function getclientexcorreo() {
		$correo = $this->input->post( "correo" );
		$row = $this->Usuarios_model->get_cliente_x_correo( $correo );
		$obj[ "resultado" ] = $row != NULL;
		if ( $obj[ "resultado" ] ) {
			$obj[ "cliente" ] = $row;
			$obj[ "mensaje" ] = "Datos recuperados";
		}
		else {
			$obj[ "mensaje" ] = "No existe ese correo";
		}
		echo json_encode( $obj );
	}

	public function pagaventa() {
		$confactura = $this->input->post( "confactura" );
		$idusuario  = $this->input->post( "id" );
		$nombre     = $this->input->post( "nombre" );
		$apellidos  = $this->input->post( "apellidos" );
		$rfc        = $this->input->post( "rfc" );
		$domicilio  = $this->input->post( "domicilio" );
		$colonia    = $this->input->post( "colonia" );
		$cp         = $this->input->post( "cp" );
		$telefono   = $this->input->post( "telefono" );
		$carrito    = $this->input->post( "carrito" );

		$datausuario = array(
			"id" => $idusuario,
			"nombre"    => mb_strtoupper( $nombre ),
			"apellidos" => mb_strtoupper( $apellidos )
		);

		$datacliente = array(
			"id" => $idusuario,
			"rfc"       => $rfc,
			"domicilio" => mb_strtoupper( $domicilio ),
			"colonia"   => mb_strtoupper( $colonia ),
			"cp"        => $cp,
			"telefono"  => $telefono
		);

		echo json_encode( $this->Ventas_model->paga_venta( $confactura, $datausuario, $datacliente, $carrito ) );
	}


	
	public function acceso() {
		$correo      = $this->input->post( "correo" );
		$contrasenia = $this->input->post( "contra" );
		$row = $this->Usuarios_model->acceso_usuario( $correo, $contrasenia);
		$obj[ "resultado" ] = $row != NULL;
		$obj[ "mensaje" ]   = $obj[ "resultado" ] ?
				"Acceso autorizado" : "Aceso no autorizado. Error en correo o contraseÃ±a";
		if ( $obj[ "resultado" ] ) {
			$obj[ "usuario" ] = $row;
		}
		echo json_encode( $obj );
	}







	public function registrausuario() {
        $nombre      = $this->input->post("nombre");
        $apellidos   = $this->input->post("apellidos");
        $correo      = $this->input->post("correo");
        $contrasenia = $this->input->post("contra");

        $data = array(
            "nombre"      => mb_strtoupper($nombre),
            "apellidos"   => mb_strtoupper($apellidos),
            "correo"      => $correo,
            "contrasenia" => $contrasenia
        );

        $result = $this->Usuarios_model->insert_usuario($data);

        if ($result) {
            $obj = array(
                "resultado" => true,
                "mensaje"   => "Usuario registrado exitosamente"
            );
        } else {
            $obj = array(
                "resultado" => false,
                "mensaje"   => "Error al registrar el usuario"
            );
        }

        echo json_encode($obj);
    }
	
	
	

 public function grupos()
    {
        $data = $this->clase_model->get_grupos();

        $obj["resultado"] = $data != NULL;
        $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " grupos" : "No hay grupos";
        $obj["grupos"] = $data;

        echo json_encode($obj);
    }

public function actualizaalumno()
{
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream);
        $accion = $input->accion;
        // Cambio de matricula a id
        $id = $input->id; 
        $nombre = mb_strtoupper($input->nombre);
        $correo = mb_strtoupper($input->correo);
        $direccion = mb_strtoupper($input->direccion);
        $telefono = mb_strtoupper($input->telefono);
        //...
    } else {
        $accion = $this->input->post("accion");
        // Cambio de matricula a id
        $id = $this->input->post("id"); 
        $nombre = mb_strtoupper($this->input->post("nombre"));
        $correo = mb_strtoupper($this->input->post("correo"));
        $direccion = mb_strtoupper($this->input->post("direccion"));
        $telefono = mb_strtoupper($this->input->post("telefono"));
        //...
    }

    // Cambio de "matricula" a "id"
    $data = array(
        "id" => $id,
        "nombre" => $nombre,
        "correo" => $correo,
        "direccion" => $direccion,
        "telefono" => $telefono,
        //...
    );

    if ($accion == "alta") {

        $row = $this->clase_model->get_alumno($id); // Cambio de "get_clase" a "get_alumno"
        if ($row != NULL) {
            $obj = array(
                "resultado" => false,
                "mensaje" => "ID duplicada" // Cambio de "Matricula duplicada" a "ID duplicada"
            );
        } else {
            $obj["resultado"] = $this->clase_model->insert_alumno($data);
            $obj["mensaje"] = $obj["resultado"] ? "Alumno insertado" : "Imposible insertar alumno";
        }
    } else if ($accion == "cambio") {
        $obj["resultado"] = $this->clase_model->update_alumno($data); // Cambio de "update_clase" a "update_alumno"
        $obj["mensaje"] = $obj["resultado"] ? "Alumno actualizado" : "Imposible actualizar alumno";
    }
    echo json_encode($obj);
}

public function borraalumno()
{
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream);
        // Cambio de matricula a id
        $id = $input->id; 
    } else {
        // Cambio de matricula a id
        $id = $this->input->post("id"); 
    }

    $obj["resultado"] = $this->clase_model->delete_alumno($id); // Cambio de "delete_clase" a "delete_alumno"
    $obj["mensaje"] = $obj["resultado"] ? "Alumno eliminado" : "Imposible eliminar alumno: $id";

    echo json_encode($obj);
}

public function alumno()
{
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream);
        // Cambio de matricula a id
        $id = $input->id; 
    } else {
        // Cambio de matricula a id
        $id = $this->input->post("id");
    }
    // Cambio de "get_clase" a "get_alumno"
    $row = $this->clase_model->get_alumno($id);

    $obj["resultado"] = $row != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Alumno recuperado" : "No existe alumno con ID $id";
    $obj["alumno"] = $row;
    // Visualización JSON del objeto
    echo json_encode($obj);
}




    public function clases()
    {
        $data = $this->clase_model->get_clases(); // Cambio de "get_alumnos()" a "get_clases()"

        $obj["resultado"] = $data != NULL;
        $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " clases" : "No hay clases";
        $obj["clases"] = $data;

        echo json_encode($obj);
    }

public function clases_alumno($id_alumno)
{
    $data = $this->clase_model->get_clase_alumno($id_alumno); 

    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " clases" : "No hay clases";
    $obj["clases"] = $data;

    echo json_encode($obj);
}
public function clases_maestro($id_maestro)
{
    $data = $this->clase_model->get_clases_maestro($id_maestro); 

    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " clases" : "No hay clases";
    $obj["clases"] = $data;

    echo json_encode($obj);
}

public function actualizaclase()
{
    $input = json_decode($this->input->raw_input_stream, true);

    if ($input['accion'] === 'alta' || $input['accion'] === 'cambio') {
        $id = $input['id'];
        $maestro = mb_strtoupper($input['maestro']);
        $grupo = mb_strtoupper($input['grupo']);
        $materia = mb_strtoupper($input['materia']);
        $laboratorio = mb_strtoupper($input['laboratorio']);
        $horaE = $input['horaE']; // Assuming it is in the format HH:mm
        $horaS = $input['horaS']; // Assuming it is in the format HH:mm
        $codigo = $input['codigo'];
        //...

        $data = array(
            "id" => $id,
            "maestro" => $maestro,
            "grupo" => $grupo,
            "materia" => $materia,
            "laboratorio" => $laboratorio,
            "horaE" => $horaE,
            "horaS" => $horaS,
            "codigo" => $codigo,
            //...
        );

        if ($input['accion'] === 'alta') {
            $row = $this->clase_model->get_clase($id);
            if ($row != NULL) {
                $obj = array(
                    "resultado" => false,
                    "mensaje" => "ID duplicada"
                );
            } else {
                $obj["resultado"] = $this->clase_model->insert_clase($data);
                $obj["mensaje"] = $obj["resultado"] ? "Clase insertada" : "Imposible insertar clase";
            }
        } else { // $input['accion'] === 'cambio'
            $obj["resultado"] = $this->clase_model->update_clase($data);
            $obj["mensaje"] = $obj["resultado"] ? "Clase actualizada" : "Imposible actualizar clase";
        }
    } else {
        $obj = array(
            "resultado" => false,
            "mensaje" => "Acción no válida"
        );
    }

    echo json_encode($obj);
}
    public function borraclase()
    {
        if ($this->input->raw_input_stream[0] == "{") {
            $input = json_decode($this->input->raw_input_stream);
            // Cambio de matricula a id
            $id = $input->id; 
        } else {
            // Cambio de matricula a id
            $id = $this->input->post("id"); 
        }

        $obj["resultado"] = $this->clase_model->delete_clase($id); // Cambio de "delete_alumno" a "delete_clase"
        $obj["mensaje"] = $obj["resultado"] ? "Clase eliminada" : "Imposible eliminar clase: $id";

        echo json_encode($obj);
    }

    public function clase()
    {
        if ($this->input->raw_input_stream[0] == "{") {
            $input = json_decode($this->input->raw_input_stream);
            // Cambio de matricula a id
            $id = $input->id; 
        } else {
            // Cambio de matricula a id
            $id = $this->input->post("id");
        }
        // Cambio de "get_alumno" a "get_clase"
        $row = $this->clase_model->get_clase($id);

        $obj["resultado"] = $row != NULL;
        $obj["mensaje"] = $obj["resultado"] ? "Clase recuperada " : "No existe clase con ID $id";
        $obj["clase"] = $row;
        // Visualizacion JSON del objeto
        echo json_encode($obj);
    }

	
public function maestros()
{
    $data = $this->clase_model->get_maestros(); // Cambio de "get_clases()" a "get_maestros()"

    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " maestros" : "No hay maestros";
    $obj["maestros"] = $data;

    echo json_encode($obj);
}

public function actualizamaestro()
{
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream);
        $accion = $input->accion;
        // Cambio de matricula a id
        $id = $input->id; 
        $cempleado = mb_strtoupper($input->cempleado);
        $nombre = mb_strtoupper($input->nombre);
        $correo = mb_strtoupper($input->correo);
        $direccion = mb_strtoupper($input->direccion);
        //...
    } else {
        $accion = $this->input->post("accion");
        // Cambio de matricula a id
        $id = $this->input->post("id"); 
        $cempleado = mb_strtoupper($this->input->post("cempleado"));
        $nombre = mb_strtoupper($this->input->post("nombre"));
        $correo = mb_strtoupper($this->input->post("correo"));
        $direccion = mb_strtoupper($this->input->post("direccion"));
        //...
    }

    // Cambio de "matricula" a "id"
    $data = array(
        "id" => $id,
        "cempleado" => $cempleado,
        "nombre" => $nombre,
        "correo" => $correo,
        "direccion" => $direccion,
        //...
    );

    if ($accion == "alta") {

        $row = $this->clase_model->get_maestro($id); // Cambio de "get_clase" a "get_maestro"
        if ($row != NULL) {
            $obj = array(
                "resultado" => false,
                "mensaje" => "ID duplicada" // Cambio de "Matricula duplicada" a "ID duplicada"
            );
        } else {
            $obj["resultado"] = $this->clase_model->insert_maestro($data);
            $obj["mensaje"] = $obj["resultado"] ? "Maestro insertado" : "Imposible insertar maestro";
        }
    } else if ($accion == "cambio") {
        $obj["resultado"] = $this->clase_model->update_maestro($data); // Cambio de "update_clase" a "update_maestro"
        $obj["mensaje"] = $obj["resultado"] ? "Maestro actualizado" : "Imposible actualizar maestro";
    }
    echo json_encode($obj);
}

public function borra_maestro()
{
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream);
        // Cambio de matricula a id
        $id = $input->id; 
    } else {
        // Cambio de matricula a id
        $id = $this->input->post("id"); 
    }

    $obj["resultado"] = $this->clase_model->delete_maestro($id); // Cambio de "delete_clase" a "delete_maestro"
    $obj["mensaje"] = $obj["resultado"] ? "Maestro eliminado" : "Imposible eliminar maestro: $id";

    echo json_encode($obj);
}

public function maestro()
{
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream);
        // Cambio de matricula a id
        $id = $input->id; 
    } else {
        // Cambio de matricula a id
        $id = $this->input->post("id");
    }
    // Cambio de "get_clase" a "get_maestro"
    $row = $this->clase_model->get_maestro($id);

    $obj["resultado"] = $row != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Maestro recuperado " : "No existe maestro con ID $id";
    $obj["maestro"] = $row;
    // Visualizacion JSON del objeto
    echo json_encode($obj);
}

    public function calificaciones(){
         $matricula = $this->input->post("matricula");
         $data = $this->alumnos_model->get_califs($matricula);
 
         $obj["resultado"] = $data != NULL;
         $obj["mensaje"] = $obj["resultado"] ? "Calificaciones recuperadas " : "No existen calificaciones de alumn@ $matricula";
         $obj["calificaciones"] = $data;
         echo json_encode( $obj );
 
     }

   
     public function grafcalif(){
        $dataalumnos = $this->alumnos_model->get_alumnos(); 
        $obj["resultado"] = $dataalumnos != NULL;
        $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " .count($dataalumnos). " alumnos" : "No hay alumnos";
        
        $series = array();
        foreach($dataalumnos as $row){

            $califs = array();

            $datacalif = $this->alumnos_model->get_califs($row->matricula);

            if($datacalif != NULL){
                foreach($datacalif as $rowcalif){
                    $califs[] = (float)$rowcalif->calificacion;
                }
            }

            $series[] = array(
                "name" => $row->appaterno. " " .$row->apmaterno . " ".$row->nombre,
                "data" => $califs
            );
        }

        $obj["series"] = $series;

        echo json_encode($obj);
     }

     public function grafcalifalumno(){
        $matricula = $this->input->post("matricula");

        $row = $this->alumnos_model->get_alumno($matricula);

        $obj["resultado"] = $row != NULL;
        $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron los datos" : "No existe el alumno $matricula";
        
        $series = array();
        $califs = array();

        $datacalif = $this->alumnos_model->get_califs($row->matricula);

        if($datacalif != NULL){
            foreach($datacalif as $rowcalif){
                $califs[] = (float)$rowcalif->calificacion;
            }
        }

        $series[] = array(
            "name" => $row->appaterno. " " .$row->apmaterno . " ".$row->nombre,
            "data" => $califs
        );

        $obj["series"] = $series;

        echo json_encode($obj);
     }     

     public function grafedad(){
        $series = array();

        $aserie = array(
            "M" => "MASCULINO",
            "F" => "FEMENINO"
        );

        foreach($aserie as $sexo => $nomserie){
            $data = array();

            for($rango = 1; $rango <= 11; $rango++){
               $data[] = (int)$this->alumnos_model->get_sexo_rango($sexo, $rango) * ( $sexo== "M" ? -1 : 1);
            }

            $series[] = array(
                "name" => $nomserie,
                "data" => $data
            );
        }

        echo json_encode(array(
            "resultado" => true,
            "mensaje"   => "Datos recuperados",
            "series"    => $series
        ));
     }

     public function grafperiodo(){
        
        $series = array();
        $agrado = array(
            "AU"  => "AUTONOMO",
            "DE"  => "DESTACADO",
            "SA"  => "SATISFACTORIO",
            "NA"  => "NO ACREDITADO"
        );
        
        foreach($agrado as $grado => $nomserie){
            $data = array();

            for($idcalif = 1; $idcalif <= 5; $idcalif++){
                $data[] = $this->alumnos_model->get_grado_periodo($grado, $idcalif);
            }

            $series[] = array(
                "name" => $nomserie,
                "data" => $data
            );
        }

        echo json_encode(array(
            "resultado" => true,
            "mensaje"   => "Datos recuperados",
            "series"    => $series
        ));
     }


}
?>