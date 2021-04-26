$( document ).ready(function() {
    
    var divFechaCaducidad= $("#divFechaCaducidad").hide();
    var agregarFecha= $("#agregarFecha");
    



    var agregarOpcionales = $("#agregarOpcionales");
    var divOpcionales= $("#divOpcionales").hide();


    //Click check
    if( agregarFecha.attr('checked') ) {
        divFechaCaducidad.slideToggle(200);
    }
    //Fecha caducidad
    agregarFecha.on('click', function(e) {
        divFechaCaducidad.slideToggle(200);
    });

   


    if( agregarOpcionales.attr('checked') ) {
        divOpcionales.slideToggle(200);
    }
    //Fecha caducidad
    agregarOpcionales.on('click', function(e) {
        divOpcionales.slideToggle(200);
    });
});

