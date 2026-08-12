<?php

session_start();

require_once "backend/config/database.php";

if (!isset($_SESSION["id"])) {

    header("Location: login.html");
    exit;

}

$conn = conectar();

$sql = "SELECT * FROM ofertas_laborales
        ORDER BY fecha_publicacion DESC";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Ofertas Laborales | AHK Uruguay</title>

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Google Fonts -->

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS -->

    <link rel="stylesheet"
          href="assets/css/ofertas.css">

</head>

<body>

<!--==============================
            NAVBAR
===============================-->

<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a class="navbar-brand d-flex align-items-center"
           href="index.html">

            <img
                src="./assets/img/logo.png"
                width="55"
                height="55"
                class="me-2">

            AHK Uruguay

        </a>

        <button
            class="navbar-toggler"
            type="button"
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
                       href="#">

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

<!--==============================
            HERO
===============================-->

<section class="hero">

    <div class="container text-center">

        <h1>

            Encuentra tu próximo empleo

        </h1>

        <p>

            Descubre oportunidades laborales
            en empresas asociadas a
            AHK Uruguay.

        </p>

    </div>

</section>

<!--==============================
        BUSCADOR
===============================-->

<div class="container mt-4">

    <div class="card shadow-sm buscador">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-lg-5">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Buscar por cargo">

                </div>

                <div class="col-lg-3">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Ubicación">

                </div>

                <div class="col-lg-2">

                    <select class="form-select">

                        <option>
                            Todas
                        </option>

                        <option>
                            Presencial
                        </option>

                        <option>
                            Híbrido
                        </option>

                        <option>
                            Remoto
                        </option>

                    </select>

                </div>

                <div class="col-lg-2">

                    <button
                        class="btn btn-danger w-100">

                        Buscar

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<!--==============================
        OFERTAS
===============================-->

<div class="container my-5">

<?php

if($resultado->num_rows > 0){

while($fila = $resultado->fetch_assoc()){

?>

<div class="card oferta mb-4">

<div class="card-body">

<div class="row">

<div class="col-lg-9">

<h3>

<?php echo $fila["titulo"]; ?>

</h3>

<h5>

<?php echo $fila["empresa"]; ?>

</h5>

<div class="datos">

<span>

📍

<?php echo $fila["ubicacion"]; ?>

</span>

<span>

💼

<?php echo $fila["modalidad"]; ?>

</span>

<span>

💰

<?php echo $fila["salario"]; ?>

</span>

</div>

<p class="descripcion">

<?php

echo substr(
$fila["descripcion"],
0,
180
);

?>

...

</p>

<p class="fecha">

Publicado:

<strong>

<?php echo $fila["fecha_publicacion"]; ?>

</strong>

</p>

</div>

<div
class="col-lg-3 d-flex flex-column justify-content-center">

<a

href="detalle_oferta.php?id=<?php echo $fila["id"]; ?>"

class="btn btn-outline-danger mb-2">

Ver detalles

</a>

<a

href="postular.php?id=<?php echo $fila["id"]; ?>"

class="btn btn-danger">

Postularme

</a>

</div>

</div>

</div>

</div>

<?php

}

}else{

?>

<div class="alert alert-secondary text-center">

<h4>

No hay ofertas laborales disponibles.

</h4>

<p>

Las nuevas oportunidades aparecerán aquí.

</p>

</div>

<?php

}

$conn->close();

?>

</div>

<!--==============================
        FOOTER
===============================-->

<footer>

<div class="container">

© 2026 AHK Uruguay |
Todos los derechos reservados.

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>