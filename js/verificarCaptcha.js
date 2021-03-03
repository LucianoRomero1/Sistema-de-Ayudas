function enabledSubmit() {
    var response = grecaptcha.getResponse();
    
    if(response.length == 0){
      alert("Captcha no verificado")
    } else {
      alert("Captcha verificado");
      document.getElementById("divEnviar").style.display = "block";
      document.getElementById("textCaptcha").style.display = "none";
    }

  }