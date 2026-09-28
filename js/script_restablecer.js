const parametros = new URLSearchParams(window.location.search);

const token = parametros.get("token");


document.getElementById("formRestablecer")
.addEventListener("submit", function(event) {

    event.preventDefault();


    let nuevaContrasena =
        document.getElementById("nueva_contrasena").value;


    let confirmarContrasena =
        document.getElementById("confirmar_contrasena").value;


    if (nuevaContrasena !== confirmarContrasena) {

        alert("Las contraseñas no coinciden.");

        return;
    }


    if (!token) {

        alert("El enlace de recuperación no es válido.");

        return;
    }


    fetch("./backend/index.php", {

        method: "POST",

        headers: {

            "Content-Type":
            "application/x-www-form-urlencoded"

        },

        body: new URLSearchParams({

            action: "restablecer_contrasena",

            token: token,

            nueva_contrasena: nuevaContrasena

        })

    })

    .then(response => response.json())

    .then(data => {

        if (data.ok) {

            alert(data.mensaje);

            window.location.href = "login.html";

        } else {

            alert(data.mensaje);

        }

    })

    .catch(error => {

        console.error(error);

        alert(
            "Ocurrió un error al cambiar la contraseña."
        );

    });

});