let em;
let nombre;
let ape;
let edad;
let desc;
let p;
let com;
let formulario;
let boton;

window.addEventListener('load',function(){
    boton=document.getElementById('btnRegistrar');
    em=document.getElementById('correo');
    nombre=document.getElementById('nombre');
    ape=document.getElementById('apellidos');
    edad=document.getElementById('edad');
    desc=document.getElementById('desc');
    p=document.getElementById('contra');
    com=document.getElementById('Concontra');
    formulario=document.getElementById('formulario');

   boton.addEventListener('click',enviar,false);
   p.addEventListener('input',validaContra,false);
   com.addEventListener('input',verificar,false);
   nombre.addEventListener('input',validaNombre,false);
   ape.addEventListener('input',validaApellido,false);
   em.addEventListener('input',validaCorreo,false);
   edad.addEventListener('input',validaEdad,false);
   desc.addEventListener('input',validaDescripcion,false);
});

function enviar(e){
    if(validaCorreo()&&validaNombre()&&validaApellido()&&validaEdad()&&validaDescripcion()&&validaContra()&&verificar()&&validaFotoPerfil()){
        formulario.submit();
    }else{
        e.preventDefault();
    }
}

function validaCorreo(){
    posError=document.querySelector("#correo+span.error");
    icon=document.getElementById('iconoUsuario');
    if(em.checkValidity()){
       posError.innerHTML="";
       posError.className="error";
       icon.classList.remove('iconError');
       em.style.borderColor="green";
       em.style.color="green";
       icon.classList.add('iconAcierto');
       return true;
    }else{
        if(em.validity.valueMissing){
            muestraerror(em,posError,"Ingresa Correo");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        em.style.borderColor="red";
        em.style.color="red";
        return false;
    }
}

function validaNombre(){
    posError=document.querySelector("#nombre+span.error");
    icon=document.getElementById('iconoNombre');
    if(nombre.checkValidity()){
        posError.innerHTML="";
        posError.className="error";
        icon.classList.remove('iconError');
        nombre.style.borderColor="green";
        nombre.style.color="green";
        icon.classList.add('iconAcierto');
        return true;
    }else{
        if(nombre.validity.valueMissing){
            muestraerror(nombre,posError,"Ingresar Nombre del Usuario");
        }
        if(nombre.validity.patternMismatch){
            muestraerror(nombre,posError,"Solo Valores Alfabeticos");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        nombre.style.borderColor="red";
        nombre.style.color="red";
        return false;
    }
}

function validaApellido(){
    posError=document.querySelector("#apellidos+span.error");
    icon=document.getElementById('iconoApe');
    if(ape.checkValidity()){
        posError.innerHTML="";
        posError.className="error";
        icon.classList.remove('iconError');
        ape.style.borderColor="green";
        ape.style.color="green";
        icon.classList.add('iconAcierto');
        return true;
    }else{
        if(ape.validity.valueMissing){
            muestraerror(ape,posError,"Ingresar Apellidos");
        }
        if(ape.validity.patternMismatch){
            muestraerror(ape,posError,"Solo Valores Alfabeticos (Sin espacios)");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        ape.style.borderColor="red";
        ape.style.color="red";
        return false;
    }
}

function validaEdad(){
    posError=document.querySelector("#edad+span.error");
    posIcon=document.getElementById('iconoEdad');
    if(edad.checkValidity()){
        posError.innerHTML="";
        posError.className="error";
        icon.classList.remove('iconError');
        edad.style.borderColor="green";
        edad.style.color="green";
        icon.classList.add('iconAcierto');
        return true;
    }else{
        if(edad.validity.valueMissing){
            muestraerror(edad,posError,"Ingresa la edad");
        }
        if(edad.validity.rangeUnderflow){
            muestraerror(edad,posError,"la edad no acepta negativo o menos de 13");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        edad.style.borderColor="red";
        edad.style.color="red";
        return false;
    }
}

function validaDescripcion(){
    posError=document.querySelector("#desc+span.error");
    icon=document.getElementById('iconoDesc');
    if(desc.checkValidity()){
        posError.innerHTML="";
        posError.className="error";
        icon.classList.remove('iconError');
        desc.style.borderColor="green";
        desc.style.color="green";
        icon.classList.add('iconAcierto');
        return true;
    }else{
        if(desc.validity.valueMissing){
            muestraerror(desc,posError,"Ingresar la descripción");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        desc.style.borderColor="red";
        desc.style.color="red";
        return false;
    }
}

function validaContra(){
    posError=document.querySelector("#contra+span.error");
    icon=document.getElementById('iconoPassword');
    if(p.checkValidity()){
        posError.innerHTML="";
        posError.className="error";
        icon.classList.remove('iconError');
        p.style.borderColor="green";
        p.style.color="green";
        icon.classList.add('iconAcierto');
        return true;
    }else{
        if(p.validity.valueMissing){
            muestraerror(p,posError,"Ingresa la Contraseña");
        }
        if(p.value.length<p.minLength){
            muestraerror(p,posError,"Minimo 8 Caracteres");
        }
        if(p.validity.patternMismatch){
            muestraerror(p,posError," MInimo=>(1 mayuscula,1 Minuscula,1 caracter no alfabetico,1 número)");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError'); 
        p.style.borderColor="red";
        p.style.color="red";
        return false;
    }
} 

function verificar(){
    posError=document.querySelector("#Concontra+span.error");
    icon=document.getElementById('iconoPassword2');
    if (!posError) {
        console.error("No se encontró el span de error para confirmaContra.");
        return false;
    }
    if (com.checkValidity() && com.value == p.value) {
        posError.innerHTML = "";
        posError.className = "error";
        icon.classList.remove('iconError');
        com.style.borderColor = "green";
        com.style.color = "green";
        icon.classList.add('iconAcierto');
        return true;
    } else {
         if (com.validity.valueMissing) {
            muestraerror(com, posError, "Confirma tu contraseña");
        } else if (com.value !== p.value) {
            muestraerror(com, posError, "Las contraseñas no coinciden");
        } else {
            muestramuestraerrorError(com, posError, "Contraseña inválida");
        }
        icon.classList.remove('iconAcierto');
        icon.classList.add('iconError');
        com.style.borderColor = "red";
        com.style.color = "red";
        return false;
    }
}

function muestraerror(elemento,posicion,mensaje){
    posicion.textContent=mensaje;
    elemento.focus();
}