<?php
class Alumnos_model extends CI_Model{
public function get_alumnos() {
    $rs = $this->db
        ->select("clase.*, grupo.nombre AS nombreGrupo, m.nombre AS nombreMaestro")
        ->from("clase")
        ->join("grupo", "clase.id_gr = grupo.id")
        ->join("maestros ma", "clase.id_ma = ma.id", "left") // Use a LEFT JOIN to ensure rows are retained even if no matching maestro is found
        ->join("usuarios m", "ma.id_usu = m.id", "left") // Joining with the usuarios table using the maestros' id_usu
        ->order_by("clase.id", "desc")
        ->get();
    
    return $rs->num_rows() > 0 ? $rs->result() : NULL;
}
    public function get_alumno($id){
        $rs = $this->db
            ->where("id", $id)
            ->get("clase");
        return $rs->num_rows() > 0 ? $rs->row() : NULL;
    }

    public function insert_alumno($data) {
    $nombreGrupo = $data['id_gr']; // Cambia 'id_gr' por el campo correcto que contiene el nombre del grupo
    $nombreMaestro = $data['id_ma']; // Cambia 'id_ma' por el campo correcto que contiene el nombre del maestro

    // Buscar el ID del grupo en base al nombre
    $queryGrupo = $this->db->get_where('grupo', array('nombre' => $nombreGrupo));
    if ($queryGrupo->num_rows() > 0) {
        $grupo = $queryGrupo->row();
        $data['id_gr'] = $grupo->id;
    } else {
        // Manejar el caso si el grupo no se encuentra.
        return false;
    }

    // Buscar el ID del maestro en base al nombre
    $queryMaestro = $this->db->get_where('maestros', array('Cempleado' => $nombreMaestro));
    if ($queryMaestro->num_rows() > 0) {
        $maestro = $queryMaestro->row();
        $data['id_ma'] = $maestro->id;
    } else {
        // Manejar el caso si el maestro no se encuentra.
        return false;
    }

    // Insertar el registro con los IDs actualizados
    $this->db->insert("clase", $data);
    return $this->db->affected_rows() > 0;
}
   public function delete_alumno($id) {
    $this->db
        ->where("id", $id)
        ->delete("clase");
    return $this->db->affected_rows() > 0;
	}


    public function update_alumno($data){
        $this->db
            ->where("id", $data["id"])
            ->update("clase", $data);
        return $this->db->affected_rows() > 0;
    } 
 
    }
?>