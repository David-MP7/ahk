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
                    <a class="nav-link" href="inicio_sesion.php">
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

<div class="container perfil-container my-4">

    <div class="perfil-card">

        <div class="perfil-header">

            <div>
                <h2>Perfil Profesional</h2>
                <p>Completa y actualiza tu información profesional</p>
            </div>

        </div>

        <form action="guardar_perfil.php"
              method="POST"
              enctype="multipart/form-data">

            <div class="perfil-body">

                <div class="section-title">
                    <span>01</span>
                    <div>
                        <h3>Información principal</h3>
                        <p>Datos básicos de tu perfil profesional</p>
                    </div>
                </div>

                <div class="main-profile">

                    <div class="photo-section">

                        <div class="photo-wrapper">

                            <?php if(!empty($perfil["foto"])){ ?>

                                <img
                                    src="<?php echo $perfil["foto"]; ?>"
                                    id="previewFoto"
                                    class="profile-photo">

                            <?php }else{ ?>

                                <img
                                    src="https://via.placeholder.com/180"
                                    id="previewFoto"
                                    class="profile-photo">

                            <?php } ?>

                        </div>

                        <label class="photo-label">
                            Foto de perfil
                        </label>

                        <input
                            type="file"
                            name="foto"
                            class="form-control"
                            accept="image/*">

                        <small>
                            Selecciona una imagen para tu perfil.
                        </small>

                    </div>


                    <!-- DATOS -->

                    <div class="profile-data">

                        <div class="field">

                            <label class="form-label">
                                Nombre Completo
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="nombre_completo"
                                value="<?php echo $perfil['nombre_completo'] ??"";?>">

                        </div>

                        <div class="field">

                            <label class="form-label">
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

                <div class="profile-section">

                    <div class="section-title">

                        <span>02</span>

                        <div>
                            <h3>Carta de presentación</h3>
                            <p>Presentate profesionalmente</p>
                        </div>

                    </div>

                    <textarea
                        class="form-control"
                        name="presentacion"
                        rows="3"
                        placeholder="Cuéntanos sobre ti, tus objetivos profesionales, tus fortalezas y por qué una empresa debería contratarte."><?php echo $perfil["presentacion"] ?? ""; ?></textarea>

                </div>

                <div class="profile-section">

                    <div class="section-title">

                        <span>03</span>

                        <div>
                            <h3>Experiencia laboral</h3>
                            <p>Agrega tu experiencia profesional</p>
                        </div>

                    </div>

                    <textarea
                        class="form-control"
                        name="experiencia"
                        rows="3"
                        placeholder="Describe tu experiencia laboral, empresas donde trabajaste, cargos desempeñados, responsabilidades y logros."><?php echo $perfil["experiencia"] ?? ""; ?></textarea>

                </div>

                <div class="profile-section">

                    <div class="section-title">

                        <span>04</span>

                        <div>
                            <h3>Formación académica</h3>
                            <p>Estudios, cursos y certificaciones</p>
                        </div>

                    </div>

                    <textarea
                        class="form-control"
                        name="estudios"
                        rows="3"
                        placeholder="Escribe tus estudios, cursos, certificaciones, universidad, instituto o formación técnica."><?php echo $perfil["estudios"] ?? ""; ?></textarea>

                </div>

                <div class="profile-section">

                    <div class="section-title">

                        <span>05</span>

                        <div>
                            <h3>Habilidades</h3>
                            <p>Destaca tus principales capacidades</p>
                        </div>

                    </div>

                    <textarea
                        class="form-control"
                        name="habilidades"
                        rows="3"
                        placeholder="Ejemplo: Trabajo en equipo, HTML, CSS, JavaScript, PHP, Office, Atención al cliente, Liderazgo..."><?php echo $perfil["habilidades"] ?? ""; ?></textarea>

                </div>

                <div class="profile-section">

                    <div class="section-title">

                        <span>06</span>

                        <div>
                            <h3>Idiomas</h3>
                            <p>Indica los idiomas que manejas</p>
                        </div>

                    </div>

                    <textarea
                        class="form-control"
                        name="idiomas"
                        rows="3"
                        placeholder="Ejemplo: Español (Nativo), Inglés (Intermedio), Alemán (Básico)."><?php echo $perfil["idiomas"] ?? ""; ?></textarea>

                </div>

                <div class="profile-section">

                    <div class="section-title">

                        <span>07</span>

                        <div>
                            <h3>Información de contacto</h3>
                            <p>Agrega información adicional</p>
                        </div>

                    </div>

                    <textarea
                        class="form-control"
                        name="contacto"
                        rows="3"
                        placeholder="Ingresa información de contacto adicional. Ejemplo: Dirección, LinkedIn, GitHub, página web, etc."><?php echo $perfil["contacto"] ?? ""; ?></textarea>

                </div>

                <div class="profile-section">

                    <div class="section-title">

                        <span>08</span>

                        <div>
                            <h3>Curriculum Vitae</h3>
                            <p>Adjunta tu CV en formato PDF</p>
                        </div>

                    </div>

                    <input
                        type="file"
                        class="form-control"
                        name="curriculum"
                        accept=".pdf">

                    <?php if(!empty($perfil["curriculum"])){ ?>

                        <div class="current-cv">

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

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-save">

                        Guardar Perfil

                    </button>

                    <a
                        href="inicio_sesion.php"
                        class="btn btn-cancel">

                        Cancelar

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<footer>

    © 2026 AHK Uruguay | Todos los derechos reservados.

</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>