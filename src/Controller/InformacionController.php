<?php

namespace App\Controller;

use App\Entity\CategoriaSecundaria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Informacion;
use App\Form\InformacionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class InformacionController extends AbstractController
{
    /**
     * @Route("/altaInformacion", name="altaInformacion")
     */
    public function AltaInformacion(Request $request)
    {
        $informacion = new Informacion();

        $formulario = $this -> createForm(InformacionType::class, $informacion);
        $formulario -> handleRequest($request);

        

        if($formulario -> isSubmitted() && $formulario -> isValid() && $this -> validarInformacion($informacion)){ 
            $em = $this -> getDoctrine() -> getManager();
            if($informacion -> getIdCategoriaSecundaria() != null ){
                $catSecundaria = $informacion -> getIdCategoriaSecundaria();
                $catSecundaria -> setInfoAsignada(true);
                $em -> persist($informacion);
                $em -> flush();
                $this -> addFlash('info', '¡La información se cargó correctamente!');
                
                return $this -> redirectToRoute('verInformacion');
               
            }
            else{
                $this -> addFlash('error', '¡Por favor primero cree una categoria secundaria para poder asociarla en el primer campo!');
            }
          
        }

        return $this -> render('informacion/altaInformacion.html.twig', [
            'formulario' => $formulario -> createView(),
           
            
        ]);
    }

     /**
     * @Route("/verInformacion", name="verInformacion")
     */
    public function VerInformacion(){
        $em = $this -> getDoctrine() -> getManager();
        // $informacion = $em -> getRepository(Informacion::class) ->findAll();

        //Los acomoda por nombre 
        $informacion= $em->getRepository(Informacion::class)->findBy(array(), array('descripcion_corta' => 'ASC'));

        return $this -> render('informacion/verInformacion.html.twig', [
            'informacion' => $informacion
        ]);
    }

      /**
     * @Route("/modificarInformacion/{id}", name="modificarInformacion")
     */
    public function ModificarInformacion(Request $request, $id){
        $em = $this -> getDoctrine() -> getManager();

        $informacion = $em -> getRepository(Informacion::class) -> find($id);

        $catSecundaria = $informacion -> getIdCategoriaSecundaria();
        $catSecundaria -> setInfoAsignada(false);
        $em -> flush();


        $formulario = $this -> createForm(InformacionType::class, $informacion);
        $formulario -> handleRequest($request);

        if($formulario -> isSubmitted() && $formulario -> isValid()){
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
     * @Route("/eliminarInformacion/{id}", name="eliminarInformacion")
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
