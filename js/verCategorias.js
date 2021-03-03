function DeleteFunction(id) {
  
    if (confirm("¡Atencion! ¡Se eliminará esta categoría y la relación/es asociadas si tiene!¿Está seguro que desea eliminar?")) {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/eliminarCategoria/"+id+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/verCategorias";
    }
   
}

