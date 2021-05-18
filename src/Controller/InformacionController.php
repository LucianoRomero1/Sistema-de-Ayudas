<?php

namespace App\Controller;

use App\Entity\CategoriaSecundaria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Informacion;
use App\Form\InformacionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserBusqueda;
use App\Form\UserBusquedaType;

class InformacionController extends AbstractController
{
    /**
     * @Route("/editor/altaInformacion", name="altaInformacion")
     */
    public function AltaInformacion(Request $request)
    {
        $informacion = new Informacion();

        $formulario = $this -> createForm(InformacionType::class, $informacion);
        $formulario -> handleRequest($request);

        

        if($formulario -> isSubmitted() && $formulario -> isValid() && $this -> validarInformacion($informacion)){ 
            $em = $this -> getDoctrine() -> getManager();
            if($informacion -> getIdCategoriaSecundaria() != null){
                $catSecundaria = $informacion -> getIdCategoriaSecundaria();
                $catSecundaria -> setInfoAsignada(true);
                $em -> persist($informacion);
                $em -> flush();
                $this -> addFlash('info', '¡La información se cargó correctamente!');
                
                return $this -> redirectToRoute('verInformacion');
               
            }
            else{
                $this -> addFlash('warning', '¡Si no tiene opciones para elegir en el segundo campo, debe crear una categoría secundaria para esta información!');
            }
          
        }

        return $this -> render('informacion/altaInformacion.html.twig', [
            'formulario' => $formulario -> createView(),
           
            
        ]);
    }

     /**
     * @Route("/editor/verInformacion", name="verInformacion")
     */
    public function VerInformacion(Request $request){
        $em = $this -> getDoctrine() -> getManager();
        // $informacion = $em -> getRepository(Informacion::class) ->findAll();

        $form = $this -> createForm(UserBusquedaType::class, new UserBusqueda());
        $form -> handleRequest($request);
        $busqueda = $form -> getData();

        //Los acomoda por nombre 
        // $informacion= $em->getRepository(Informacion::class)->findBy(array(), array('descripcion_corta' => 'ASC'));
        $informacion= $em->getRepository(Informacion::class)->findBy(array(), array('id' => 'DESC'));
        


        if($form -> isSubmitted()){
            return $this -> render('informacion/verInformacion.html.twig', [
                'informacion' => $this -> buscarInfo($busqueda), 'formulario' => $form -> createView()
            ]);
        }
        else{
            return $this -> render('informacion/verInformacion.html.twig', [
                'informacion' => $informacion, 'formulario' => $form -> createView()
            ]);
        }   
    }


    public function buscarInfo(UserBusqueda $busqueda){
        $manager=$this->getDoctrine()->getManager();
        
        $query = $manager->createQuery(
        "SELECT i
        FROM App\Entity\Informacion i
        WHERE i.descripcion_corta LIKE :descripcion_corta
        ORDER BY i.id ASC
        "
        )->setParameter('descripcion_corta','%'. $busqueda->getBuscar().'%');
        
        
        //Límite de resultados..
        $query->setMaxResults(100);
        
        //Retorna busqueda de la compra..
        return $query->getResult();
    }


      /**
     * @Route("/editor/modificarInformacion/{id}", name="modificarInformacion")
     */
    public function ModificarInformacion(Request $request, $id){
        $em = $this -> getDoctrine() -> getManager();

        $informacion = $em -> getRepository(Informacion::class) -> find($id);

        $catSecundaria = $informacion -> getIdCategoriaSecundaria();
        $catSecundaria -> setInfoAsignada(false);
        $em -> flush();


        $formulario = $this -> createForm(InformacionType::class, $informacion);
        $formulario -> handleRequest($request);

        if($formulario -> isSubmitted() && $formulario -> isValid() && $this -> validarInformacion($informacion)){ 
            $catSecundaria = $informacion -> getIdCategoriaSecundaria();
            $catSecundaria -> setInfoAsignada(true);
            $this -> addFlash('info', '¡La información se modificó correctamente!');
            $em -> flush();
            
           return $this -> redirectToRoute('verInformacion');
        }

        return $this -> render('informacion/modificarInformacion.html.twig', [
            'formulario' => $formulario -> createView()
            
        ]);
    }

    /**
     * @Route("/editor/eliminarInformacion/{id}", name="eliminarInformacion")
     */
    public function EliminarInformacion(Request $request, $id){
        $em = $this -> getDoctrine() -> getManager();

        $informacion = $em -> getRepository(Informacion::class) -> find($id);
        $catSecundaria = $informacion -> getIdCategoriaSecundaria();
        $catSecundaria -> setInfoAsignada(false);
        $em -> remove($informacion);
        $em -> flush();

        $this -> addFlash('info', '¡La información se eliminó correctamente!');
        return $this -> redirectToRoute('verInformacion');
    }

    public function validarInformacion($informacion){
        if($informacion -> GetExplicacion() == null){
            $this -> addFlash('error', '¡Por favor complete el campo explicación!');
            return false;
        }
        else{
            return true;
        }
    }




 
}
