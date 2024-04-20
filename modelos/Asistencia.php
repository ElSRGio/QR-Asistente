<?php
// Incluir la conexión a la base de datos 
require "../config/conexion.php";

class Asistencia
{
    // Implemetamos nuestro construtor
    public function __construct()
    {   
    }

    // Listas Registro
    public function listar()
    {

    $sql = "SELECT a.', CONCAT(e.nombre,' ',e.apellidos) AS empleado, e.codigo FROM asistencia a INNER JOIN empleado e ON a.
    empleado_id=e.id ORDER BY a.id DESC";
    return ejecutarConsulta($sql);
    }

    public function listar_repoter($fecha_inicio, $fecha_fin, $empelado_id)
    {
        $sql = "SELECT a.', CONCAT(e.nombre,' ',e.apellidos) AS empleado, e.codigo FROM asistencia a INNER JOIN empleado e ON  a.
        empleado_id=e.id WHERE DATE(a.fecha)>= '$fecha_inicio' AND DATE(a.fecha)<='$fecha_fin' AND a.empleado_id='$empelado_id'"; 
        return ejecutarConsulta($sql);
    }
}





