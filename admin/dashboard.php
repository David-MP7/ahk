<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

require_once "../backend/config/database.php";

if (!isset($_SESSION["admin"])) {

    header("Location: login_admin.php");
    exit();

}

$conn = conectar();

/*=========================
    ESTADÍSTICAS
=========================*/

// Total usuarios

$sql = "SELECT COUNT(*) AS total FROM usuarios";
$resultado = $conn->query($sql);
$usuarios = $resultado->fetch_assoc()["total"];

// Total ofertas

$sql = "SELECT COUNT(*) AS total FROM ofertas_laborales";
$resultado = $conn->query($sql);
$ofertas = $resultado->fetch_assoc()["total"];

// Total postulaciones

$sql = "SELECT COUNT(*) AS total FROM postulaciones";
$resultado = $conn->query($sql);
$postulaciones = $resultado->fetch_assoc()["total"];

// Postulaciones pendientes

$sql = "SELECT COUNT(*) AS total
        FROM postulaciones
        WHERE estado='Pendiente'";

$resultado = $conn->query($sql);
$pendientes = $resultado->fetch_assoc()["total"];

$conn->close();

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Panel de Administración</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="css/admin.css">

</head>

<body>

<div class="d-flex">

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">

<img src="../assets/img/logo.png">

<h4>

AHK Uruguay

</h4>

</div>

<hr>

<a href="dashboard.php">

🏠 Dashboard

</a>

<a href="ofertas/listar_ofertas.php">

💼 Gestionar Ofertas

</a>

<a href="postulaciones/listar_postulaciones.php">

📄 Postulaciones

</a>

<a href="usuarios/listar_usuarios.php">

👤 Usuarios

</a>

<a href="logout.php">

🚪 Cerrar sesión

</a>

</div>

<!-- CONTENIDO -->

<div class="contenido">

<h2>

Panel de Administración

</h2>

<p>

Bienvenido,

<strong>

<?php echo $_SESSION["usuario_admin"]; ?>

</strong>

</p>

<div class="row mt-4">

<div class="col-lg-3">

<div class="card card-dashboard">

<h5>

Usuarios

</h5>

<h2>

<?php echo $usuarios; ?>

</h2>

</div>

</div>

<div class="col-lg-3">

<div class="card card-dashboard">

<h5>

Ofertas

</h5>

<h2>

<?php echo $ofertas; ?>

</h2>

</div>

</div>

<div class="col-lg-3">

<div class="card card-dashboard">

<h5>

Postulaciones

</h5>

<h2>

<?php echo $postulaciones; ?>

</h2>

</div>

</div>

<div class="col-lg-3">

<div class="card card-dashboard">

<h5>

Pendientes

</h5>

<h2>

<?php echo $pendientes; ?>

</h2>

</div>

</div>

</div>

<div class="row mt-5">

<div class="col-lg-4">

<div class="card acceso">

<div class="card-body">

<h4>

Gestionar Ofertas

</h4>

<p>

Crear, editar o eliminar ofertas laborales.

</p>

<a
href="ofertas/listar_ofertas.php"
class="btn btn-danger">

Ingresar

</a>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card acceso">

<div class="card-body">

<h4>

Postulaciones

</h4>

<p>

Revisar candidatos y cambiar estados.

</p>

<a
href="postulaciones/listar_postulaciones.php"
class="btn btn-danger">

Ingresar

</a>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card acceso">

<div class="card-body">

<h4>

Usuarios

</h4>

<p>

Ver perfiles registrados.

</p>

<a
href="usuarios/listar_usuarios.php"
class="btn btn-danger">

Ingresar

</a>

</div>

</div>

</div>

</div>

</div>

</div>

<script>
window.addEventListener('pageshow', function(event) {
// Si la página se está cargando desde la memoria caché del navegador (botón atrás)
if (event.persisted || (typeof window.performance != 'undefined' && window.performance.navigation.type === 2)) {
// Forzamos al navegador a recargar la página desde el servidor
window.location.reload();
}
});
</script>

</body>

</html>