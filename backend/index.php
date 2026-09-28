<?php
session_start();
// Importa el DAO
require_once __DIR__ . '/email.php';
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
    case 'recuperar_contrasena':

    $correo = $_POST['correo'] ?? '';

    if (!$correo) {

        echo json_encode([
            "ok" => false,
            "mensaje" => "Debes ingresar un correo."
        ]);

        break;
    }


    $usuario = buscarUsuarioPorCorreo($correo);


    /*
     * No informamos si el correo existe
     * por seguridad.
     */

    if ($usuario) {

        $token = crearTokenRecuperacion($usuario["id"]);


        if ($token) {

            $enviado = enviarCorreoRecuperacion(
                $usuario["correo"],
                $usuario["nombre"],
                $token
            );


            if (!$enviado) {

                error_log(
                    "No se pudo enviar el correo de recuperación."
                );
            }
        }
    }


    /*
     * Siempre mostramos el mismo mensaje,
     * exista o no el correo.
     */

    echo json_encode([

        "ok" => true,

        "mensaje" =>
            "Si existe una cuenta asociada a ese correo, " .
            "recibirás instrucciones para restablecer tu contraseña."

    ]);

    break;
    case 'restablecer_contrasena':

    $token = $_POST['token'] ?? '';

    $nueva_contrasena =
        $_POST['nueva_contrasena'] ?? '';


    if (!$token || !$nueva_contrasena) {

        echo json_encode([

            "ok" => false,

            "mensaje" =>
                "Faltan datos para cambiar la contraseña."

        ]);

        break;

    }


    if (strlen($nueva_contrasena) < 8) {

        echo json_encode([

            "ok" => false,

            "mensaje" =>
                "La contraseña debe tener al menos 8 caracteres."

        ]);

        break;

    }


    $resultado = restablecerContrasena(
        $token,
        $nueva_contrasena
    );


    if ($resultado) {

        echo json_encode([

            "ok" => true,

            "mensaje" =>
                "Tu contraseña fue cambiada correctamente."

        ]);

    } else {

        echo json_encode([

            "ok" => false,

            "mensaje" =>
                "El enlace no es válido o ya expiró."

        ]);

    }


    break;

  default:
      echo json_encode(["error" => "Ruta no válida"]);
}
?>