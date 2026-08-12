function guardar_usuario() {

   alert("La función se ejecutó");

    let nombre = document.getElementById("nombre").value;
    console.log("script.js cargado correctamente");
    let apellido = document.getElementById("apellido").value;
    let telefono = document.getElementById("telefono").value;
    let correo = document.getElementById("correo").value;
    let contrasena = document.getElementById("contrasena").value;

    const regexNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/;
    const regexTelefono = /^[0-9]{8,15}$/;
    const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!regexCorreo.test(correo.trim())) {
    alert("El correo electrónico no es válido. Debe tener un formato como: usuario@gmail.com");
    document.getElementById("correo").focus();
    return;
}

    if (!regexNombre.test(nombre)) {
        alert("El nombre solo puede contener letras.");
        return;
    }

    if (!regexNombre.test(apellido)) {
        alert("El apellido solo puede contener letras.");
        return;
    }

    if (!regexTelefono.test(telefono)) {
        alert("El teléfono debe contener solo números.");
        return;
    }

    fetch("backend/index.php?action=agregar_usuario", {

        method: "POST",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: new URLSearchParams({
            action: "agregar_usuario",
            nombre: nombre,
            apellido: apellido,
            telefono: telefono,
            correo: correo,
            contrasena: contrasena
        })

    })

    .then(response => response.json())

    .then(data => {

        if(data){

            alert("Usuario registrado correctamente");

            mostrar_datos();

        }else{

            alert("Error al registrar el usuario");

        }

    });

}
function soloLetras(e) {
    const teclasPermitidas = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];

    if (teclasPermitidas.includes(e.key)) return;

    if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]$/.test(e.key)) {
        e.preventDefault();
    }
}

function soloNumeros(e) {
    const teclasPermitidas = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];

    if (teclasPermitidas.includes(e.key)) return;

    if (!/^[0-9]$/.test(e.key)) {
        e.preventDefault();
    }
}