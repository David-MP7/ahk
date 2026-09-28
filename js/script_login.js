function iniciarSesion(){

    let correo = document.getElementById("correo").value;
    let contrasena = document.getElementById("contrasena").value;

    fetch("./backend/index.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:new URLSearchParams({

            action:"login",

            correo:correo,

            contrasena:contrasena

        })

    })

    .then(response => response.json())

    .then(data=>{

        if(data){

            window.location.href="inicio_sesion.php";

        }else{

            alert("Correo o contraseña incorrectos");

        }

    });

}