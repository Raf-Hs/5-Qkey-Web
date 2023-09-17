<?php

class Backend2 extends CI_Controller{

 public function __construct()
{
    parent::__construct();
    $this->load->model("alumnos2_model");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, OPTIONS");
}

public function index(){
    echo "Acceso no permitido";
}

public function alumnos(){
    // invoca funcion del modelo
    $data = $this->alumnos2_model->get_alumnos();

    //Construccion del objeto SOAP
    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " maestr@s" : "No hay maestros";
    $obj["alumnos"] = $data;

    echo json_encode($obj);
}

public function actualizaalumno(){

    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
       $accion = $input->accion;
        $id = $input->id;
        $nombre = mb_strtoupper($input->nombre);
        $apellidos = mb_strtoupper($input->apellidos);
        $correo = $input->correo;
        $contrasenia = $input->contrasenia;
        $tipo = $input->tipo;
        $direccion = $input->direccion;
        $telefono = $input->telefono;
        $token = $input->token;
    } else {
        $accion = $this->input->post("accion");
        $id = $this->input->post("id");
        $nombre = mb_strtoupper($this->input->post("nombre"));
        $apellidos = mb_strtoupper($this->input->post("apellidos"));
        $correo = $this->input->post("correo");
        $contrasenia = $this->input->post("contrasenia");
        $tipo = $this->input->post("tipo");
        $direccion = $this->input->post("direccion");
        $telefono = $this->input->post("telefono");
        $token = $this->input->post("token");    }

    $data = array(
        "id" => $id,
        "nombre" => $nombre,
        "apellidos" => $apellidos,
        "correo" => $correo,
        "contrasenia" => $contrasenia,
        "tipo" => $tipo,
        "direccion" => $direccion,
        "telefono" => $telefono,
        "token" => $token
    );

    if ($accion == "alta") {

        $row = $this->alumnos2_model->get_alumno($id);
        if ($row != NULL) {
            $obj = array(
                "resultado" => false,
                "mensaje" => "ID duplicado"
            );
        } else {
            $obj["resultado"] = $this->alumnos_model->insert_alumno($data);;
            $obj["mensaje"] = $obj["resultado"] ? "Maestr@ insertad@" : "Imposible insertar maestr@";
        }
    } else if ($accion == "cambio") {
        $obj["resultado"] = $this->alumnos2_model->update_alumno($data);
        $obj["mensaje"] = $obj["resultado"] ? "Maestr@ actualizad@" : "Imposible actualizar maestr@";
    }
    echo json_encode($obj);
}

public function borraalumno(){

    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }

    $obj["resultado"] = $this->alumnos2_model->delete_alumno($id);
    $obj["mensaje"] = $obj["resultado"] ? "Alumn@ eliminad@" : "Imposible eliminar maestr@: $id";

    echo json_encode($obj);
}

public function alumno(){
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }
    $row = $this->alumnos2_model->get_alumno($id);

    $obj["resultado"] = $row != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Maestr@ recuperad@" : "No existe maestr@ $id";
    $obj["alumno"] = $row;
    // Visualizacion JSON del objeto
    echo json_encode($obj);
}


  
  
 
}
?>