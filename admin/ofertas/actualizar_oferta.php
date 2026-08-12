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
        VALIDAR ID
==============================*/

if (!isset($_POST["id"])) {

    header("Location: listar_ofertas.php");
    exit;

}

$conn = conectar();

/*==============================
        RECIBIR DATOS
==============================*/

$id = intval($_POST["id"]);

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

    header("Location: editar_oferta.php?id=".$id."&error=1");
    exit;

}

/*==============================
        ACTUALIZAR
==============================*/

$sql = "UPDATE ofertas_laborales
        SET
            titulo=?,
            empresa=?,
            ubicacion=?,
            modalidad=?,
            salario=?,
            descripcion=?,
            requisitos=?,
            fecha_publicacion=?
        WHERE id=?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(

    "ssssssssi",

    $titulo,
    $empresa,
    $ubicacion,
    $modalidad,
    $salario,
    $descripcion,
    $requisitos,
    $fecha_publicacion,
    $id

);

$stmt->execute();

$stmt->close();

$conn->close();

/*==============================
        REDIRECCIÓN
==============================*/

header("Location: listar_ofertas.php?actualizado=1");

exit;

?>