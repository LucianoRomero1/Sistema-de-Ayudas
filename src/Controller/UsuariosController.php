<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\UserBusqueda;
use App\Form\UserBusquedaType;
use Symfony\Component\HttpFoundation\Request;


//Controller para dar roles
class UsuariosController extends AbstractController
{

    /**
     * @Route("/superadmin/roles", name="roles")
     */
    public function OtorgarRol(Request $request)
    {   
        $manager=$this->getDoctrine()->getManager();
        
        $form = $this -> createForm(UserBusquedaType::class, new UserBusqueda());
        $form -> handleRequest($request);
        $busqueda = $form ->getData();

        $usuarios= $manager->getRepository(User::class)->findBy(array(), array('email' => 'ASC'));

        if($form -> isSubmitted()){
            return $this -> render('usuarios/roles.html.twig', [
                'usuario' => $this -> buscarUsuarios($busqueda), 'formulario' => $form -> createView()
            ]);
        }
        else{
            return $this->render('usuarios/roles.html.twig',[
                'usuario' => $usuarios, 'formulario' => $form -> createView()
            ]);
        }
      
    }
    
    /**
     * @Route("/superadmin/cambioSuperadmin/{id}", name="cambioSuperadmin")
     */
    public function cambioSuperAdmin(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario= $em->getRepository(User::class)->find($id);

        $usuario->setRoles(['ROLE_LECTOR', 'ROLE_EDITOR','ROLE_ADMIN', 'ROLE_SUPERADMIN']);
            
        $em->flush($usuario);
        $this->addFlash('info', 'Se cambió el permiso de '. $usuario->getUsername()  .' a SUPERADMIN');
        return $this->redirectToRoute('roles');
    }

    
      /**
     * @Route("/superadmin/cambioAdmin/{id}", name="cambioAdmin")
     */
    public function cambioAdmin(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario= $em->getRepository(User::class)->find($id);

        $usuario->setRoles(['ROLE_LECTOR', 'ROLE_EDITOR', 'ROLE_ADMIN']);
            
        $em->flush($usuario);
        $this->addFlash('info', 'Se cambió el permiso de '. $usuario->getUsername() .' a ADMIN');
        return $this->redirectToRoute('roles');
    }

    /**
     * @Route("/superadmin/cambioEditor/{id}", name="cambioEditor")
     */
    public function cambioEditor(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario= $em->getRepository(User::class)->find($id);

        $usuario->setRoles(['ROLE_LECTOR', 'ROLE_EDITOR']);
            
        $em->flush($usuario);
        $this->addFlash('info', 'Se cambió el permiso de ' . $usuario->getUsername()  . ' a EDITOR');
        return $this->redirectToRoute('roles');
    }



    /**
     * @Route("/superadmin/cambioLector/{id}", name="cambioLector")
     */
    public function cambioLector(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario= $em->getRepository(User::class)->find($id);

        $usuario->setRoles(['ROLE_LECTOR']);
            
        $em->flush($usuario);
        $this->addFlash('info', 'Se cambió el permiso de ' . $usuario->getUsername()  .' a LECTOR');
        return $this->redirectToRoute('roles');
    }


    public function buscarUsuarios(UserBusqueda $busqueda){
        $manager = $this -> getDoctrine() -> getManager();

        $query = $manager->createQuery(
            "SELECT u
            FROM App\Entity\User u
            WHERE u.email LIKE :email
            ORDER BY u.id ASC
            "
            )->setParameter('email','%'. $busqueda->getBuscar().'%');
            
            
            //Límite de resultados..
            $query->setMaxResults(100);
            
            //Retorna busqueda de la compra..
            return $query->getResult();
    }
}
