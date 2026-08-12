<?php

session_start();

require_once "../../backend/config/database.php";

if(!isset($_SESSION["admin"])){

    header("Location: ../login_admin.php");

    exit;

}

$conn = conectar();

$sql = "SELECT * FROM ofertas_laborales
        ORDER BY fecha_publicacion DESC";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Gestionar Ofertas</title>

<?php

if(isset($_GET["eliminado"])){

?>

<div class="alert alert-success">

La oferta fue eliminada correctamente.

</div>

<?php

}


if(isset($_GET["error"]) && $_GET["error"]=="tiene_postulaciones"){

?>

<div class="alert alert-warning">

No se puede eliminar esta oferta porque tiene candidatos postulados.

</div>

<?php

}


if(isset($_GET["error"]) && $_GET["error"]=="noexiste"){

?>

<div class="alert alert-danger">

La oferta no existe.

</div>

<?php

}

?>

<?php

if(isset($_GET["actualizado"])){

?>

<div class="alert alert-success">

La oferta fue actualizada correctamente.

</div>

<?php

}

?>

<?php

if(isset($_GET["ok"])){

?>

<div class="alert alert-success">

La oferta fue registrada correctamente.

</div>

<?php

}

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="../css/admin.css">

</head>

<body>

<div class="d-flex">

<!-- ======================
        SIDEBAR
====================== -->

<div class="sidebar">

<div class="logo">

<img src="../../assets/img/logo.png"
width="80">

<h4 class="mt-3">

AHK Uruguay

</h4>

</div>

<hr>

<a href="../dashboard.php">

🏠 Dashboard

</a>

<a href="listar_ofertas.php">

💼 Gestionar Ofertas

</a>

<a href="../postulaciones/listar_postulaciones.php">

📄 Postulaciones

</a>

<a href="../usuarios/listar_usuarios.php">

👤 Usuarios

</a>

<a href="../logout.php">

🚪 Cerrar sesión

</a>

</div>

<!-- ======================
        CONTENIDO
====================== -->

<div class="contenido">

<div class="d-flex
justify-content-between
align-items-center
mb-4">

<h2>

Gestionar Ofertas

</h2>

<a
href="agregar_oferta.php"
class="btn btn-danger">

+ Nueva Oferta

</a>

</div>

<div class="card shadow">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-danger">

<tr>

<th>ID</th>

<th>Título</th>

<th>Empresa</th>

<th>Ubicación</th>

<th>Modalidad</th>

<th>Salario</th>

<th>Fecha</th>

<th class="text-center">

Acciones

</th>

</tr>

</thead>

<tbody>

<?php

if($resultado->num_rows>0){

while($fila=$resultado->fetch_assoc()){

?>

<tr>

<td>

<?php echo $fila["id"]; ?>

</td>

<td>

<?php echo $fila["titulo"]; ?>

</td>

<td>

<?php echo $fila["empresa"]; ?>

</td>

<td>

<?php echo $fila["ubicacion"]; ?>

</td>

<td>

<?php echo $fila["modalidad"]; ?>

</td>

<td>

<?php echo $fila["salario"]; ?>

</td>

<td>

<?php

echo date(

"d/m/Y",

strtotime($fila["fecha_publicacion"])

);

?>

</td>

<td class="text-center">

<a

href="editar_oferta.php?id=<?php echo $fila["id"]; ?>"

class="btn btn-warning btn-sm">

Editar

</a>

<a

href="eliminar_oferta.php?id=<?php echo $fila["id"]; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('¿Desea eliminar esta oferta?');">

Eliminar

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="8"
class="text-center">

No existen ofertas laborales.

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