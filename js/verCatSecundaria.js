function DeleteFunction(id) {
   
    if (confirm("¡Atencion! ¡Se eliminará esta categoría y la información asociada si tiene!¿Está seguro que desea eliminar?")) {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/eliminarCategoriasSecundarias/"+id+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/verCategoriasSecundarias";
    }
  
}