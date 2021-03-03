<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contacto;
use App\Controller\DateTime;
use App\Form\ContactoType;
use App\Form\FormularioContactoType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


//Controller general para un CRUD
class ContactoController extends AbstractController
{
    /**
     * @Route("/altaContactos", name="altaContactos")
     */
    public function AltaContactos(Request $request)
    {
        $contacto = new Contacto();

        $formulario = $this -> createForm(ContactoType::class, $contacto);
        $formulario -> handleRequest($request);

        if($formulario -> isSubmitted() && $formulario -> isValid()){
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($contacto);
            $em -> flush();

            $this -> addFlash('info', 'El contacto se cargó correctamente!');
            return $this -> redirectToRoute('verContactos');
        }

        return $this -> render('contacto/altaContactos.html.twig', [
            'formulario' => $formulario -> createView()
        ]);
    }

     /**
     * @Route("/verContactos", name="verContactos")
     */
    public function VerContactos(Request $request){
        $em = $this -> getDoctrine() -> getManager();
        $contacto = $em -> getRepository(Contacto::class) -> findAll();

        return $this -> render('contacto/verContactos.html.twig', [
            'contacto' => $contacto
        ]);
    }

    /**
     * @Route("/modificarContactos/{id}", name="modificarContactos")
     */
    public function ModificarContactos(Request $request, $id){
        $em = $this -> getDoctrine() -> getManager();
        $contacto = $em -> getRepository(Contacto::class) -> find($id);

        $formulario = $this -> createForm(ContactoType::class, $contacto);
        $formulario -> handleRequest($request);

        if($formulario -> isSubmitted() && $formulario -> isValid()){
            $this -> addFlash('info', '¡El contacto se modificó correctamente!');
            $em -> flush();
            return $this -> redirectToRoute('verContactos');
        }

        return $this -> render('contacto/modificarContactos.html.twig', [
            'formulario' => $formulario -> createView()
        ]);
    }

     /**
     * @Route("/eliminarContactos/{id}", name="eliminarContactos")
     */
    public function EliminarContactos(Request $request, $id){
        $em = $this -> getDoctrine() -> getManager();

        $contacto = $em -> getRepository(Contacto::class) -> find($id);

        $em -> remove($contacto);
        $em -> flush();

        $this -> addFlash('info', '¡El contacto se eliminó correctamente!');
        return $this -> redirectToRoute('verContactos');
    }




   
}
