<?php

session_start();

require_once "backend/config/database.php";

if (!isset($_SESSION["id"])) {

    header("Location: login.html");
    exit;

}

if (!isset($_GET["id"])) {

    header("Location: ofertas_laborales.php");
    exit;

}

$conn = conectar();

$id = intval($_GET["id"]);

$sql = "SELECT * FROM ofertas_laborales WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    header("Location: ofertas_laborales.php");
    exit;

}

$oferta = $resultado->fetch_assoc();

$stmt->close();

$conn->close();

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title><?php echo $oferta["titulo"]; ?> | AHK Uruguay</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">

<link rel="stylesheet"
      href="assets/css/ofertas.css">

</head>

<body>

<!-- ==========================
            NAVBAR
========================== -->

<nav class="navbar navbar-expand-lg navbar-dark">

<div class="container">

<a class="navbar-brand d-flex align-items-center"
   href="index.html">

<img src="./assets/img/logo.png"
     width="55"
     height="55"
     class="me-2">

AHK Uruguay

</a>

<button
class="navbar-toggler"
data-bs-toggle="collapse"
data-bs-target="#menu">

<span class="navbar-toggler-icon"></span>

</button>

<div
class="collapse navbar-collapse"
id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">

<a class="nav-link"
href="index.html">

Inicio

</a>

</li>

<li class="nav-item">

<a class="nav-link active"
href="ofertas_laborales.php">

Ofertas Laborales

</a>

</li>

<li class="nav-item">

<a class="nav-link"
href="perfil.php">

Mi Perfil

</a>

</li>

<li class="nav-item">

<a class="nav-link"
href="logout.php">

Cerrar Sesión

</a>

</li>

</ul>

</div>

</div>

</nav>

<!-- ==========================
        DETALLE OFERTA
========================== -->

<div class="container my-5">

<div class="card oferta">

<div class="card-body">

<h2 class="mb-3 text-danger">

<?php echo $oferta["titulo"]; ?>

</h2>

<?php

if(isset($_GET["mensaje"])){

    if($_GET["mensaje"]=="ok"){

?>

<div class="alert alert-success">

✅ Tu postulación fue enviada correctamente.

</div>

<?php

    }

    if($_GET["mensaje"]=="ya_postulado"){

?>

<div class="alert alert-warning">

Ya te encuentras postulado a esta oferta.

</div>

<?php

    }

}

?>

<h4 class="mb-4">

<?php echo $oferta["empresa"]; ?>

</h4>

<div class="datos mb-4">

<span>

📍

<?php echo $oferta["ubicacion"]; ?>

</span>

<span>

💼

<?php echo $oferta["modalidad"]; ?>

</span>

<span>

💰

<?php echo $oferta["salario"]; ?>

</span>

</div>

<hr>

<h4 class="text-danger mb-3">

Descripción del Puesto

</h4>

<p class="descripcion">

<?php echo nl2br($oferta["descripcion"]); ?>

</p>

<hr>

<h4 class="text-danger mb-3">

Requisitos

</h4>

<p class="descripcion">

<?php echo nl2br($oferta["requisitos"]); ?>

</p>

<hr>

<div class="row mt-4">

<div class="col-md-6">

<p>

<strong>Fecha de publicación:</strong>

<?php echo date("d/m/Y", strtotime($oferta["fecha_publicacion"])); ?>

</p>

</div>

</div>

<hr>

<div class="d-flex justify-content-between flex-wrap">

<a
href="ofertas_laborales.php"
class="btn btn-secondary">

← Volver

</a>

<a
href="postular.php?id=<?php echo $oferta["id"]; ?>"
class="btn btn-danger">

Postularme

</a>

</div>

</div>

</div>

</div>

<!-- ==========================
            FOOTER
========================== -->

<footer>

© 2026 AHK Uruguay | Todos los derechos reservados.

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
```
