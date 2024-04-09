<?php
// Incluir la conexión a la base de datos 
require "../config/conexion.php";
class Empleado
{
    // Constructor de la clase Empleado
    public function __construct()
    {
    }



    // Método para insertar un nuevo registro de empleado
    public function insertar($nombre, $apellidos, $documento_numero, $telefono, $codigo)
    {
        $sql = "INSERT INTO empleados (nombre, apellidos, documento_numero, telefono, codigo) VALUES ('$nombre', '$apellidos
,'$documento_numero', '$telefono' , '$codigo')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de empleado existente (Checar el where id para)
    public function editar($empleado_id, $nombre, $apellidos, $documento_numero, $telefono, $codigo)
    {
        $sql = "UPDATE empleados SET nombre='$nombre', apellidos='$apellidos', documento_numero='$documento_numero', 
telefono='$telefono', codigo='$codigo' WHERE id='$empleado_id'";

        return ejecutarConsulta($sql);
    }

    // Método para mostrar los detalles de un empleado específico 
    public function mostrar($empleado_id)
    {
        $sql = "SELECT * FROM empleados WHERE id='$empleado_id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros de empleados
    public function listar()
    {
        $sql = "SELECT FROM empleados";
        return ejecutarConsulta($sql);
    }

    // Método para listar y mostrar en un select los registros de empleados 
    public function select()
    {
        $sql = "SELECT FROM empleados";

        return ejecutarConsulta($sql);
    }
}

// puede ser que utilice o se elimina 
?>