var texto = document.querySelector("#minimoCaracter")
var motivoContacto = document.querySelector("#formulario_contacto_motivo_contacto");
motivoContacto.addEventListener('keydown', function(){
    if(motivoContacto.value.length > 30){
        texto.style.display = "none";
    }
    else{
        texto.style.display = "block";
    }
});
