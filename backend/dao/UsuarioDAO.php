<?php

// Importa la conexión a la base de datos
require_once __DIR__ . '/../config/database.php';

// Obtener todos los usuarios
function getUsuarios() {

  // Se conecta a la base
  $conn = conectar();

  // Ejecuta la consulta
  $res = $conn->query("SELECT * FROM usuarios");

  // Devuelve los datos en formato array
  return $res->fetch_all(MYSQLI_ASSOC);
}

// Obtener un usuario por ID
function getUsuario($id) {

  $conn = conectar();

  // Consulta preparada (más segura)
  $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");

  // Vincula el parámetro
  $stmt->bind_param("i", $id);

  // Ejecuta la consulta
  $stmt->execute();

  // Devuelve un solo registro
  return $stmt->get_result()->fetch_assoc();
}
function agregarUsuario($nombre, $apellido, $telefono, $correo, $contrasena) {
  $conn = conectar();

  $hash = password_hash($contrasena, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("Insert into usuarios(nombre, apellido, telefono, correo, contrasena) 
  values(?, ?, ?, ?, ?)"
  );

  $stmt->bind_param(
  "sssss", 
  $nombre, 
  $apellido, 
  $telefono, 
  $correo, 
  $hash);

  return $stmt->execute();
}
function login($correo, $contrasena) {

    $conn = conectar();

    $stmt = $conn->prepare("
        SELECT * FROM usuarios
        WHERE correo = ?
    ");

    $stmt->bind_param("s", $correo);

    $stmt->execute();

    $usuario = $stmt->get_result()->fetch_assoc();

    if ($usuario && password_verify($contrasena, $usuario["contrasena"])) {
        return $usuario;
    }

    return false;
}
// Buscar usuario por correo
function buscarUsuarioPorCorreo($correo) {

    $conn = conectar();

    $stmt = $conn->prepare("
        SELECT id, nombre, correo
        FROM usuarios
        WHERE correo = ?
    ");

    $stmt->bind_param("s", $correo);

    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}


// Crear token de recuperación
function crearTokenRecuperacion($usuario_id) {

    $conn = conectar();

    // Generar token seguro
    $token = bin2hex(random_bytes(32));

    // El token será válido durante 30 minutos
    $expira = date("Y-m-d H:i:s", time() + 1800);

    $stmt = $conn->prepare("
        INSERT INTO password_resets
        (usuario_id, token, expira_en)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param(
        "iss",
        $usuario_id,
        $token,
        $expira
    );

    if ($stmt->execute()) {
        return $token;
    }

    return false;
}


// Buscar un token válido
function obtenerTokenValido($token) {

    $conn = conectar();

    $stmt = $conn->prepare("
        SELECT *
        FROM password_resets
        WHERE token = ?
        AND usado = 0
        AND expira_en > NOW()
        LIMIT 1
    ");

    $stmt->bind_param("s", $token);

    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}


// Cambiar contraseña
function cambiarContrasena($usuario_id, $nueva_contrasena) {

    $conn = conectar();

    // Encriptar contraseña
    $hash = password_hash(
        $nueva_contrasena,
        PASSWORD_DEFAULT
    );

    $stmt = $conn->prepare("
        UPDATE usuarios
        SET contrasena = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "si",
        $hash,
        $usuario_id
    );

    if (!$stmt->execute()) {
        return false;
    }

    return true;
}


// Marcar token como utilizado
function marcarTokenUsado($token) {

    $conn = conectar();

    $stmt = $conn->prepare("
        UPDATE password_resets
        SET usado = 1
        WHERE token = ?
    ");

    $stmt->bind_param("s", $token);

    return $stmt->execute();
}
function restablecerContrasena($token, $nueva_contrasena) {

    $conn = conectar();

    // Buscar token válido
    $stmt = $conn->prepare("
        SELECT usuario_id
        FROM password_resets
        WHERE token = ?
        AND usado = 0
        AND expira_en > NOW()
        LIMIT 1
    ");

    $stmt->bind_param("s", $token);

    $stmt->execute();

    $resultado = $stmt->get_result();

    $registro = $resultado->fetch_assoc();


    // Token inválido o vencido
    if (!$registro) {

        return false;

    }


    $usuario_id = $registro["usuario_id"];


    // Crear hash de la nueva contraseña
    $hash = password_hash(
        $nueva_contrasena,
        PASSWORD_DEFAULT
    );


    // Actualizar contraseña
    $stmt = $conn->prepare("
        UPDATE usuarios
        SET contrasena = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "si",
        $hash,
        $usuario_id
    );


    if (!$stmt->execute()) {

        return false;

    }


    // Marcar token como utilizado
    $stmt = $conn->prepare("
        UPDATE password_resets
        SET usado = 1
        WHERE token = ?
    ");

    $stmt->bind_param("s", $token);

    $stmt->execute();


    return true;
}