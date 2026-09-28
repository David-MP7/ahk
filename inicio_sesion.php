<?php

session_start();

require_once "backend/config/database.php";

/* Verificar que el usuario haya iniciado sesión */
if (!isset($_SESSION["id"])) {

    header("Location: login.html");
    exit;

}

$conn = conectar();

$id_usuario = $_SESSION["id"];

/* ==========================
   OBTENER DATOS DEL USUARIO
========================== */

$sql_usuario = "SELECT nombre, apellido, correo, telefono
                FROM usuarios
                WHERE id = ?";

$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $id_usuario);
$stmt_usuario->execute();

$resultado_usuario = $stmt_usuario->get_result();
$usuario = $resultado_usuario->fetch_assoc();

$stmt_usuario->close();


/* ==========================
   OBTENER PERFIL
========================== */

$sql_perfil = "SELECT foto, profesion, presentacion
               FROM perfil_usuario
               WHERE id_usuario = ?";

$stmt_perfil = $conn->prepare($sql_perfil);
$stmt_perfil->bind_param("i", $id_usuario);
$stmt_perfil->execute();

$resultado_perfil = $stmt_perfil->get_result();
$perfil = $resultado_perfil->fetch_assoc();

$stmt_perfil->close();

$conn->close();

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mi cuenta - AHK Uruguay</title>

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Google Fonts -->

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- CSS -->

    <link rel="stylesheet" href="assets/css/inicio_sesion.css">

</head>

<body>


<!-- ==========================
        NAVBAR
=========================== -->

<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a
            class="navbar-brand d-flex align-items-center"
            href="index.html">

            <img
                src="assets/img/logo.png"
                width="50"
                height="50"
                class="me-2"
                alt="Logo AHK">

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

                    <a
                        class="nav-link active"
                        href="inicio_usuario.php">

                        Inicio

                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="ofertas_laborales.php">

                        Ofertas Laborales

                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="perfil.php">

                        Mi Perfil

                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="logout.php">

                        Cerrar Sesión

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- ==========================
        CONTENIDO
=========================== -->

<main class="container py-5">


    <!-- Bienvenida -->

    <div class="welcome-section mb-4">

        <div>

            <p class="text-muted mb-1">
                Bienvenido nuevamente
            </p>

            <h1>

                Hola,
                <?php echo htmlspecialchars($usuario["nombre"]); ?>

            </h1>

            <p class="text-muted">

                Gestioná tu perfil y encontrá nuevas oportunidades laborales.

            </p>

        </div>

    </div>


    <!-- ==========================
        TARJETA DE PERFIL
    =========================== -->

    <div class="profile-card mb-5">

        <div class="profile-photo">

            <?php if (!empty($perfil["foto"])) { ?>

                <img
                    src="<?php echo htmlspecialchars($perfil["foto"]); ?>"
                    alt="Foto de perfil">

            <?php } else { ?>

                <div class="default-photo">

                    <i class="fa-solid fa-user"></i>

                </div>

            <?php } ?>

        </div>


        <div class="profile-info">

            <span class="profile-label">
                MI PERFIL
            </span>


            <h2>

                <?php

                echo htmlspecialchars(
                    $usuario["nombre"] . " " . $usuario["apellido"]
                );

                ?>

            </h2>


            <?php if (!empty($perfil["profesion"])) { ?>

                <p class="profession">

                    <?php echo htmlspecialchars($perfil["profesion"]); ?>

                </p>

            <?php } else { ?>

                <p class="profession">

                    Postulante

                </p>

            <?php } ?>


            <div class="contact-info">

                <span>

                    <i class="fa-solid fa-envelope"></i>

                    <?php echo htmlspecialchars($usuario["correo"]); ?>

                </span>


                <span>

                    <i class="fa-solid fa-phone"></i>

                    <?php echo htmlspecialchars($usuario["telefono"]); ?>

                </span>

            </div>


            <a
                href="perfil.php"
                class="btn btn-danger">

                <i class="fa-solid fa-pen-to-square"></i>

                Editar perfil

            </a>

        </div>

    </div>


    <!-- ==========================
        ACCESOS RÁPIDOS
    =========================== -->

    <h3 class="section-title">

        Accesos rápidos

    </h3>


    <div class="row g-4">


        <!-- Ofertas -->

        <div class="col-md-4">

            <div class="option-card">

                <div class="option-icon">

                    <i class="fa-solid fa-briefcase"></i>

                </div>


                <h4>

                    Ofertas laborales

                </h4>


                <p>

                    Explorá las oportunidades laborales disponibles.

                </p>


                <a
                    href="ofertas_laborales.php"
                    class="option-link">

                    Ver ofertas

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>

        </div>


        <!-- Postulaciones -->

        <div class="col-md-4">

            <div class="option-card">

                <div class="option-icon">

                    <i class="fa-solid fa-file-lines"></i>

                </div>


                <h4>

                    Mis postulaciones

                </h4>


                <p>

                    Consultá las ofertas a las que te has postulado.

                </p>


                <a
                    href="#"
                    class="option-link">

                    Ver postulaciones

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>

        </div>


        <!-- Perfil -->

        <div class="col-md-4">

            <div class="option-card">

                <div class="option-icon">

                    <i class="fa-solid fa-user"></i>

                </div>


                <h4>

                    Mi perfil

                </h4>


                <p>

                    Actualizá tus datos, experiencia y currículum.

                </p>


                <a
                    href="perfil.php"
                    class="option-link">

                    Editar perfil

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            </div>

        </div>

    </div>


</main>


<!-- ==========================
        FOOTER
=========================== -->

<footer>

    <div class="container">

        © 2026 AHK Uruguay | Todos los derechos reservados.

    </div>

</footer>


<!-- Bootstrap -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>