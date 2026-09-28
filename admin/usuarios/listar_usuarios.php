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
        BUSCAR USUARIOS
==============================*/

$sql = "

SELECT

usuarios.id,

usuarios.nombre,

usuarios.correo,

perfil_usuario.nombre_completo,

perfil_usuario.profesion,

perfil_usuario.foto


FROM usuarios


LEFT JOIN perfil_usuario

ON usuarios.id = perfil_usuario.id_usuario

WHERE 1=1

";

$tipos = "";
$params = [];

if (!empty($_GET['nombre'])) {
    $sql .= " AND (usuarios.nombre LIKE ? OR perfil_usuario.nombre_completo LIKE ?)";
    $tipos .= "ss";
    $params[] = '%' . $_GET['nombre'] . '%';
    $params[] = '%' . $_GET['nombre'] . '%';
}

if (!empty($_GET['correo'])) {
    $sql .= " AND usuarios.correo LIKE ?";
    $tipos .= "s";
    $params[] = '%' . $_GET['correo'] . '%';
}

$sql .= " ORDER BY usuarios.id DESC";

$stmt = $conn->prepare($sql);

if (!empty($tipos)) {
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$resultado = $stmt->get_result();

?>



<!DOCTYPE html>

<html lang="es">


<head>


<meta charset="UTF-8">


<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Usuarios | Administración</title>



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


<a href="../postulaciones/listar_postulaciones.php">

📄 Postulaciones

</a>


<a href="listar_usuarios.php">

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



<div class="d-flex justify-content-between mb-4">


<h2>

Usuarios registrados

</h2>


</div>


<div class="card shadow-sm mb-4">

    <div class="card-body">

        <form action="listar_usuarios.php" method="GET">

            <div class="row g-3">

                <div class="col-lg-4">

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        placeholder="Buscar por nombre"
                        value="<?php echo htmlspecialchars($_GET['nombre'] ?? ''); ?>">

                </div>

                <div class="col-lg-3">

                    <input
                        type="text"
                        name="correo"
                        class="form-control"
                        placeholder="Buscar por correo"
                        value="<?php echo htmlspecialchars($_GET['correo'] ?? ''); ?>">

                </div>

                <div class="col-lg-1">

                    <button
                        type="submit"
                        class="btn btn-danger w-100">

                        🔍

                    </button>

                </div>

                <div class="col-lg-1">

                    <a
                        href="listar_usuarios.php"
                        class="btn btn-secondary w-100">

                        🗑

                    </a>
            </div>
        </div>
        </form>

    </div>

</div>


<div class="card shadow">


<div class="card-body">



<div class="table-responsive">



<table class="table table-hover align-middle">



<thead class="table-danger">


<tr>


<th>

Foto

</th>


<th>

Nombre

</th>


<th>

Correo

</th>


<th>

Profesión

</th>


<th>

Acciones

</th>


</tr>


</thead>




<tbody>


<?php


if($resultado->num_rows > 0){


while($usuario=$resultado->fetch_assoc()){


?>


<tr>



<td>


<?php


if(!empty($usuario["foto"])){

?>


<img

src="../../<?php echo $usuario["foto"]; ?>"

class="usuario-foto">


<?php


}else{


?>


<img

src="https://via.placeholder.com/60"

class="usuario-foto">


<?php


}


?>


</td>




<td>


<?php


echo $usuario["nombre_completo"] 
?? 
$usuario["nombre"];


?>


</td>




<td>


<?php echo $usuario["correo"]; ?>


</td>



<td>


<?php


echo $usuario["profesion"]

??

"Sin especificar";


?>


</td>



<td>


<a

href="ver_perfil.php?id=<?php echo $usuario["id"]; ?>"

class="btn btn-danger btn-sm">


Ver Perfil


</a>


</td>



</tr>



<?php


}


}else{


?>


<tr>


<td colspan="5"
class="text-center">


No hay usuarios registrados.


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