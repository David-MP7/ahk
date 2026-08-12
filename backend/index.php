<?php
session_start();
// Importa el DAO
require_once __DIR__ . '/dao/UsuarioDAO.php';
// Indica que la respuesta será JSON
header('Content-Type: application/json');
// Obtiene el parámetro action de la URL
$action = $_POST['action'] ?? '';
// Estructura de control principal
switch ($action) {

  case 'usuarios':
      // Devuelve todos los usuarios
      echo json_encode(getUsuarios());
      break;

  case 'usuario':
      // Verifica si viene el ID
      if (isset($_POST['id'])) {

          echo json_encode(getUsuario($_POST['id']));

      } else {
          echo json_encode(["error" => "Falta id"]);
      }
      break;
   case 'agregar_usuario':

      $nombre = $_POST['nombre'] ?? '';

      $apellido = $_POST['apellido'] ?? '';

      $telefono = $_POST['telefono'] ?? '';

      $correo = $_POST['correo'] ?? '';

      $contrasena = $_POST['contrasena'] ?? '';
      if ($nombre && $apellido && $telefono && $correo && $contrasena) {

          $ok = agregarUsuario($nombre, $apellido, $telefono, $correo, $contrasena);

          echo json_encode($ok);

      } else {

          echo json_encode(false);

      }

      break;
      case 'login':

    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $usuario = login($correo, $contrasena);

    if($usuario){

        $_SESSION["id"] = $usuario["id"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["correo"] = $usuario["correo"];

        echo json_encode(true);

    }else{

        echo json_encode(false);

    }

    break;


  default:
      echo json_encode(["error" => "Ruta no válida"]);
}
?>