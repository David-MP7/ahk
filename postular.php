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

$id_usuario = $_SESSION["id"];

$id_oferta = intval($_GET["id"]);

/*==============================
    VERIFICAR OFERTA
==============================*/

$sql = "SELECT id
        FROM ofertas_laborales
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i",$id_oferta);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows==0){

    header("Location: ofertas_laborales.php");
    exit;

}

$stmt->close();

/*==============================
    VERIFICAR POSTULACIÓN
==============================*/

$sql = "SELECT id
        FROM postulaciones
        WHERE id_usuario = ?
        AND id_oferta = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ii",$id_usuario,$id_oferta);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows>0){

    header("Location: detalle_oferta.php?id=".$id_oferta."&mensaje=ya_postulado");
    exit;

}

$stmt->close();

/*==============================
    INSERTAR POSTULACIÓN
==============================*/

$sql = "INSERT INTO postulaciones
        (
            id_usuario,
            id_oferta,
            fecha_postulacion,
            estado
        )
        VALUES
        (
            ?,
            ?,
            NOW(),
            'Pendiente'
        )";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ii",$id_usuario,$id_oferta);

$stmt->execute();

$stmt->close();

$conn->close();

header("Location: detalle_oferta.php?id=".$id_oferta."&mensaje=ok");

exit;

?>