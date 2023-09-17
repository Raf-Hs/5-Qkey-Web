<?php

class Backend4 extends CI_Controller{

 public function __construct()
{
    parent::__construct();
    $this->load->model("alumnos4_model");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, OPTIONS");
}

public function index(){
    echo "Acceso no permitido";
}

public function alumnos(){
    // invoca funcion del modelo
    $data = $this->alumnos4_model->get_alumnos();

    //Construccion del objeto SOAP
    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " alumnos" : "No hay alumnos";
    $obj["alumnos"] = $data;

    echo json_encode($obj);
}

public function alumnos1(){
    // invoca funcion del modelo
    $data = $this->alumnos4_model->get_alumnos1();

    //Construccion del objeto SOAP
    $obj["resultado"] = $data != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Se recuperaron " . count($data) . " alumnos" : "No hay alumnos";
    $obj["alumnos"] = $data;

    echo json_encode($obj);
}


public function actualizaalumno() {
    try {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT

        if (isset($input->accion)) {
            $accion = $input->accion;
            $id = isset($input->id) ? $input->id : null;
            $nombre = isset($input->nombre) ? mb_strtoupper($input->nombre) : "";
            $apellidos = isset($input->apellidos) ? mb_strtoupper($input->apellidos) : "";
            $correo = isset($input->correo) ? $input->correo : "";
            $contrasenia = isset($input->contrasenia) ? $input->contrasenia : "";
            $tipo = isset($input->tipo) ? $input->tipo : "";
            $direccion = isset($input->direccion) ? $input->direccion : "";
            $telefono = isset($input->telefono) ? $input->telefono : "";
            $token = isset($input->token) ? $input->token : "";
       
            $data_usuario = array(
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
                $row = $this->alumnos4_model->get_alumno($id);
                if ($row != NULL) {
                    $obj = array(
                        "resultado" => false,
                        "mensaje" => "ID duplicado"
                    );
                } else {
                    $insert_result = $this->alumnos4_model->insert_alumno($data_usuario);
                    if ($insert_result) {
                        $obj["resultado"] = true;
                        $obj["mensaje"] = "Alumn@ insertad@";
                    } else {
                        $obj["resultado"] = false;
                        $obj["mensaje"] = "Imposible insertar alumn@";
                    }
                }
            } else if ($accion == "cambio") {
                $result_update = $this->alumnos4_model->update_alumno($data_usuario);

                if ($result_update) {
                    $obj["resultado"] = true;
                    $obj["mensaje"] = "Alumn@ actualizad@";
                } else {
                    $obj["resultado"] = false;
                    $obj["mensaje"] = "Imposible actualizar alumn@";
                }
            }
        } else {
            $obj = array(
                "resultado" => false,
                "mensaje" => "No se proporcionó acción"
            );
        }

        echo json_encode($obj);
    } catch (Exception $e) {
        $obj = array(
            "resultado" => false,
            "mensaje" => "Error en el servidor: " . $e->getMessage()
        );
        echo json_encode($obj);
    }
}
public function borraalumno(){

    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }

    $obj["resultado"] = $this->alumnos4_model->delete_alumno($id);
    $obj["mensaje"] = $obj["resultado"] ? "Alumn@ eliminad@" : "Imposible eliminar alumn@: $id";

    echo json_encode($obj);
}

public function alumno(){
    if ($this->input->raw_input_stream[0] == "{") {
        $input = json_decode($this->input->raw_input_stream); // Peticion REACT
        $id = $input->id;
    } else {
        $id = $this->input->post("id"); //peticion App Movil y Web
    }
    $row = $this->alumnos4_model->get_alumno($id);

    $obj["resultado"] = $row != NULL;
    $obj["mensaje"] = $obj["resultado"] ? "Alumn@ recuperad@" : "No existe alumn@ $id";
    $obj["alumno"] = $row;
    // Visualizacion JSON del objeto
    echo json_encode($obj);
}


  
  
 
}
?>