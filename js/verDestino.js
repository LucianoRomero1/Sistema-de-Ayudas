function DeleteFunction(id) {
   
    if (confirm("¡Atencion! ¡Se eliminará este destino y la categoría principal que tenga asociada! ¿Está seguro que desea eliminar?")) {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/eliminarDestino/"+id+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/verDestino";
    }
  
}