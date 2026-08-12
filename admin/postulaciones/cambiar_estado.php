<?php

session_start();

require_once "../../backend/config/database.php";


/*==============================
        VALIDAR ADMIN
==============================*/

if(!isset($_SESSION["admin"])){

    header("Location: ../login_admin.php");

    exit;

}


/*==============================
        VALIDAR ID
==============================*/

if(!isset($_GET["id"])){

    header("Location: listar_postulaciones.php");

    exit;

}


$conn = conectar();


$id = intval($_GET["id"]);



/*==============================
    OBTENER POSTULACIÓN
==============================*/


$sql = "

SELECT

postulaciones.id,

postulaciones.id_usuario,

postulaciones.estado,

postulaciones.fecha_postulacion,

usuarios.nombre,

usuarios.correo,

ofertas_laborales.titulo


FROM postulaciones


INNER JOIN usuarios

ON postulaciones.id_usuario = usuarios.id


INNER JOIN ofertas_laborales

ON postulaciones.id_oferta = ofertas_laborales.id


WHERE postulaciones.id = ?


";



$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en SQL: " . $conn->error);
}

$stmt->bind_param("i",$id);


$stmt->execute();


$resultado = $stmt->get_result();



if($resultado->num_rows==0){

    header("Location: listar_postulaciones.php");

    exit;

}


$postulacion = $resultado->fetch_assoc();


$stmt->close();


?>

<!DOCTYPE html>

<html lang="es">

<head>


<meta charset="UTF-8">


<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Gestionar Postulación</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
rel="stylesheet">


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">


<link rel="stylesheet"
href="../css/admin.css">


</head>


<body>


<div class="d-flex">


<!-- SIDEBAR -->


<div class="sidebar">


<div class="logo">

<img src="../../assets/img/logo.png">

<h4>

AHK Uruguay

</h4>

</div>


<hr>


<a href="../dashboard.php">

🏠 Dashboard

</a>


<a href="../ofertas/listar_ofertas.php">

💼 Ofertas

</a>


<a href="listar_postulaciones.php">

📄 Postulaciones

</a>


<a href="../usuarios/listar_usuarios.php">

👤 Usuarios

</a>


<a href="../logout.php">

🚪 Cerrar sesión

</a>


</div>



<!-- CONTENIDO -->


<div class="contenido">


<div class="card shadow">


<div class="card-header bg-danger text-white">


<h3>

Gestionar Postulación

</h3>


</div>



<div class="card-body">


<div class="mb-3">


<h5>

Candidato

</h5>


<p>

<?php echo $postulacion["nombre"]; ?>

</p>


</div>



<div class="mb-3">


<h5>

Correo electrónico

</h5>


<p>

<?php echo $postulacion["correo"]; ?>

</p>


</div>

<a

href="../usuarios/ver_perfil.php?id=<?php echo $postulacion["id_usuario"]; ?>"

class="btn btn-outline-danger mb-3">

Ver Perfil Completo

</a>

<div class="mb-3">


<h5>

Oferta laboral

</h5>


<p>

<?php echo $postulacion["titulo"]; ?>

</p>


</div>



<div class="mb-3">


<h5>

Fecha de postulación

</h5>


<p>

<?php

echo date(

"d/m/Y H:i",

strtotime($postulacion["fecha_postulacion"])

);

?>

</p>


</div>



<hr>



<form action="guardar_estado.php"
method="POST">


<input

type="hidden"

name="id"

value="<?php echo $postulacion["id"]; ?>">



<label class="form-label fw-bold">

Estado de la postulación

</label>



<select

name="estado"

class="form-select mb-4">


<option value="Pendiente"

<?php

if($postulacion["estado"]=="Pendiente")

echo "selected";

?>>

Pendiente

</option>



<option value="En revisión"

<?php

if($postulacion["estado"]=="En revisión")

echo "selected";

?>>

En revisión

</option>



<option value="Entrevista"

<?php

if($postulacion["estado"]=="Entrevista")

echo "selected";

?>>

Entrevista

</option>



<option value="Aceptado"

<?php

if($postulacion["estado"]=="Aceptado")

echo "selected";

?>>

Aceptado

</option>



<option value="Rechazado"

<?php

if($postulacion["estado"]=="Rechazado")

echo "selected";

?>>

Rechazado

</option>


</select>



<div class="text-end">


<a

href="listar_postulaciones.php"

class="btn btn-secondary">

Volver

</a>



<button

type="submit"

class="btn btn-danger">

Guardar Estado

</button>



</div>



</form>



</div>


</div>


</div>


</div>


</body>

</html>


<?php

$conn->close();

?>