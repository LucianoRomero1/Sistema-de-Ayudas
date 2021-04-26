function DeleteFunction(id, id2) {
    
    if (confirm("Está seguro que desea quitar?")) {
        //txt = id;
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/eliminarCategoriaPerfil/"+id+"/"+id2+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/asignarCategoriasPerfil";
    }
  
}

function DeleteFunctionDestino(id, id2) {
    
    if (confirm("Está seguro que desea quitar?")) {
        //txt = id;
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/eliminarCategoriaDestino/"+id+"/"+id2+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/admin/asignarCategoriaDestino";
    }
  
}