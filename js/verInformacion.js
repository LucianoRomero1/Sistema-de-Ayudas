function DeleteFunction(id) {

    if (confirm("¿Está seguro/a que desea eliminar?")) {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/editor/eliminarInformacion/"+id+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/editor/verInformacion";
    }
   
}