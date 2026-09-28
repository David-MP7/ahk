document.getElementById("formRecuperar").addEventListener("submit", function(event) {

    event.preventDefault();

    let correo = document.getElementById("correo").value;

    fetch("./backend/index.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: new URLSearchParams({

            action: "recuperar_contrasena",

            correo: correo

        })

    })

    .then(response => response.json())

    .then(data => {

        alert(data.mensaje);

    })

    .catch(error => {

        console.error("Error:", error);

        alert("Ocurrió un error al procesar la solicitud.");

    });

});