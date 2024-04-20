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
// Velificamos si se ha subido una nueva imagen