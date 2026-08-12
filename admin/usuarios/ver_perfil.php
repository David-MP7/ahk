<?php

session_start();

require_once "../../backend/config/database.php";


if(!isset($_SESSION["admin"])){

    header("Location: ../login_admin.php");

    exit;

}


if(!isset($_GET["id"])){

    header("Location: listar_usuarios.php");

    exit;

}



$conn = conectar();


$id_usuario = intval($_GET["id"]);



$sql = "

SELECT *

FROM perfil_usuario

WHERE id_usuario=?

";



$stmt = $conn->prepare($sql);


$stmt->bind_param("i",$id_usuario);


$stmt->execute();


$resultado = $stmt->get_result();



if($resultado->num_rows==0){

    echo "El usuario no tiene perfil creado.";

    exit;

}



$perfil = $resultado->fetch_assoc();

$foto_url = '';
if (!empty($perfil['foto'])) {
    $foto_url = strpos($perfil['foto'], 'http') === 0
        ? $perfil['foto']
        : '../../' . ltrim($perfil['foto'], '/');
}

$curriculum_url = '';
if (!empty($perfil['curriculum'])) {
    $curriculum_url = strpos($perfil['curriculum'], 'http') === 0
        ? $perfil['curriculum']
        : '../../' . ltrim($perfil['curriculum'], '/');
}
?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">


<title>Perfil del candidato</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
rel="stylesheet">


<link rel="stylesheet"
href="../css/admin.css">


</head>


<body>


<div class="contenido-perfil">


<div class="card shadow">


<div class="card-header bg-danger text-white">

<h3>

Perfil Profesional

</h3>

</div>



<div class="card-body text-center">



<?php if (!empty($foto_url)) { ?>
<img
src="<?php echo htmlspecialchars($foto_url, ENT_QUOTES, 'UTF-8'); ?>"
class="foto-perfil mb-4">
<?php } else { ?>
<img
src="https://via.placeholder.com/180"
class="foto-perfil mb-4">
<?php } ?>



<h2>
<?php echo htmlspecialchars($perfil["nombre_completo"], ENT_QUOTES, 'UTF-8'); ?>
</h2>

<h5 class="text-muted">
<?php echo htmlspecialchars($perfil["profesion"], ENT_QUOTES, 'UTF-8'); ?>
</h5>



<hr>



<div class="text-start">


<h5>

Carta de presentación

</h5>

<p>
<?php echo nl2br(htmlspecialchars($perfil["presentacion"], ENT_QUOTES, 'UTF-8')); ?>
</p>



<hr>


<h5>

Experiencia laboral

</h5>


<p>
<?php echo nl2br(htmlspecialchars($perfil["experiencia"], ENT_QUOTES, 'UTF-8')); ?>
</p>



<hr>


<h5>

Formación académica

</h5>


<p>
<?php echo nl2br(htmlspecialchars($perfil["estudios"], ENT_QUOTES, 'UTF-8')); ?>
</p>



<hr>


<h5>

Habilidades

</h5>


<p>
<?php echo nl2br(htmlspecialchars($perfil["habilidades"], ENT_QUOTES, 'UTF-8')); ?>
</p>



<hr>


<h5>

Idiomas

</h5>


<p>
<?php echo nl2br(htmlspecialchars($perfil["idiomas"], ENT_QUOTES, 'UTF-8')); ?>
</p>



<hr>


<h5>

Contacto

</h5>


<p>
<?php echo nl2br(htmlspecialchars($perfil["contacto"], ENT_QUOTES, 'UTF-8')); ?>
</p>


</div>



<?php if (!empty($curriculum_url)) { ?>
<a
href="<?php echo htmlspecialchars($curriculum_url, ENT_QUOTES, 'UTF-8'); ?>"
target="_blank"
class="btn btn-danger mt-4">
Ver Curriculum Vitae
</a>
<?php } ?>


<br><br>


<a

href="../postulaciones/listar_postulaciones.php"

class="btn btn-secondary">

Volver

</a>



</div>


</div>


</div>



</body>

</html>