<?php

session_start();

require_once "../../backend/config/database.php";

/*==============================
        VALIDAR SESIÓN
==============================*/

if (!isset($_SESSION["admin"])) {

    header("Location: ../login_admin.php");

    exit;

}

/*==============================
        CONEXIÓN
==============================*/

$conn = conectar();

/*==============================
        RECIBIR DATOS
==============================*/

$titulo = trim($_POST["titulo"]);
$empresa = trim($_POST["empresa"]);
$ubicacion = trim($_POST["ubicacion"]);
$modalidad = trim($_POST["modalidad"]);
$salario = trim($_POST["salario"]);
$descripcion = trim($_POST["descripcion"]);
$requisitos = trim($_POST["requisitos"]);
$fecha_publicacion = $_POST["fecha_publicacion"];

/*==============================
        VALIDAR CAMPOS
==============================*/

if (

    empty($titulo) ||

    empty($empresa) ||

    empty($ubicacion) ||

    empty($modalidad) ||

    empty($salario) ||

    empty($descripcion) ||

    empty($requisitos) ||

    empty($fecha_publicacion)

){

    header("Location: agregar_oferta.php?error=1");

    exit;

}

/*==============================
        INSERTAR
==============================*/

$sql = "INSERT INTO ofertas_laborales(

titulo,

empresa,

ubicacion,

modalidad,

salario,

descripcion,

requisitos,

fecha_publicacion

)

VALUES(

?,

?,

?,

?,

?,

?,

?,

?

)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(

"ssssssss",

$titulo,

$empresa,

$ubicacion,

$modalidad,

$salario,

$descripcion,

$requisitos,

$fecha_publicacion

);

$stmt->execute();

$stmt->close();

$conn->close();

/*==============================
        REDIRECCIÓN
==============================*/

header("Location: listar_ofertas.php?ok=1");

exit;

?>