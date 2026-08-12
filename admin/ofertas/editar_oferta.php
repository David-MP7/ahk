<?php

session_start();

require_once "../../backend/config/database.php";

if (!isset($_SESSION["admin"])) {

    header("Location: ../login_admin.php");
    exit;

}

if (!isset($_GET["id"])) {

    header("Location: listar_ofertas.php");
    exit;

}

$conn = conectar();

$id = intval($_GET["id"]);

$sql = "SELECT * FROM ofertas_laborales WHERE id=?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    header("Location: listar_ofertas.php");
    exit;

}

$oferta = $resultado->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Oferta</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../css/admin.css">

</head>

<body>

<div class="d-flex">

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">

<img src="../../images/logo.png" width="80">

<h4 class="mt-3">AHK Uruguay</h4>

</div>

<hr>

<a href="../dashboard.php">🏠 Dashboard</a>

<a href="listar_ofertas.php">💼 Gestionar Ofertas</a>

<a href="../postulaciones/listar_postulaciones.php">📄 Postulaciones</a>

<a href="../usuarios/listar_usuarios.php">👤 Usuarios</a>

<a href="../logout.php">🚪 Cerrar sesión</a>

</div>

<!-- CONTENIDO -->

<div class="contenido">

<div class="card shadow">

<div class="card-header bg-danger text-white">

<h3>Editar Oferta Laboral</h3>

</div>

<div class="card-body">

<?php

if(isset($_GET["error"])){

?>

<div class="alert alert-danger">

Debe completar todos los campos.

</div>

<?php

}

?>

<form action="actualizar_oferta.php" method="POST">

<input
type="hidden"
name="id"
value="<?php echo $oferta["id"]; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Título</label>

<input
type="text"
name="titulo"
class="form-control"
value="<?php echo htmlspecialchars($oferta["titulo"]); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Empresa</label>

<input
type="text"
name="empresa"
class="form-control"
value="<?php echo htmlspecialchars($oferta["empresa"]); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Ubicación</label>

<input
type="text"
name="ubicacion"
class="form-control"
value="<?php echo htmlspecialchars($oferta["ubicacion"]); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Modalidad</label>

<select
name="modalidad"
class="form-select"
required>

<option value="Presencial" <?php if($oferta["modalidad"]=="Presencial") echo "selected"; ?>>Presencial</option>

<option value="Remoto" <?php if($oferta["modalidad"]=="Remoto") echo "selected"; ?>>Remoto</option>

<option value="Híbrido" <?php if($oferta["modalidad"]=="Híbrido") echo "selected"; ?>>Híbrido</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Salario</label>

<input
type="text"
name="salario"
class="form-control"
value="<?php echo htmlspecialchars($oferta["salario"]); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Fecha de publicación</label>

<input
type="date"
name="fecha_publicacion"
class="form-control"
value="<?php echo $oferta["fecha_publicacion"]; ?>"
required>

</div>

<div class="col-12 mb-3">

<label class="form-label">Descripción</label>

<textarea
name="descripcion"
rows="6"
class="form-control"
required><?php echo htmlspecialchars($oferta["descripcion"]); ?></textarea>

</div>

<div class="col-12 mb-4">

<label class="form-label">Requisitos</label>

<textarea
name="requisitos"
rows="6"
class="form-control"
required><?php echo htmlspecialchars($oferta["requisitos"]); ?></textarea>

</div>

</div>

<div class="text-end">

<a
href="listar_ofertas.php"
class="btn btn-secondary">

Cancelar

</a>

<button
type="submit"
class="btn btn-danger">

Actualizar Oferta

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