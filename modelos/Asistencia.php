<?php
// Incluir la conexión a la base de datos 
require "../config/conexion.php";

class Asistencia
{

//Implemetamos nuestro construtor

public function_construct()

{   
}

//Listas Registro
public function listar()
{
$sql = "SELECT a.', CONCAT(e.nombre,' ',e.apellidos) AS empleado, e.codido FROM asistencia a INNER JOIN empleado e ON a.
empleado_id=e.id ORDER BY a.id DESC;
return ejecutarConsulta($sql);
}

public function listar()