function DeleteFunction(id) {
   
    if (confirm("¡Atencion! ¡Se eliminará esta categoría y la relación/es asociadas si tiene!¿Está seguro que desea eliminar?")) {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/eliminarCategoriasSecundarias/"+id+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/verCategoriasSecundarias";
    }
  
}