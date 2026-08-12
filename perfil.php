<?php

session_start();

require_once "backend/config/database.php";

if (!isset($_SESSION["id"])) {

    header("Location: login.html");

    exit;

}

$conn = conectar();

$id_usuario = $_SESSION["id"];

// Buscar el perfil del usuario

$sql = "SELECT * FROM perfil_usuario WHERE id_usuario = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();

$perfil = $resultado->fetch_assoc();

$stmt->close();

$conn->close();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/perfil.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <title>Mi Perfil - AHK Uruguay</title>

</head>

<body>

<!-- ==========================
        NAVBAR
=========================== -->

<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="index.html">

            <img src="./assets/img/logo.png"
                width="55"
                height="55"
                class="me-2">

            AHK Uruguay

        </a>

        <button class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
            id="menu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="index.html">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="ofertas_laborales.php">
                        Ofertas Laborales
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Mi Perfil
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        Cerrar Sesión
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>

<!-- ==========================
        PERFIL
=========================== -->

<div class="container my-5">

    <div class="card shadow">

        <div class="card-header bg-danger text-white">

            <h2 class="text-center">

                Perfil Profesional

            </h2>

        </div>

        <div class="card-body">

            <form action="guardar_perfil.php"
                method="POST"
                enctype="multipart/form-data">
                <!-- ==========================
        FOTO DE PERFIL
=========================== -->

<div class="row mb-5">

    <div class="text-center mb-4">

<?php if(!empty($perfil["foto"])){ ?>

<img

src="<?php echo $perfil["foto"]; ?>"

id="previewFoto"

class="mb-3">

<?php }else{ ?>

<img

src="https://via.placeholder.com/180"

id="previewFoto"

class="mb-3">

<?php } ?>

<input

type="file"

name="foto"

class="form-control"

accept="image/*">

</div>

    </div>

    <div class="col-md-9">

        <div class="mb-4">

            <label class="form-label fw-bold">

                Nombre Completo

            </label>

            <input
                type="text"
                class="form-control"
                name="nombre_completo"
                value="<?php echo $perfil['nombre_completo'] ??"";?>">

        </div>

        <div class="mb-4">

            <label class="form-label fw-bold">

                Profesión

            </label>

            <input
                type="text"
                class="form-control"
                name="profesion"
                placeholder="Ej: Desarrollador Web, Contador, Ingeniero Industrial..."
                value="<?php echo $perfil["profesion"] ?? ""; ?>">
                

        </div>

    </div>

</div>

<hr>

<!-- ==========================
    CARTA DE PRESENTACIÓN
=========================== -->

<div class="mb-4">

    <label class="form-label fw-bold">

        Carta de Presentación

    </label>

    <textarea
        class="form-control"
        name="presentacion"
        rows="7"
        placeholder="Cuéntanos sobre ti, tus objetivos profesionales, tus fortalezas y por qué una empresa debería contratarte."><?php echo $perfil["presentacion"] ?? ""; ?></textarea>

</div>

<hr>
<!-- ==========================
        EXPERIENCIA LABORAL
=========================== -->

<div class="mb-4">

    <label class="form-label fw-bold">

        Experiencia Laboral

    </label>

    <textarea
        class="form-control"
        name="experiencia"
        rows="7"
        placeholder="Describe tu experiencia laboral, empresas donde trabajaste, cargos desempeñados, responsabilidades y logros."><?php echo $perfil["experiencia"] ?? ""; ?></textarea>

</div>

<hr>

<!-- ==========================
        FORMACIÓN ACADÉMICA
=========================== -->

<div class="mb-4">

    <label class="form-label fw-bold">

        Formación Académica

    </label>

    <textarea
        class="form-control"
        name="estudios"
        rows="6"
        placeholder="Escribe tus estudios, cursos, certificaciones, universidad, instituto o formación técnica."><?php echo $perfil["estudios"] ?? ""; ?></textarea>

</div>

<hr>

<!-- ==========================
        HABILIDADES
=========================== -->

<div class="mb-4">

    <label class="form-label fw-bold">

        Habilidades

    </label>

    <textarea
        class="form-control"
        name="habilidades"
        rows="5"
        placeholder="Ejemplo: Trabajo en equipo, HTML, CSS, JavaScript, PHP, Office, Atención al cliente, Liderazgo..."><?php echo $perfil["habilidades"] ?? ""; ?></textarea>

</div>

<hr>

<!-- ==========================
        IDIOMAS
=========================== -->

<div class="mb-4">

    <label class="form-label fw-bold">

        Idiomas

    </label>

    <textarea
        class="form-control"
        name="idiomas"
        rows="4"
        placeholder="Ejemplo: Español (Nativo), Inglés (Intermedio), Alemán (Básico)."><?php echo $perfil["idiomas"] ?? ""; ?></textarea>

</div>

<hr>
<!-- ==========================
        INFORMACIÓN DE CONTACTO
=========================== -->

<div class="mb-4">

    <label class="form-label fw-bold">

        Información de Contacto

    </label>

    <textarea
        class="form-control"
        name="contacto"
        rows="5"
        placeholder="Ingresa información de contacto adicional. Ejemplo: Dirección, LinkedIn, GitHub, página web, etc."><?php echo $perfil["contacto"] ?? ""; ?></textarea>

</div>

<hr>

<!-- ==========================
        CURRICULUM VITAE
=========================== -->

<div class="mb-5">

    <label class="form-label fw-bold">

        Adjuntar Curriculum Vitae (PDF)

    </label>

    <input
        type="file"
        class="form-control"
        name="curriculum"
        accept=".pdf">
        <?php if(!empty($perfil["curriculum"])){ ?>

<div class="mt-3">

<a

href="<?php echo $perfil["curriculum"]; ?>"

target="_blank"

class="btn btn-outline-primary">

Ver Curriculum Actual

</a>

</div>

<?php } ?>

    <div class="form-text">

        Solo se permiten archivos PDF.

    </div>

</div>

<!-- ==========================
        BOTONES
=========================== -->

<div class="text-center">

    <button
        type="submit"
        class="btn btn-danger btn-lg px-5 me-3">

        Guardar Perfil

    </button>

    <a
        href="principal.html"
        class="btn btn-secondary btn-lg px-5">

        Cancelar

    </a>

</div>

</form>

</div>

</div>

</div>

<!-- ==========================
        FOOTER
=========================== -->

<footer>

    © 2026 AHK Uruguay | Todos los derechos reservados.

</footer>

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>