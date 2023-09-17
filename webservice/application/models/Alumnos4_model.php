<?php
class Alumnos4_model extends CI_Model{

public function get_alumnos(){
    $query = $this->db->select('u.*, a.matricula, g.nombre AS nombre_grupo')
                      ->from('usuarios u')
                      ->join('alumnos a', 'u.id = a.id_usu')
                      ->join('grupo g', 'a.id_gr = g.id')
                      ->where('u.tipo', 3)
			->where('a.id_gr', 2)
                      ->get();

    return $query->num_rows() > 0 ? $query->result() : NULL;
}

public function get_alumnos1(){
    $query = $this->db->select('u.*, a.matricula, g.nombre AS nombre_grupo')
                      ->from('usuarios u')
                      ->join('alumnos a', 'u.id = a.id_usu')
                      ->join('grupo g', 'a.id_gr = g.id')
                      ->where('u.tipo', 3)
			->where('a.id_gr', 3)
                      ->get();

    return $query->num_rows() > 0 ? $query->result() : NULL;
}


public function get_alumno($id){
    $this->db->trans_start();
    
    $query = $this->db->select('u.*, a.matricula, g.nombre AS nombre_grupo')
                      ->from('usuarios u')
                      ->join('alumnos a', 'u.id = a.id_usu')
                      ->join('grupo g', 'a.id_gr = g.id')
                      ->where('u.id', $id)
                      ->get();
    
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        return NULL;
    }

    return $query->num_rows() > 0 ? $query->row() : NULL;
}

public function delete_alumno($id){
    $this->db
        ->where("id", $id)
        ->update("usuarios", array("tipo" => 4));
    return $this->db->affected_rows() > 0;
}


public function update_alumno($data_usuario) {
    $this->db->where("id", $data_usuario["id"]);
    $this->db->update("usuarios", $data_usuario);

    return $this->db->affected_rows() > 0;
}
}