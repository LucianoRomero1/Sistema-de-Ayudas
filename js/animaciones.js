$(document).ready(function() {

    
    //Index
        var divInicio = $("#CatPerfilDiv").hide();

        var divInicioR = $("#CatPerfilDivR").hide();

        var listaPerfilesL = $("#ListaPerfiles").hide();
        var listaPerfilesR = $("#ListaPerfilesR").hide();


        divInicio.toggle(500);
        divInicioR.toggle(500);

        listaPerfilesL.toggle(1500);
        listaPerfilesR.toggle(1500);

    //Categoria principal   

        var catPrincipalDiv = $('#tituloCatPrincipal').hide();
        var categoriasPrincipales = $('#nombresCatPrincipal').hide();

        catPrincipalDiv.toggle(500);
        categoriasPrincipales.toggle(1500);

     //Categoria Secundaria   

        var catSecundariaDiv = $('#tituloCatSecundaria').hide();
        var categoriasSecundarias = $('#nombresCatSecundaria').hide();

        catSecundariaDiv.toggle(500);
        categoriasSecundarias.toggle(1500);
    
    //Informacion
        var divInfo = $('#divInfo').hide();

        divInfo.toggle(1200);

    //Formulario Contacto 
        var formContacto = $('#divContacto').hide();

        formContacto.toggle(1000);
});