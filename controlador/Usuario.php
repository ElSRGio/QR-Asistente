<?php
// Iniciamos la sesión
session_start();
// Incluimos el archivo de la clase Usuario 
require_once "../modelos/Usuario.php";

// Creamos una instancia del objeto
$usuario = new Usuario();

// Recibimos los datos enviados por el formulario
$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$password = isset($_POST["password"]) ? limpiarCadena($_POST["password"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

// Dependiendo de la operación solicitada mediante la variable $_GET["op"] 
switch ($_GET["op"]) {
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
            $rspta=$usuario->insertar($nombre, $login, $email, $clavehash, $imagen);
            // Devolvemos un mensaje según el resultado de la operación
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del usuario"; 
        } else {
            // Si es un usuario existente, llamamos al método editar de la clase Usuario
            $rspta = $usuario->editar($idusuario, $nombre, $login, $email, $clavehash, $imagen);
            // Devolvemos un mensaje según el resultado de la operación
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
        break;

    case 'desactivar':
        // Llamamos al método desactivar de la clase Usuario
        $rspta = $usuario->desactivar($idusuario);
        // Devolvemos un mensaje según el resultado de la operación
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos"; 
        break;

    case 'activar':
        // Llamamos al método activar de la clase Usuario
        $rspta = $usuario->activar($idusuario);
        // Devolvemos un mensaje según el resultado de la operación
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
        break;

    case 'mostrar':
        // Llamamos al método mostrar de la clase Usuario
        $rspta = $usuario->mostrar($idusuario);
        // Devolvemos el resultado como un objeto JSON
        echo json_encode($rspta);
        break;

    case 'listar':
        // Llamamos al método listar de la clase Usuario
        $rspta = $usuario->listar();
        // Inicializamos un array para almacenar los datos
        $data = array();
        // Iteramos sobre los registros obtenidos y los almacenamos en el array
        while ($reg = $rspta->fetch_object()) {    
            $data[] = array(
                "0" => ($reg->estado) ? '<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.' '.
                '<button class="btn btn-info btn-xs" onclick="mostrar_clave('.$reg->idusuario.')"><i class="fa fa-key"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>' : '<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-info btn-xs" onclick="mostrar_clave('.$reg->idusuario.')"><i class="fa fa-key"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->apellidos,
                "3" => $reg->login,
                "4" => $reg->email,
                "5" => "<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px'>",
                "6" => ($reg->estado) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            );
        }   

        // Preparamos la respuesta para DataTables
        $results = array(
            "sEcho" => 1, // info para datatables
            "iTotalRecords" => count($data), // enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), // enviamos el total de registros a visualizar
            "aaData" => $data
        );

        // Devolvemos la respuesta como un objeto JSON
        echo json_encode($results);
        break;

    case 'verificar':
        // Validamos si el usuario tiene acceso al sistema
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];
        // Hash SHA256 para la contraseña
        $clavehash = hash("SHA256", $clavea);
        // Llamamos al método verificar de la clase Usuario 
        $rspta = $usuario->verificar($logina, $clavehash);
        // Obtenemos el resultado como un objeto
        $fetch = $rspta->fetch_object();
        // Si existe el usuario, declaramos las variables de sesión 
        if (isset($fetch)) {
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['login'] = $fetch->login;
        }
        // Devolvemos el resultado como un objeto JSON
        echo json_encode($fetch);
        break;

    case 'salir':
        // Limpiamos las variables de sesión 
        session_unset();
        // Destruimos la sesión
        session_destroy();
        // Redireccionamos al login
        header("Location:../index.php");
        break;
}
?>