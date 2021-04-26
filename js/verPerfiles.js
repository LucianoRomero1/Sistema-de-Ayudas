function DeleteFunction(id) {

    if (confirm("¿Está seguro que desea eliminar?")) {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/eliminarPerfiles/"+id+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/verPerfiles";
    }
   
}



