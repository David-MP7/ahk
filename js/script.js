let datosUsuarios=[];

document.addEventListener('DOMContentLoaded', mostrar_datos);

function guardar_usuario() {
    let nombre=document.getElementById("nombre").value;
    let apellido=document.getElementById("apellido").value;
    let telefono=document.getElementById("telefono").value;
    let correo=document.getElementById("correo").value;
    let contraseña=document.getElementById("contraseña").value;
    let url="backend/index.php?action=agregar_usuario&nombre="+nombre+"&apellido="+apellido+"&telefono="+telefono+"&correo="+correo+"&contraseña="+contraseña;
    fetch(url)
   .then(responde=>responde . json()) //true o false
   .then(data=> {
    
     mostrar_datos();
   })
    
}
function mostrar_datos() {
    let url="backend/index.php?action=usuarios";
    // capturar resultado
    let resultDiv=document.getElementById("resultado"); 
    // map = recorre
    let html="";
 fetch(url)
   .then(responde=>responde . json())
   .then(data=> {
    console.log(data);
    datosUsuarios=data;
     datosUsuarios.map((usuario)=>{ // funcion flecha
        html +=`
        <li>
        nombre:${usuario.nombre}
        apellido:${usuario.apellido}
        telefono:${usuario.telefono}
        correo:${usuario.correo}
        contraseña:${usuario.contraseña}
        </li>`;
    });
      resultDiv.innerHTML=html;
   })
   
  
}
// el . y + concatena
//push = agrega