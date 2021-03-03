<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;


//Controller para dar roles
class UsuariosController extends AbstractController
{
    /**
     * @Route("/superadmin/roles", name="roles")
     */
    public function OtorgarRol()
    {   
        $manager=$this->getDoctrine()->getManager();
        $usuarios= $manager->getRepository(User::class)->findAll();

        return $this->render('usuarios/roles.html.twig',
            ['usuarios' => $usuarios]
        );
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
        $this->addFlash('info', 'Se cambió el permiso a SUPERADMIN');
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
        $this->addFlash('info', 'Se cambió el permiso a ADMIN');
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
        $this->addFlash('info', 'Se cambió el permiso a EDITOR');
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
        $this->addFlash('info', 'Se cambió el permiso a LECTOR');
        return $this->redirectToRoute('roles');
    }


}
