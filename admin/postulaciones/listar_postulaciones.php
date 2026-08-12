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


$conn = conectar();


/*==============================
        OBTENER POSTULACIONES
==============================*/


$sql = "

SELECT

postulaciones.id,

postulaciones.fecha_postulacion,

postulaciones.estado,

usuarios.nombre,

usuarios.correo,

ofertas_laborales.titulo


FROM postulaciones


INNER JOIN usuarios

ON postulaciones.id_usuario = usuarios.id


INNER JOIN ofertas_laborales

ON postulaciones.id_oferta = ofertas_laborales.id


ORDER BY postulaciones.fecha_postulacion DESC

";



$resultado = $conn->query($sql);

if(!$resultado){

    die("Error en la consulta SQL: " . $conn->error);

}

?>


<!DOCTYPE html>

<html lang="es">


<head>


<meta charset="UTF-8">


<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Postulaciones | Administración</title>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
rel="stylesheet">



<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">



<link rel="stylesheet"
href="../css/admin.css">



</head>



<body>



<div class="d-flex">


<!-- =====================
        SIDEBAR
===================== -->


<div class="sidebar">


<div class="logo">


<img src="../../assets/img/logo.png"
width="80">


<h4>

AHK Uruguay

</h4>


</div>



<hr>


<a href="../dashboard.php">

🏠 Dashboard

</a>


<a href="../ofertas/listar_ofertas.php">

💼 Gestionar Ofertas

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



<!-- =====================
        CONTENIDO
===================== -->


<div class="contenido">


<h2 class="mb-4">

Gestión de Postulaciones

</h2>

<?php

if(isset($_GET["actualizado"])){

?>

<div class="alert alert-success">

El estado de la postulación fue actualizado correctamente.

</div>

<?php

}

?>

<div class="card shadow">


<div class="card-body">



<div class="table-responsive">



<table class="table table-hover align-middle">



<thead class="table-danger">


<tr>


<th>

Candidato

</th>


<th>

Correo

</th>


<th>

Oferta

</th>


<th>

Fecha

</th>


<th>

Estado

</th>


<th>

Acciones

</th>


</tr>


</thead>



<tbody>


<?php


if($resultado->num_rows > 0){



while($fila = $resultado->fetch_assoc()){


?>


<tr>


<td>

<?php echo $fila["nombre"]; ?>

</td>



<td>

<?php echo $fila["correo"]; ?>

</td>



<td>

<?php echo $fila["titulo"]; ?>

</td>



<td>


<?php

echo date(

"d/m/Y",

strtotime($fila["fecha_postulacion"])

);


?>


</td>



<td>


<span class="badge bg-warning text-dark">


<?php echo $fila["estado"]; ?>


</span>



</td>



<td>


<a

href="cambiar_estado.php?id=<?php echo $fila["id"]; ?>"

class="btn btn-danger btn-sm">


Gestionar


</a>


</td>



</tr>



<?php


}



}else{


?>


<tr>


<td colspan="6"
class="text-center">


No existen postulaciones.


</td>


</tr>



<?php


}



?>



</tbody>



</table>


</div>



</div>


</div>



</div>


</div>



</body>


</html>



<?php

$conn->close();

?>