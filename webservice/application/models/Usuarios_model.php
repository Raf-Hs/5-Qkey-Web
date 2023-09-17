<?php

class Usuarios_model extends CI_Model {

        
public function cambiar_grupo_y_validar_token($token, $id_grupo) {
    $this->db->trans_start();

    // Cambiar el grupo del estudiante
    $updateGrupoData = array('id_gr' => $id_grupo);
    $this->db->where('matricula', $token);
    $this->db->update('alumnos', $updateGrupoData);

    // Validar el token y cambiar el tipo de usuario
    $this->db->select('u.id, a.matricula');
    $this->db->from('alumnos AS a');
    $this->db->join('usuarios AS u', 'a.id_usu = u.id', 'inner');
    $this->db->where('a.matricula', $token);
    $query = $this->db->get();
    $result = $query->row();

    if ($result) {
        $id_usu = $result->id;

        // Cambiar el tipo de usuario a 3
        $updateTipoData = array('tipo' => 3);
        $this->db->where('id', $id_usu);
        $this->db->update('usuarios', $updateTipoData);

        // Modificar la matrícula
        $newMatricula = $token . "-a";
        $updateMatriculaData = array('matricula' => $newMatricula);
        $this->db->where('id_usu', $id_usu);
        $this->db->update('alumnos', $updateMatriculaData);
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        return false; // Ocurrió un error en la transacción
    } else {
        return true; // Transacción exitosa
    }
}
public function acceso_usuario($correo, $contrasenia) {
    $this->db->select("*");
    $this->db->where("correo", $correo);
    $this->db->where("contrasenia", md5($contrasenia));
    $rs = $this->db->get("usuarios");
    return $rs->num_rows() == 0 ? NULL : $rs->row();
}



    public function insert_usuario($data) {
        $this->db->where("correo", $data["correo"]);
        $rs = $this->db->get("usuarios");
        $obj["resultado"] = $rs->num_rows() == 0;
        if ($obj["resultado"]) {
            $this->db->insert("usuarios", $data);
            $obj["resultado"] = $this->db->affected_rows() == 1;
            if ($obj["resultado"]) {
                $obj["id"] = $this->db->insert_id();
                $obj["mensaje"] = "Usuario registrado exitosamente";
            } else {
                $obj["mensaje"] = "No fue posible registrar usuario";
            }
        } else {
            $obj["mensaje"] = "El correo ya estï¿½ registrado";
        }
        return $obj;
    }

 
    public function update_token($idusuario, $token) {
        $rs = $this->db
            ->set("token", $token)
            ->where("id", $idusuario)
            ->update("usuarios");

        return $rs;
    }

    public function valid_token($idusuario, $token) {
        $rs = $this->db
            ->where("id", $idusuario)
            ->where("token", $token)
            ->get("usuarios");
        return $rs->num_rows() == 1;
    }

}
?>
