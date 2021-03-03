function DeleteFunction(id) {

    if (confirm("¿Está seguro que desea eliminar?")) {
        window.location.href="http://localhost/SistemaDeAyudas/public/index.php/eliminarContactos/"+id+"";
    } else {
        window.location.href="http://localhost/SistemaDeAyudas/public/index.php/verContactos";
    }
   
}