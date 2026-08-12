<?php

session_start();

require_once "../../backend/config/database.php";


/*==============================
        VALIDAR SESIÓN
==============================*/

if(!isset($_SESSION["admin"])){

    header("Location: ../login_admin.php");

    exit;

}


/*==============================
        VALIDAR ID
==============================*/

if(!isset($_GET["id"])){

    header("Location: listar_ofertas.php");

    exit;

}


$conn = conectar();


$id = intval($_GET["id"]);


/*==============================
    VERIFICAR OFERTA
==============================*/


$sql = "SELECT id 
        FROM ofertas_laborales 
        WHERE id=?";


$stmt = $conn->prepare($sql);


$stmt->bind_param("i",$id);


$stmt->execute();


$resultado = $stmt->get_result();



if($resultado->num_rows==0){


    header("Location: listar_ofertas.php?error=noexiste");

    exit;


}


$stmt->close();



/*==============================
    VERIFICAR POSTULACIONES
==============================*/


$sql = "SELECT id 
        FROM postulaciones
        WHERE id_oferta=?";


$stmt = $conn->prepare($sql);


$stmt->bind_param("i",$id);


$stmt->execute();


$resultado = $stmt->get_result();



if($resultado->num_rows>0){


    header("Location: listar_ofertas.php?error=tiene_postulaciones");


    exit;


}


$stmt->close();



/*==============================
        ELIMINAR OFERTA
==============================*/


$sql = "DELETE FROM ofertas_laborales
        WHERE id=?";


$stmt = $conn->prepare($sql);


$stmt->bind_param("i",$id);


$stmt->execute();



$stmt->close();

$conn->close();



/*==============================
        REDIRECCIÓN
==============================*/


header("Location: listar_ofertas.php?eliminado=1");


exit;


?>