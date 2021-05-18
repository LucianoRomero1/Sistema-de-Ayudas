$( document ).ready(function() {
    
    var divFechaCaducidad= $("#divFechaCaducidad").hide();
    var divPerfilAsociado= $("#divPerfilAsociado").hide();
    var agregarFecha= $("#agregarFecha");
    var agregarPerfil= $("#agregarPerfil");
    



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

    
    if( agregarPerfil.attr('checked') ) {
        divPerfilAsociado.slideToggle(200);
    }
    //Fecha caducidad
    agregarPerfil.on('click', function(e) {
        divPerfilAsociado.slideToggle(200);
    });


    if( agregarOpcionales.attr('checked') ) {
        divOpcionales.slideToggle(200);
    }
    //Fecha caducidad
    agregarOpcionales.on('click', function(e) {
        divOpcionales.slideToggle(200);
    });
});

