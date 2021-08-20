<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Entity\User;


//Funcion que determina el ingreso como invitado
class InvitadoController extends AbstractController
{
    /**
     * @Route("/invitado", name="invitado")
     */
    public function index()
    {


        //Instancias necesarias
        $em = $this->getDoctrine()->getManager();
        $users = null;


        //Buscamos en  la BD por email al usuario.
        $users = $em->getRepository(User::class)->findBy(['email' => 'invitado']);

        //Si no hay un usuario con ese email, lo creamos de 0.
        if ($users == null) {
            $user = new User();

            //Le damos los atributos
            $user->setEmail('invitado');

            //Decodificamos los roles, y lo seteamos.
            $user->setRoles(['ROLE_LECTOR']);

            //El parámetro estado en este caso no lo vamos a agregar.
            //Pero si lo desea, agregue un atributo en la entidad User y actualice la BD
            //$user->setEstado($estado);
            $em->persist($user);
            $em->flush();
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

        } else {
            //Si ya existe, entonces simplemente lo guardamos en la sesión
            foreach ($users as  $user) {

                //Lo mismo, decodificamos y lo seteamos.

                $user->setRoles(['ROLE_LECTOR']);

                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));
                $em->flush();
            }
        }

        return $this->redirectToRoute('sistemaSinBarra');
    }
}
