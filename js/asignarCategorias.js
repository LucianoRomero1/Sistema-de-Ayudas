function DeleteFunction(id, id2) {
    
    if (confirm("Está seguro que desea quitar?")) {
        //txt = id;
        window.location.href="https://intranet.unraf.edu.ar/FAQS/eliminarCategoriaPerfil/"+id+"/"+id2+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/asignarCategoriasPerfil";
    }
  
}

function DeleteFunctionDestino(id, id2) {
    
    if (confirm("Está seguro que desea quitar?")) {
        //txt = id;
        window.location.href="https://intranet.unraf.edu.ar/FAQS/eliminarCategoriaDestino/"+id+"/"+id2+"";
    } else {
        window.location.href="https://intranet.unraf.edu.ar/FAQS/asignarCategoriaDestino";
    }
  
}