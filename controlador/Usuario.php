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