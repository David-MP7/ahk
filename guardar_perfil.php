<?php

session_start();

require_once "backend/config/database.php";

if(!isset($_SESSION["id"])){

    header("Location:login.html");

    exit;

}

$conn = conectar();

$id_usuario = $_SESSION["id"];
// ==========================
// DATOS DEL FORMULARIO
// ==========================

$nombre_completo = $_POST["nombre_completo"] ?? "";

$profesion = $_POST["profesion"] ?? "";

$presentacion = $_POST["presentacion"] ?? "";

$experiencia = $_POST["experiencia"] ?? "";

$estudios = $_POST["estudios"] ?? "";

$habilidades = $_POST["habilidades"] ?? "";

$idiomas = $_POST["idiomas"] ?? "";

$contacto = $_POST["contacto"] ?? "";


// ==========================
// SUBIR FOTO
// ==========================

$rutaFoto = "";

if(isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0){

    $nombreFoto = time() . "_" . basename($_FILES["foto"]["name"]);

    $rutaFoto = "uploads/fotos/" . $nombreFoto;

    move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaFoto);

}


// ==========================
// SUBIR CURRICULUM
// ==========================

$rutaCV = "";

if(isset($_FILES["curriculum"]) && $_FILES["curriculum"]["error"] == 0){

    $nombreCV = time() . "_" . basename($_FILES["curriculum"]["name"]);

    $rutaCV = "uploads/curriculum/" . $nombreCV;

    move_uploaded_file($_FILES["curriculum"]["tmp_name"], $rutaCV);

}
// ==========================
// VERIFICAR SI EL PERFIL EXISTE
// ==========================

$sql = "SELECT id FROM perfil_usuario WHERE id_usuario = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


// ==========================
// SI YA EXISTE -> UPDATE
// ==========================

if($resultado->num_rows > 0){

    $sql = "UPDATE perfil_usuario SET

        foto = COALESCE(NULLIF(?, ''), foto),

        nombre_completo = ?,

        profesion = ?,

        presentacion = ?,

        experiencia = ?,

        estudios = ?,

        habilidades = ?,

        idiomas = ?,

        contacto = ?,

        curriculum = COALESCE(NULLIF(?, ''), curriculum)

        WHERE id_usuario = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

    $stmt->bind_param(

        "ssssssssssi",

        $rutaFoto,

        $nombre_completo,

        $profesion,

        $presentacion,

        $experiencia,

        $estudios,

        $habilidades,

        $idiomas,

        $contacto,

        $rutaCV,

        $id_usuario

    );

}


// ==========================
// SI NO EXISTE -> INSERT
// ==========================

else{

    $sql = "INSERT INTO perfil_usuario(

        id_usuario,

        foto,

        nombre_completo,

        profesion,

        presentacion,

        experiencia,

        estudios,

        habilidades,

        idiomas,

        contacto,

        curriculum

    )

    VALUES(

        ?,?,?,?,?,?,?,?,?,?,?

    )";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

    $stmt->bind_param(

        "issssssssss",

        $id_usuario,

        $rutaFoto,

        $nombre_completo,

        $profesion,

        $presentacion,

        $experiencia,

        $estudios,

        $habilidades,

        $idiomas,

        $contacto,

        $rutaCV

    );

}


// ==========================
// EJECUTAR
// ==========================

if($stmt->execute()){

    header("Location: perfil.php?guardado=1");

}else{

    echo "Error al guardar el perfil: " . $stmt->error;

}

$stmt->close();

$conn->close();