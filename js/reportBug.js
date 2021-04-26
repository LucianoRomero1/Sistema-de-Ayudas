function envioMail(){
    var mensaje= document.getElementById("inputMensaje");
    var avisoRojo =document.getElementById("avisoMensaje");
  
    if (mensaje.value.length == 0 ){
      avisoRojo.innerHTML="No se permiten descripciones vacías.";
    }else{
      avisoRojo.style.color="#0F9FA8";
      avisoRojo.innerHTML="Enviando..";
      location.href ="http://intranet.unraf.edu.ar/FAQS/user/email/" + mensaje.value;
    }
    
  }