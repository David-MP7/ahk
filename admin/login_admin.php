<?php

session_start();

if(isset($_SESSION["admin"])){

    header("Location: dashboard.php");

    exit;

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Administrador | AHK Uruguay</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="css/admin.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">

<div class="container">

<a class="navbar-brand d-flex align-items-center" 
href="../index.html">

<img src="../assets/img/logo.png"
width="55"
height="55"
class="me-2">

AHK Uruguay

</a>


<button class="navbar-toggler"
data-bs-toggle="collapse"
data-bs-target="#menu">

<span class="navbar-toggler-icon"></span>

</button>


<div class="collapse navbar-collapse"
id="menu">


<ul class="navbar-nav ms-auto">


<li class="nav-item">

<a class="nav-link active"
href="../index.html">

Inicio

</a>

</li>



<li class="nav-item">

<a class="nav-link"
href="../conocermas.html">

Conocer mas

</a>

</li>



<li class="nav-item">

<a class="nav-link"
href="">

Contacto

</a>

</li>

</li>


</ul>


</div>


</div>

</nav>


<div class="container login-container">

<div class="card">
    <div class="card-header">
                Panel de Administrador
    </div>


<?php

if(isset($_GET["error"])){

?>

<div class="alert alert-danger">

Usuario o contraseña incorrectos.

</div>

<?php

}

?>

<form action="validar_login.php" method="POST">
    <div class="mb-3">
        <label class="form-label">
  Usuario:
</label>

<input
type="text"
name="usuario"
class="form-control"
required>
</div>

<div class="mb-4">
    <label class="form-label">
  Contraseña:
</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>
<button class="btn btn-danger w-100">

Ingresar

</button>

</form>

</div>

</div>

</body>

</html>