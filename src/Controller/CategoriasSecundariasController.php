<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CategoriaSecundaria;
use App\Form\CategoriaSecundariaType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserBusqueda;
use App\Form\UserBusquedaType;

//Controller general para un CRUD
class CategoriasSecundariasController extends AbstractController
{
    /**
     * @Route("/admin/altaCategoriasSecundarias", name="altaCategoriasSecundarias")
     */
    public function AltaCategoriasSecundarias(Request $request)
    {
        $catSecundarias = new CategoriaSecundaria();
        //Pongo fecha inicial por defecto
        $fechaActual = $this -> getFechActual();
        $catSecundarias -> setFechaPublicacionDesde($fechaActual);
        //
        $formulario = $this -> createForm(CategoriaSecundariaType::class, $catSecundarias);
        $formulario -> handleRequest($request);
        
        $fecha = $catSecundarias -> getFechaPublicacionDesde();
        $fechaHasta = $catSecundarias -> getFechaPublicacionHasta();
        
        if($fecha <= $this -> getFechActual()){
            $catSecundarias -> setPublicado("Publicado");
         }
        else{
            $catSecundarias -> setPublicado("Despublicado");
        }

      

        if($formulario -> isSubmitted() && $formulario -> isValid() && $this -> getAnioValido($fecha) && $this -> getAnioValidoHasta($fechaHasta)){
            $em = $this -> getDoctrine() -> getManager();

            if($catSecundarias -> getIdCategoriaPrincipal() != null){
                $catSecundarias -> setInfoAsignada(false);
                $em -> persist($catSecundarias);
                $em -> flush();
                $this -> addFlash('info', 'La categoría secundaria se cargó correctamente!');
                return $this -> redirectToRoute('verCategoriasSecundarias');
               
            }
            else{
                $this -> addFlash('error', '¡Por favor primero cree una categoria principal para poder asociarla en el primer campo!');
            }
           
        }

        return $this -> render('categorias_secundarias/altaCategoriasSecundarias.html.twig', [
            'formulario' => $formulario -> createView()
        ]);
    }

    /**
     * @Route("/admin/verCategoriasSecundarias", name="verCategoriasSecundarias")
     */
    public function VerCategoriasSecundarias(Request $request){
        $em = $this -> getDoctrine() -> getManager();


        $form = $this -> createForm(UserBusquedaType::class, new UserBusqueda());
        $form -> handleRequest($request);
        $busqueda = $form -> getData(); 

        // $catSecundarias = $em -> getRepository(CategoriaSecundaria::class) -> findAll();
        $catSecundarias= $em->getRepository(CategoriaSecundaria::class)->findBy(array(), array('nombre_categoria' => 'ASC'));

        if($form -> isSubmitted()){
            return $this -> render('categorias_secundarias/verCategoriasSecundarias.html.twig', [
                'catSecundarias' => $this -> buscarCatSec($busqueda), 'formulario' => $form -> createView()
                ]);
        }
        else{
            return $this -> render('categorias_secundarias/verCategoriasSecundarias.html.twig', [
                'catSecundarias' => $catSecundarias, 'formulario' => $form -> createView()
            ]);
        }
      

    }  

    public function buscarCatSec(UserBusqueda $busqueda){
        $manager=$this->getDoctrine()->getManager();
        
        $query = $manager->createQuery(
        "SELECT cs
        FROM App\Entity\CategoriaSecundaria cs
        WHERE cs.nombre_categoria LIKE :nombre_categoria
        
        
        ORDER BY cs.id ASC
        "
        )->setParameter('nombre_categoria','%'. $busqueda->getBuscar().'%');
        
        
        
        //Límite de resultados..
        $query->setMaxResults(100);
        
        //Retorna busqueda de la compra..
        return $query->getResult();
    }

    /**
     * @Route("/admin/modificarSecundarias/{id}", name="modificarSecundarias")
     */
    public function modificarSecundarias(Request $request, $id){
        $em = $this -> getDoctrine() -> getManager();
        
        $catSecundarias = $em -> getRepository(CategoriaSecundaria::class) -> find($id);



        $formulario = $this -> createForm(CategoriaSecundariaType::class, $catSecundarias);
        $formulario -> handleRequest($request);

        $fecha = $catSecundarias -> getFechaPublicacionDesde();
        $fechaHasta = $catSecundarias -> getFechaPublicacionHasta();    

        if($fecha <= $this -> getFechActual()){
            $catSecundarias -> setPublicado("Publicado");
         }
        else{
            $catSecundarias -> setPublicado("Despublicado");
        }


        if($formulario -> isSubmitted() && $formulario -> isValid()  && $this -> getAnioValido($fecha) && $this -> getAnioValidoHasta($fechaHasta)){
            $catSecundarias = $formulario->getData();
           


            $this -> addFlash('info', '¡La categoría secundaria se modificó correctamente!');
            $em -> flush();

            return $this -> redirectToRoute('verCategoriasSecundarias');
        }

        return $this -> render('categorias_secundarias/modificarCategoriasSecundarias.html.twig', [
            'formulario' => $formulario -> createView(),
            
        ]);

    }

     /**
     * @Route("/admin/eliminarCategoriasSecundarias/{id}", name="eliminarCategoriasSecundarias")
     */
    public function EliminarCategoriasSecundarias(Request $request, $id){
        $em = $this -> getDoctrine() -> getManager();

        $catSecundarias = $em -> getRepository(CategoriaSecundaria::class) -> find($id);

        $em -> remove($catSecundarias);
        $em -> flush();

        $this -> addFlash('info', '¡La categoría secundaria se eliminó correctamente!');
        return $this -> redirectToRoute('verCategoriasSecundarias');
    }


    //Retorna la fecha actual
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
}
