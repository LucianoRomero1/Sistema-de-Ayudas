<?php

namespace App\Controller;

use App\Entity\CategoriaPrincipal;
use App\Form\CategoriaPrincipalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserBusqueda;
use App\Form\UserBusquedaType;
use App\Repository\CategoriaPrincipalRepository;

//Controller general para un CRUD.


class CategoriaPrincipalController extends AbstractController
{
    /**
     * @Route("/admin/altaCategorias", name="altaCategorias")
     */
    public function AltaCategorias(Request $request, CategoriaPrincipalRepository $catRepo)
    {
        $categoriaPP = new CategoriaPrincipal(); //Constructor

        //Crear formulario, dos parametros, el FORM y la var recien creada
        $formulario = $this -> createForm(CategoriaPrincipalType::class, $categoriaPP);
        //Para procesar los datos del formulario
        $formulario -> handleRequest($request);

      
        $fechaHasta = $categoriaPP -> getFechaPublicacionHasta();
        $fecha = $categoriaPP -> getFechaPublicacionDesde();

    
        if($fecha <= $this -> getFechActual()){
            $categoriaPP -> setPublicado("Publicado");
        }
        else{
            $categoriaPP -> setPublicado("Despublicado");
        }

        if($formulario -> isSubmitted() && $formulario->isValid() && $this -> getAnioValido($fecha) && $this -> getAnioValidoHasta($fechaHasta) && $this -> validarTamanioImagen($categoriaPP-> getIcono())){
            //Se crea el entity manager para el ABM (Modificar,eliminar,altas,bajas,etc)
            $entityManager = $this -> getDoctrine() -> getManager();

            //Para cargar de nuevo en perfiles los datos del form.
            $categoriaPP = $formulario->getData();
            if ($categoriaPP->getIcono()!=null){

                $imagen = $formulario->get('icono')->getData();
            
                $extensionArchivo=$imagen->guessExtension();
                
                if ($extensionArchivo == 'ico' || $extensionArchivo == 'png'){

                    $nombreArchivo= time().".".$extensionArchivo;
                        
                    $imagen->move("uploads/iconos/",$nombreArchivo);

                    $categoriaPP->setIcono($nombreArchivo);    

                }else{
                    $this -> addFlash('error', 'Sólo se pueden cargar extensiones .ico');
                    return $this->render('categoria_principal/altaCategorias.html.twig', [
                        'formulario' => $formulario->createView()
                    ]);
                }

            }



            $entityManager -> persist($categoriaPP);
            $entityManager -> flush();
            //Lo cargo y redirijo a ver la lista de los agregados
            $this -> addFlash('info', '¡La categoría se ha registrado exitosamente!');
            $this -> addFlash('warning', 'Por favor recuerde asociar esta categoría a un email');
            return $this->redirectToRoute('verCategorias');
        }else{
            return $this->render('categoria_principal/altaCategorias.html.twig', [
                //formulario es el nombre con el que la manejo en el html
                //y va con el formulario creado.
                'formulario' => $formulario -> createView()
            ]);
        }
    }


    /**
     * @Route("/admin/verCategorias", name = "verCategorias")
     */
    public function VerCategorias(Request $request)
    {
        $manager = $this -> getDoctrine() -> getManager();
    

        $form = $this -> createForm(UserBusquedaType::class, new UserBusqueda());
        $form -> handleRequest($request);
        $busqueda = $form -> getData();

        // $categoriaPP = $manager -> getRepository(CategoriaPrincipal::class)-> findAll(); 

        //Los acomoda por nombre 
        // $categoriaPP= $manager->getRepository(CategoriaPrincipal::class)->findBy(array(), array('nombre_categoria' => 'ASC'));
        $categoriaPP= $manager->getRepository(CategoriaPrincipal::class)->findBy(array(), array('id' => 'DESC'));

        if($form -> isSubmitted()){
            return $this -> render('categoria_principal/verCategorias.html.twig', [
                'categoria' => $this -> buscarCatPP($busqueda), 'formulario' => $form -> createView()
                ]);
        }
        else{
            return $this -> render('categoria_principal/verCategorias.html.twig', [
                'categoria' => $categoriaPP, 'formulario' => $form -> createView()
            ]);
        }
     
    }

    public function buscarCatPP(UserBusqueda $busqueda){
        $manager=$this->getDoctrine()->getManager();
        
        $query = $manager->createQuery(
        "SELECT c
        FROM App\Entity\CategoriaPrincipal c
        WHERE c.nombre_categoria LIKE :nombre_categoria
        ORDER BY c.id ASC
        "
        )->setParameter('nombre_categoria','%'. $busqueda->getBuscar().'%');
        
        
        //Límite de resultados..
        $query->setMaxResults(100);
        
        //Retorna busqueda de la compra..
        return $query->getResult();
    }


    /**
     * @Route("/admin/modificarCategoria/{id}", name = "modificarCategoria")
     */
    public function ModificarCategorias(Request $request, $id){
        $manager = $this -> getDoctrine() -> getManager();
        $categoriaPP = $manager -> getRepository(CategoriaPrincipal::class) -> find($id);

        $urlIcono = $categoriaPP->getIcono();

        $formulario = $this -> createForm(CategoriaPrincipalType::class, $categoriaPP);
        $formulario -> handleRequest($request);

        
        $fecha = $categoriaPP -> getFechaPublicacionDesde();
        $fechaHasta = $categoriaPP -> getFechaPublicacionHasta();

      
        if($fecha <= $this -> getFechActual()){
            $categoriaPP -> setPublicado("Publicado");
         }
        else{
            $categoriaPP -> setPublicado("Despublicado");
        }

        if($formulario -> isSubmitted() && $formulario -> isValid() && $this -> getAnioValido($fecha) && $this -> getAnioValidoHasta($fechaHasta) && $this -> validarTamanioImagen($categoriaPP -> getIcono())){

            $categoriaPP = $formulario->getData();

            if($categoriaPP -> getIcono() != null){
                $imagen = $formulario->get('icono')->getData();
            
                $extensionArchivo=$imagen->guessExtension();
                if($extensionArchivo == 'ico' || $extensionArchivo == 'png'){
                    $nombreArchivo= time().".".$extensionArchivo;
                        
                    $imagen->move("uploads/iconos/",$nombreArchivo);

                    $categoriaPP->setIcono($nombreArchivo);
                }
                else{
                    $this -> addFlash('error', 'Sólo se pueden cargar extensiones .ico');
                    return $this->render('categoria_principal/modificarCategorias.html.twig', [
                        'formulario' => $formulario->createView(),
                        'imagen' => $categoriaPP -> getIcono()
                    ]);
                }
            }
            else{
                $categoriaPP -> setIcono($urlIcono);
            }


            $this -> addFlash('info', '¡La categoría se modificó correctamente!');
            if($categoriaPP -> getEmailAsignado() == false){
                $this -> addFlash('warning', 'Por favor recuerde asociar esta categoría a un email');
            }
            
            $manager -> persist($categoriaPP);
            $manager -> flush();

            return $this -> redirectToRoute('verCategorias');

        }

        return $this -> render('categoria_principal/modificarCategorias.html.twig', [
            'formulario' => $formulario -> createView(),
            'imagen' => $categoriaPP -> getIcono()
        ]);

    }

     /**
     * @Route("/admin/eliminarCategoria/{id}", name = "eliminarCategoria")
     */
    public function EliminarCategorias($id){
        $manager = $this -> getDoctrine() -> getManager();

        $categoriaPP = $manager -> getRepository(CategoriaPrincipal::class) -> find($id);
        if($categoriaPP -> getCategoriaSecundaria() == null){
            $manager -> remove($categoriaPP);
            $manager -> flush();
          
            return $this->redirectToRoute("verCategorias");
            // Sino hay relacion la elimino nomas
        }
        else{
            // $this -> addFlash('info', '');
            $catSec = $categoriaPP -> getCategoriaSecundaria();

            foreach($catSec as $secundaria){
                
                // $informacion = $secundaria -> getInformacion();
                // $destino = $secundaria -> getDestinos();

                // foreach($informacion as $info){
                //     $manager ->remove($info);
                // }
                // foreach($destino as $dest){
                //     $manager ->remove($dest);
                // }
                //Esto se utilizaria en caso de no tener el cascade remove en la categoria secundaria
                //Ese cascade remove sirve para borrar en cascada todo lo asociado si esta se borra

                $manager ->remove($secundaria); 
                $manager->flush();
            }
            $manager -> remove($categoriaPP);
            $manager -> flush();

            
            $this -> addFlash('info', '¡La categoría se eliminó correctamente!');
            //Se hacen los foreach para recorrer todos ya que es una relacion de uno a muchos tiene que corroborar si hay mas de 1.
            return $this->redirectToRoute("verCategorias");
        }

    }


    public function getFechActual(){
        $fechaActual=  new \DateTime();
                
        return $fechaActual;
    }

    public function getAnioValido($fecha){
        $anio = $fecha->format('Y');
        if($anio <= 2020 || $anio >= 2060){
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
            if($anio <= 2020 || $anio >= 2060){
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
