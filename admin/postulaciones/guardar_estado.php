<?php

session_start();

require_once "../../backend/config/database.php";


if(!isset($_SESSION["admin"])){

    header("Location: ../login_admin.php");

    exit;

}


$conn = conectar();


$id = intval($_POST["id"]);

$estado = $_POST["estado"];



$sql = "

UPDATE postulaciones

SET estado=?

WHERE id=?

";



$stmt = $conn->prepare($sql);


$stmt->bind_param(

"si",

$estado,

$id

);


$stmt->execute();



$stmt->close();

$conn->close();



header("Location: listar_postulaciones.php?actualizado=1");


exit;


?>