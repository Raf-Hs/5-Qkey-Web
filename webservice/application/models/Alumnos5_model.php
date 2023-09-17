<?php
class Alumnos5_model extends CI_Model{

public function get_alumnos(){
    $query = $this->db
        ->select("usuarios.id, correo,contrasenia, tipo, usuarios.nombre, apellidos, direccion, telefono, token, alumnos.matricula, alumnos.id_gr, grupo.nombre AS nombre_grupo")
        ->join("alumnos", "usuarios.id = alumnos.id_usu", "left")
        ->join("grupo", "alumnos.id_gr = grupo.id", "left")
        ->where("tipo", 3)
        ->get("usuarios");
    
    return $query->num_rows() > 0 ? $query->result() : NULL;
}
public function get_alumno($id){
    $rs = $this->db
            ->where("id", $id)
            ->get("usuarios");
    return $rs->num_rows() > 0 ? $rs->row() : NULL;
}

public function insert_alumno($data){
    $this->db
        ->insert("usuarios", $data);
    return $this->db->affected_rows() > 0;
}

public function delete_alumno($id){
    $this->db
        ->where("id", $id)
        ->update("usuarios", array("tipo" => 4));
    return $this->db->affected_rows() > 0;
}


public function update_alumno($data){
    $this->db
            ->where("id", $data["id"])
            ->update("usuarios", $data);
    return $this->db->affected_rows() > 0;
}
 
 
    }
?>