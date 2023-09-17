<?php
class Clase_model extends CI_Model
{

 public function get_grupos()
    {
        // Realizar la consulta a la tabla 'grupo'
        $query = $this->db->get('grupo');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }



 public function get_maestros()
    {
        $query = $this->db->select('u.*, m.Cempleado')
        ->from('usuarios u')
        ->join('maestros m', 'u.id = m.id_usu')
        ->where('u.tipo', 2)
        ->order_by('u.nombre', 'ASC')
        ->get();

        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

   public function get_maestro($id)
{
    $query = $this->db
        ->select('u.*, m.Cempleado')
        ->from('usuarios u')
        ->join('maestros m', 'u.id = m.id_usu')
        ->where('u.tipo', 2)
        ->where('u.id', $id)
        ->get();

    return $query->num_rows() > 0 ? $query->row() : NULL;
}
    public function insert_maestro($data)
    {
        $this->db
            ->insert("maestros", $data);
        return $this->db->affected_rows() > 0;
    }

   public function delete_maestro($id)
{
    // Primero, borramos las clases asociadas al maestro.
    $this->db->where('id_ma', $id);
    $this->db->delete('clase');

    // Luego, eliminamos al maestro.
    $this->db->where('id', $id);
    $this->db->delete('maestros');

    return $this->db->affected_rows() > 0;
}

    public function update_maestro($data)
    {
        $id = $data['id'];

        // Actualizamos al maestro
        $this->db->where('id', $id);
        $this->db->update('maestros', $data);

        // No es necesario actualizar los campos de la tabla 'clase' ya que el maestro solo tiene datos personales.

        return $this->db->affected_rows() > 0;
    }

public function get_alumnos()
{
    $query = $this->db->select('u.*, a.matricula, g.nombre AS grupo')
        ->from('usuarios u')
        ->join('alumnos a', 'u.id = a.id_usu')
        ->join('grupo g', 'a.id_gr = g.id')
        ->where('g.id', 1)
        ->get();

    return $query->num_rows() > 0 ? $query->result() : NULL;
}

public function get_alumno($id)
{
    $rs = $this->db
        ->where("id", $id)
        ->get("alumnos"); // Cambio de "maestros" a "alumnos"
    return $rs->num_rows() > 0 ? $rs->row() : NULL;
}

public function insert_alumno($data)
{
    $this->db
        ->insert("alumnos", $data); // Cambio de "maestros" a "alumnos"
    return $this->db->affected_rows() > 0;
}

public function delete_alumno($id)
{
    // Antes de eliminar al alumno, se deben borrar las clases asociadas a él.
    $this->db->where('matricula', $id); // Cambio de "id_ma" a "matricula"
    $this->db->delete('clase');

    // Luego, eliminamos al alumno.
    $this->db->where('id', $id);
    $this->db->delete('alumnos'); // Cambio de "maestros" a "alumnos"

    return $this->db->affected_rows() > 0;
}

public function update_alumno($data)
{
    $id = $data['id'];

    // Actualizamos al alumno
    $this->db->where('id', $id);
    $this->db->update('alumnos', $data); // Cambio de "maestros" a "alumnos"

    // No es necesario actualizar los campos de la tabla 'clase' ya que el alumno solo tiene datos personales.

    return $this->db->affected_rows() > 0;
}

public function get_clases()
{
    $query = $this->db->select('c.id, u.nombre AS maestro, g.nombre AS grupo, c.materia, c.laboratorio, c.horaE, c.horaS, c.codigo')
        ->from('clase c')
        ->join('maestros m', 'm.id = c.id_ma', 'left') // Reemplazo de "alumnos" a "clase" y ajuste de relaciones
        ->join('usuarios u', 'u.id = m.id_usu', 'left')
        ->join('grupo g', 'g.id = c.id_gr', 'left')
        ->order_by('c.id', 'DESC')  // Ordenar por el campo "id" de la tabla "clase" en orden ascendente
        ->get();

    return $query->num_rows() > 0 ? $query->result() : NULL;
}
    public function get_clase($id)
    {
        $rs = $this->db
            ->where("id", $id)
            ->get("clase");
        return $rs->num_rows() > 0 ? $rs->row() : NULL;
    }

    public function insert_clase($data)
    {
        $this->db->insert("clase", $data);
        return $this->db->affected_rows() > 0;
    }

  public function delete_clase($id)
{
    // Antes de eliminar la clase, eliminamos los registros de alumnos que dependen de esta clase
    $this->db->where('id_gr', $id);
    $this->db->delete('alumnos');

    // Luego, eliminamos la clase
    $this->db->where('id', $id);
    $this->db->delete('clase');

    return $this->db->affected_rows() > 0;
}

  public function update_clase($data)
{
    $id = $data['id'];

    // Actualizamos la clase
    $this->db->where('id', $id);
    $this->db->update('clase', $data);

    // Actualizamos el campo 'grupo' de los registros en la tabla 'alumnos' asociados a esta clase
    $alumnosToUpdate = array(
        'id_gr' => $id
    );

    $this->db->where('id_gr', $id);
    $this->db->update('alumnos', $alumnosToUpdate);

    return $this->db->affected_rows() > 0;
}
    public function update_califs($matricula, $acalifs){
        // borrar calificaciones anteriores
        $this->db
            ->where("matricula",$matricula)
            ->delete("calificaciones");

        // insertar nuevas calificaciones
        $insertados = 0;
        foreach( $acalifs as $idcalif => $calificacion ){
            $this->db->insert("calificaciones", array(
                "matricula"    => $matricula,
                "idcalif"      => $idcalif,
                "calificacion" => $calificacion
            ));
            if($this->db->affected_rows() == 1){
                $insertados++;
            }
        }
        return $insertados;
    }
    public function get_sexo_rango($sexo, $rango){
        $rs = $this->db
                ->where("sexo", $sexo)
                ->where("edad >=", " ($rango -1 )* 10 ", false)
                ->where("edad <=", " $rango * 10 -1 ", false)
                ->get("alumnos");
        return $rs->num_rows();         

    }

	public function get_clases_alumno($id_usu)
{
   $query_alumno = $this->db->select('id_gr')
        ->from('alumnos')
        ->where('id_usu', $id_usu)
        ->get();

    if ($query_alumno->num_rows() > 0) {
        $id_grupo = $query_alumno->row()->id_gr;

        $query_clases = $this->db->select('c.id, u.nombre AS maestro, g.nombre AS grupo, c.materia, c.laboratorio, c.horaE, c.horaS, c.codigo')
            ->from('clase c')
            ->join('usuarios u', 'u.id = c.id_ma')
            ->join('grupo g', 'g.id = c.id_gr')
            ->where('c.id_gr', $id_grupo)
            ->order_by("c.id", "desc")
            ->get();

        return $query_clases->num_rows() > 0 ? $query_clases->result() : NULL;
    } else {
        return NULL;
    }
}

public function get_clase_alumno($id_usu)
{
    $query_alumno = $this->db->select('id_gr')
        ->from('alumnos')
        ->where('id_usu', $id_usu)
        ->get();

    if ($query_alumno->num_rows() > 0) {
        $id_grupo = $query_alumno->row()->id_gr;

        $query_clases = $this->db->select('c.id, u.nombre AS maestro, g.nombre AS grupo, c.materia, c.laboratorio, c.horaE, c.horaS, c.codigo')
            ->from('clase c')
            ->join('usuarios u', 'u.id = c.id_ma')
            ->join('grupo g', 'g.id = c.id_gr')
            ->where('c.id_gr', $id_grupo)
            ->order_by("c.id", "desc")
            ->get();

        return $query_clases->num_rows() > 0 ? $query_clases->result() : NULL;
    } else {
        return NULL;
    }
}

public function get_clases_maestro($id_usu)
{
    $query_maestro = $this->db->select('id')
        ->from('maestros')
        ->where('id_usu', $id_usu)
        ->get();

    if ($query_maestro->num_rows() > 0) {
        $id_maestro = $query_maestro->row()->id;

        $query_clases = $this->db->select('c.id, u.nombre AS maestro, g.nombre AS grupo, c.materia, c.laboratorio, c.horaE, c.horaS, c.codigo')
            ->from('clase c')
            ->join('usuarios u', 'u.id = c.id_ma')
            ->join('grupo g', 'g.id = c.id_gr')
            ->where('c.id_ma', $id_maestro)
            ->order_by("c.id", "desc")
            ->get();

        return $query_clases->num_rows() > 0 ? $query_clases->result() : NULL;
    } else {
        return NULL;
    }
}
    public function get_grado_periodo($grado, $idcalif){

        switch($grado){
            case "AU":
                $limsup = 10;
                $liminf = 9.5;
                break;  
            case "DE":
                $limsup = 9.4;
                $liminf = 8.5;
                break;
            case "SA":
                $limsup = 8.4;
                $liminf = 8;
                break;
            case "NA":
                $limsup = 7.9;
                $liminf = 0;
                break;
        }
        $rs = $this->db
                ->where("idcalif", $idcalif)
                ->where("calificacion <=", $limsup)
                ->where("calificacion >=", $liminf)
                ->get("calificaciones");

        return $rs->num_rows();
    }
}
?>