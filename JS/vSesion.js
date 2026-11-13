let correo;
let contra;
let boton;
let formulario;

window.addEventListener('load',function(){
   correo=document.getElementById('correo');
   contra=document.getElementById('contra');
   boton=document.getElementById('btnIniciarSesion');
   formulario=document.getElementById('formulario');

   boton.addEventListener('click',enviar,false);
   correo.addEventListener('input',validaUsuar,false);
   contra.addEventListener('input',validaContra,false);

});

function enviar(e){
    if(validaUsuar() && validaContra()){
        formulario.submit();
    }else{
        e.preventDefault();
    }
}
function validaUsuar(){
    posError=document.querySelector("#correo+span.error");
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
            muestraerror(correo,posError,"Ingresar Correo");
        }
        if(correo.validity.patternMismatch){
            muestraerror(correo,posError,"Acepta: Minusculas, Puntos y Numeros");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        correo.style.borderColor="red";
        correo.style.color="red";
        return false;
    }
}

function validaContra(){
    posError=document.querySelector("#contra+span.error");
    icon=document.getElementById('iconoPassword');
    if(contra.checkValidity()){
       posError.innerHTML="";
       posError.className="error";
       icon.classList.remove('iconError');
       contra.style.borderColor="green";
       contra.style.color="green";
       icon.classList.add('iconAcierto');
       return true;
    }else{
        if(contra.validity.valueMissing){
            muestraerror(contra,posError,"Deber ingresar la Contraseña");
        }
        if(contra.value.length<contra.minLength){
            muestraerror(contra,posError,"Debe contener minimo 8 Caracteres");
        }
        if(contra.validity.patternMismatch){
            muestraerror(contra,posError,"Debe contener: Mayusculas, minusculas, numeros y caracteres NO numericos");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        contra.style.borderColor="red";
        contra.style.color="red";
        return false;
    }
}

function muestraerror(elemento,posicion,mensaje){
    posicion.textContent=mensaje;
    elemento.focus();
}
