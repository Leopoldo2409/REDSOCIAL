let correo;
let nom;
let apellidos;
let edad;
let desc;
let contra;
let formulario;

window.addEventListener('load',function(){
    formulario=document.getElementById('formulario');
    boton=document.getElementById('btnRegistrar');
    correo=document.getElementById('correo');

    boton.addEventListener('click',enviar,false);
    correo.addEventListener('input',validaCorreo,false);
});

function enviar(e){
    if(validaCorreo()){
        formulario.submit();
    }else{
        e.preventDefault();
    }
}

function validaCorreo(){
    posError=document.querySelector("correo+span.error");
    icon=document.getElementById('iconoUsuario');
    if(correo.checkValidity()){
       posError.innerHTML="";
       posError.className="error";
       icon.classList.remove('iconError');
       correo.style.borderColor="green";
       correo.style.color="green";
       icon.classList.add('iconAcierto');
       return true;
    }else{
        if(correo.validity.valueMissing){
            muestraerror(correo,posError,"Ingresa un correo");
        }
        if(correo.validity.patternMismatch){
            muestraerror(correo,posError,"Solo minusculas y puntos");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        correo.style.borderColor="red";
        correo.style.color="red";
        return false;
    }
}

function muestraerror(elemento,posicion,mensaje){
    posicion.textContent=mensaje;
    elemento.focus();
}