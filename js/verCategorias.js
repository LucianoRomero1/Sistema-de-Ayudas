function DeleteFunction(id) {
  
    if (confirm("¡Atencion! ¡Se eliminará esta categoría y la/s relación/es asociadas si tiene!¿Está seguro/a que desea eliminar?")) {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/eliminarCategoria/"+id+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/verCategorias";
    }
   
}

