<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Usuario{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro asdfasd f
public function insertar($nombre,$apellidos,$login,$email,$clavehash,$imagen){
	$sql="INSERT INTO usuarios (nombre,apellidos,login,email,password,imagen,estado,) VALUES ('$nombre','$apellidos','$login','$email','$clavehash','$imagen','1')";
	return ejecutarConsulta($sql);

}

//Metodo editar 
public function editar($idusuario, $nombre, $apellidos, $login, $email, $clavehash, $imagen)
{
if (empty($clavehash)) {
$sql = "UPDATE usuarios SET nombre='$nombre, apellidos='$apellidos', login='$login', email='$email', password='$clavehash', 
imagen-'$imagen' WHERE idusuario='$idusuario'";
} else {

$sql = "UPDATE usuarios SET nombre='$nombre, apellidos='$apellidos', login='$login', email='$email', password='$clavehash', 
imagen-'$imagen' WHERE idusuario='$idusuario'";
}
return ejecutarConsulta ($sql);
}



public function desactivar($idusuario){
	$sql="UPDATE usuarios SET estado='0' WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}


public function activar($idusuario){
	$sql="UPDATE usuarios SET estado='1' WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}



//metodo para mostrar registros
public function mostrar($idusuario)
{
	$sql="SELECT * FROM usuarios WHERE idusuario='$idusuario'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM usuarios";
	return ejecutarConsulta($sql);
}

public function cantidad_usuario(){
	$sql="SELECT count(*) nombre FROM usuarios";
	return ejecutarConsulta($sql);
}

//Función para verificar el acceso al sistema
	public function verificar($login,$clave)
    {
    	$sql = "SELECT FROM usuarios WHERE login='$login' AND password='$clave' AND estado='1'";
		 return ejecutarConsulta($sql);

    }
}

 ?>
