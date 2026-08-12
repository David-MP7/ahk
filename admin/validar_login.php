<?php

session_start();

require_once "../backend/config/database.php";

$conn = conectar();

$usuario = $_POST["usuario"];

$password = $_POST["password"];

$sql = "SELECT *
        FROM administradores
        WHERE usuario=?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s",$usuario);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows==1){

    $admin = $resultado->fetch_assoc();

    if($password == $admin["password"]){

        $_SESSION["admin"] = $admin["id"];

        $_SESSION["usuario_admin"] = $admin["usuario"];

        header("Location: dashboard.php");

        exit;

    }

}

header("Location: login_admin.php?error=1");

exit;

?>