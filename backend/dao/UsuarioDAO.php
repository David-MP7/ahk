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