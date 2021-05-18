<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PerfilSolicitante;
use App\Form\PerfilSolicitanteType;
use App\Entity\CategoriaPrincipal;
use App\Entity\UserBusqueda;
use App\Form\UserBusquedaType;


//Controller general para un CRUD
class PerfilSolicitanteController extends AbstractController
{
    /**
     * @Route("/admin/altaPerfiles", name="altaPerfiles")
     */
    public function AltaPerfiles(Request $request)
    {
        $perfiles = new PerfilSolicitante();
    
        $formulario = $this -> createForm(PerfilSolicitanteType::class, $perfiles);
        $formulario -> handleRequest($request); 
  
        
        $fecha = $perfiles -> getFechaPublicacionDesde();
        $fechaHasta = $perfiles -> getFechaPublicacionHasta();
        
         //Comparo que sea menor igual y no solo igual porque al poner solo igual, limitas a una exactitud muy dificil ademas
         //de que tiene en cuenta las horas, y como la fecha que
        //uno ingresa siempre va a ser menor a la actual al termino de horas
         //se hace con menor igual. 
         //Porque por mas que ambas sean iguales, la ingresada en el form por tema de horas es menor, entonces la incluye como publicado
         
   
        if($fecha <= $this -> getFechActual()){
            $perfiles -> setPublicado("Publicado");
         }
        else{
            $perfiles -> setPublicado("Despublicado");
        }
         
      
        
        if($formulario -> isSubmitted() && $formulario -> isValid() && $this -> getAnioValido($fecha) && $this -> getAnioValidoHasta($fechaHasta) && $this -> validarTamanioImagen($perfiles -> getIcono())){
            $em = $this -> getDoctrine() -> getManager();

           
            //Para cargar de nuevo en perfiles los datos del form.
            $perfiles = $formulario->getData();


            if ($perfiles->getIcono()!=null){

                $imagen = $formulario->get('icono')->getData();
            
                $extensionArchivo=$imagen->guessExtension();
                
                if ($extensionArchivo == 'ico' || $extensionArchivo == 'png'){

                    $nombreArchivo= time().".".$extensionArchivo;
                        
                    $imagen->move("uploads/iconos/",$nombreArchivo);

                    $perfiles->setIcono($nombreArchivo);    

                }else{
                    $this -> addFlash('error', 'Sólo se pueden cargar extensiones .ico o .png');
                    return $this->render('perfil_solicitante/altaPerfiles.html.twig', [
                        'formulario' => $formulario->createView()
                    ]);
                }

            }

            $em -> persist($perfiles);
            $em -> flush();

            $this -> addFlash('info', '¡El perfil se cargó correctamente!');
            return $this->redirectToRoute('verPerfiles');
        }
    
        return $this->render('perfil_solicitante/altaPerfiles.html.twig', [
            'formulario' => $formulario->createView(),
            
        ]);
    }

    


      /**
     * @Route("/admin/verPerfiles", name="verPerfiles")
     */
    public function VerPerfiles(Request $request){
        $em = $this -> getDoctrine() -> getManager();

        $form = $this -> createForm(UserBusquedaType::class, new UserBusqueda());
        $form -> handleRequest($request);
        $busqueda = $form -> getData();

        // $perfiles = $em -> getRepository(PerfilSolicitante::class) -> findAll();
        //Los acomoda por nombre
        // $perfiles= $em->getRepository(PerfilSolicitante::class)->findBy(array(), array('descripcion_corta' => 'ASC'));
        // $perfiles= $em->getRepository(PerfilSolicitante::class)->findBy(array(), array('id' => 'DESC'));
        $perfiles = $this -> obtenerPerfiles();
   
        if($form -> isSubmitted()){
            return $this -> render('perfil_solicitante/verPerfiles.html.twig', [
                'perfil' => $this -> buscarPerfil($busqueda), 'formulario' => $form -> createView()
                ]);
        }
        else{
            return $this -> render('perfil_solicitante/verPerfiles.html.twig', [
                'perfil' => $perfiles, 'formulario' => $form -> createView()
                ]);
        }
        
    }

    public function buscarPerfil(UserBusqueda $busqueda){
        $manager=$this->getDoctrine()->getManager();
        
        $query = $manager->createQuery(
        "SELECT p
        FROM App\Entity\PerfilSolicitante p
        WHERE p.descripcion_corta LIKE :descripcion_corta
        ORDER BY p.id ASC
        "
        )->setParameter('descripcion_corta','%'. $busqueda->getBuscar().'%');
        //Es para que busque en la cadena completa un string, ignorando la posición en donde esté
        
        //Límite de resultados..
        $query->setMaxResults(100);
        
        //Retorna busqueda de la compra..
        return $query->getResult();
    }

    public function obtenerPerfiles(){
        $manager=$this->getDoctrine()->getManager();
        
        $query = $manager->createQuery(
        "SELECT p
        FROM App\Entity\PerfilSolicitante p
        WHERE p.id != '1' 
        ORDER BY p.id ASC
        "
        );
        
        
        $query->setMaxResults(100);
        
        
        return $query->getResult();
    }




    /**
     * @Route("/admin/modificarPerfiles/{id}", name="modificarPerfiles")
     */
    public function ModificarPerfiles(Request $request, $id){
        $em = $this -> getDoctrine() -> getManager();
        $perfiles = $em -> getRepository(PerfilSolicitante::class) -> find($id);

        //Obtengo la dirección del ícono sin actualizar.
        $urlIcono = $perfiles->getIcono();
       

        $formulario = $this -> createForm(PerfilSolicitanteType::class, $perfiles);
        $formulario -> handleRequest($request);

        $fecha = $perfiles -> getFechaPublicacionDesde();
        $fechaHasta = $perfiles -> getFechaPublicacionHasta();


        //Lo publica o despublica dependiendo la comparacion entre fechas
        if($fecha <= $this -> getFechActual()){
            $perfiles -> setPublicado("Publicado");
         }
        else{
            $perfiles -> setPublicado("Despublicado");
        }


        if($formulario -> isSubmitted() && $formulario -> isValid()  && $this -> getAnioValido($fecha) && $this -> getAnioValidoHasta($fechaHasta) && $this -> validarTamanioImagen($perfiles -> getIcono())){

            $perfiles = $formulario->getData();

            if ($perfiles->getIcono()!=null){

                $imagen = $formulario->get('icono')->getData();
            
                $extensionArchivo=$imagen->guessExtension();
                
                if ($extensionArchivo == 'ico' || $extensionArchivo == 'png'){
                    $nombreArchivo= time().".".$extensionArchivo;
                        
                    $imagen->move("uploads/iconos/",$nombreArchivo);

                    $perfiles->setIcono($nombreArchivo);
                    
                }else{
                    $this -> addFlash('error', 'Sólo se pueden cargar extensiones .ico o .png');
                    return $this->render('perfil_solicitante/modificarPerfiles.html.twig', [
                        'formulario' => $formulario->createView(),
                        'imagen' => $perfiles -> getIcono()
                    ]);
                }

            }else{
                //Si no se carga nada, cargo de nuevo el mismo icono que estaba antes.
                $perfiles->setIcono($urlIcono);
            }
      

            $this -> addFlash('info', '¡El perfil se modificó correctamente!');

            $em -> persist($perfiles);
            $em -> flush();

          
            return $this -> redirectToRoute('verPerfiles');
        }
        
        return $this->render('perfil_solicitante/modificarPerfiles.html.twig', [
            'formulario' => $formulario->createView(),
            'imagen' => $perfiles -> getIcono()
        ]);
    }

    /**
     * @Route("/admin/eliminarPerfiles/{id}", name="eliminarPerfiles")
     */
    public function EliminarPerfiles($id){
        $em = $this -> getDoctrine() -> getManager();

        $perfiles = $em ->getRepository(PerfilSolicitante::class) -> find($id);

        $em -> remove($perfiles);
        $em -> flush();

        $this -> addFlash('info', '¡El perfil se eliminó correctamente!');
        return $this -> redirectToRoute('verPerfiles');
    }



    //Asignacion de categorias principales a los perfiles
    /**
     * @Route("/admin/asignarCategorias/{id}", name="asignarCategorias")
     */
    public function AsignarCategorias($id){

        $em = $this -> getDoctrine() -> getManager();
        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($id);
        $categoriasPerfil = $perfil -> getIdCategoriaPrincipal();

        //Arriba asigno una categoria a un perfil y aca muestro las demas categorias restantes.
        // $categoriasResto = $em -> getRepository(CategoriaPrincipal::class) -> findAll();

        //Ordena alfabeticamente pero solo las categorias restantes las agregadas ordenarlas con SORT en twig
        $categoriasResto= $em->getRepository(CategoriaPrincipal::class)->findBy(array(), array('nombre_categoria' => 'ASC'));

        return $this -> render('perfil_solicitante/asignarCategoria.html.twig', [
            "categoriasPerfil" => $categoriasPerfil,
            "categoriasResto" => $categoriasResto,
            "perfil" => $perfil 
        ]);
    }


     /**
     * @Route("/admin/agregarCategoriaPerfil/{id}/{id2}", name="agregarCategoriaPerfil")
     */
    public function AgregarCategoriaPerfil($id, $id2){
        $em = $this -> getDoctrine() -> getManager();
        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($id2);
        $categoria = $em -> getRepository(CategoriaPrincipal::class) -> find($id);

        $perfil -> addIdCategoriaPrincipal($categoria);

        $em -> persist($perfil);
        $em -> flush();

        $this -> addFlash('info', '¡Categoría asignada correctamente!');
        return $this -> AsignarCategorias($id2);
    }

    /**
     * @Route("/admin/eliminarCategoriaPerfil/{id}/{id2}", name="eliminarCategoriaPerfil")
     */
    public function EliminarCategoriaPerfil($id, $id2){
        $em = $this -> getDoctrine() -> getManager();

        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($id2);
        $categoria = $em -> getRepository(CategoriaPrincipal::class) -> find($id);

        $perfil -> removeIdCategoriaPrincipal($categoria);
        $em -> flush();

        $this -> addFlash('info', '¡La categoría asignada se eliminó correctamente!');
        return $this -> AsignarCategorias($id2);
    }
    
    public function getFechActual(){
        
        $fechaActual=  new \DateTime();
                
        return $fechaActual;
        
    }

    public function getAnioValido($fecha){
        $anio = $fecha->format('Y');
        if($anio < 2020 || $anio > 2060){
            $this -> addFlash('error', 'Sólo se permiten años entre 2021 y 2060');
            return false;
        }
        else{
            return true;
        }
        
    }  
    
    public function getAnioValidoHasta($fechaHasta){
        if($fechaHasta != null){
            $anio = $fechaHasta->format('Y');
            if($anio < 2021 || $anio > 2060){
                $this -> addFlash('error', 'Sólo se permiten años entre 2021 y 2060');
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }

    public function validarTamanioImagen($imagen){
        //Se valida si la imágen/icono es 30x30px
        if($imagen != null){
            $imagen = getimagesize($imagen);

            $ancho = $imagen[0];
            $alto = $imagen[1]; 
    
            if ($ancho == 30 && $alto == 30 ){
                return true;
            }else{
                $this -> addFlash('error', 'El tamaño de la imagen debe ser de 30x30');
                return false;
            }
        }
        else{
            return true;
        }
    }
    


}
