function DeleteFunction(id) {
   
    if (confirm("¡Atencion! ¡Se eliminará el usuario seleccionado !¿Está seguro/a que desea eliminar?")) {
        window.location.href="https://intranet.unraf.edu.ar/RegistroDigital/superadmin/eliminarUser/"+id+"";
    }
  
}