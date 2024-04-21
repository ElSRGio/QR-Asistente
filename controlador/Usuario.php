<?php
// Iniciamos la sesión
session_start();
// Incluimos el archivo de la clase Usuario 
require_once "../modelos/Usuario.php";

// Creamos una instancia del objeto
$usuario Susuario=new Usuario();

// Recibimos los datos enviados por el formulario
$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$password = isset($_POST["password"]) ? limpiarCadena($_POST["password"]) : "";
$password = isset($_POST["password"]) ? limpiarCadena($_POST["password"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

// Dependiendo de la operación solicitada mediante la variable $_GET["op"] 
Switch ($_GET["op"]) {
case 'guardaryeditar':
// Inicializamos la variable que contendrá el hash de la contraseña
$clavehash='';
// Verificamos si se ha subido una nueva imagen
if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
// Si no se ha subido una nueva imagen, conservamos la imagen actual
$imagen = $_POST["imagenactual"];
} else {
// Si se ha subido una nueva imagen, la movemos al directorio correspondiente
$ext=explode(".", $_FILES["imagen"]["name"]);
if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
{
$imagen = round(microtime(true)).'.'. end($ext);
move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
	}
 }

 // Si se ha ingresado una nueva contraseña 
if (!empty($password)) {
    // Generamos el hash SHA256 para la contraseña
     $clavehash = hash("SHA256", $password);
}


// Verificamos si se está insertando un nuevo usuario o editando uno existente 
if (empty($idusuario)) {
// Si es un nuevo usuario, llamamos al método insertar de la clase Usuario
$rspta=$usuario->insertar ($nombre, $apellidos, $login, $email, $clavehash, $imagen);
// Devolvemos un mensaje según el resultado de la operación
echos $rspta ? "Datos registrados correctamente": "No se pudo registrar todos los datos del usuario"; 
} else {
// Si es un usuario existente, llamamos al método editar de la clase Usuario
$rspta = $usuario->editar($idusuario, $nombre, $apellidos, $login, $email, $clavehash, $imagen);
// Devolvemos un mensaje según el resultado de la operación
echo $rspta? "Datos actualizados correctamente": "No se pudo actualizar los datos";
}
break;
