<?php
class Alumnos3_model extends CI_Model{
public function get_alumnos() {
    $this->db
        ->select('usuarios.id AS id_usu, usuarios.correo, usuarios.contrasenia, usuarios.tipo, usuarios.nombre, usuarios.apellidos, usuarios.direccion, usuarios.telefono, usuarios.token, alumnos.matricula, alumnos.id AS id, alumnos.id_gr')
        ->where('usuarios.tipo', 3)  // Filtrar por tipo = 3
        ->join('alumnos', 'usuarios.id = alumnos.id_usu')
        ->join('grupo', 'alumnos.id_gr = grupo.id')
        ->where('grupo.id', 1);  // Filtrar por grupo = 'indefinido' (grupo 1)

    $rs = $this->db->get('usuarios');

    return $rs->num_rows() > 0 ? $rs->result() : NULL;
}
public function get_alumno($id){
    $rs = $this->db
            ->where("id_usu", $id)
            ->get("usuarios");
    return $rs->num_rows() > 0 ? $rs->row() : NULL;
}


public function delete_alumno($id) {
    // Obtener el ID de usuario basado en el alumno
    $this->db
        ->select('id_usu')
        ->where('id', $id)
        ->from('alumnos');

    $query = $this->db->get();
    $row = $query->row();

    if (!$row) {
        return false; // El alumno no se encontró
    }

    $id_usuario = $row->id_usu;

    // Actualizar el tipo de usuario a 4
    $this->db
        ->where('id', $id_usuario)
        ->update('usuarios', array('tipo' => 4));

    return $this->db->affected_rows() > 0;
}


public function update_alumno($id) {
    // Obtener el ID de usuario basado en el alumno
    $this->db
        ->select('id_usu')
        ->where('id', $id)
        ->from('alumnos');

    $query = $this->db->get();
    $row = $query->row();

    if (!$row) {
        return false; // El alumno no se encontró
    }

    $id_usuario = $row->id_usu;

    // Actualizar el tipo de usuario a 4
    $this->db
        ->where('id', $id_usuario)
        ->update('usuarios', array('tipo' => 2));

    return $this->db->affected_rows() > 0;
}
 
 
    }
?>