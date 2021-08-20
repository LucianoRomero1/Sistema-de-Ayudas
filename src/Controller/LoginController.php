<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Entity\User;
use App\encriptado;

class LoginController extends AbstractController
{
    /**
     * @Route("/backIntranet", name="backIntranet")
     */
    public function backIntranet(){
        $encriptado = new encriptado();
        $user = $this->getUser();
        
        if ($user != null){
            $url= "http://intranet.unraf.edu.ar/Intranet/login/" . $encriptado->encriptar($user->getEmail());    
        }else{
            $url= "http://intranet.unraf.edu.ar/Intranet/login/";    
        }
        
        return $this->redirect($url);
    }


    /**
     * @Route("/login/{email}/{rol}/{estado}", name="loginIntranet")
     */
    public function loginIntranet($email,$rol,$estado)
    {
        //Instanciamos encriptado.
        $encriptado = new Encriptado();

        //Instancias necesarias
        $em = $this->getDoctrine()->getManager();
        $users = null;

        //desencriptamos el email
        $email = $encriptado->desencriptar($email);
        
        //Buscamos en  la BD por email al usuario.
        $users= $em->getRepository(User::class)->findBy(['email'=>$email]);
        
        //Si no hay un usuario con ese email, lo creamos de 0.
        if($users == null){
            //Instancia
            $user= new User();
            //Le damos los atributos
            $user->setEmail($email);
            
            //Decodificamos los roles, y lo seteamos.
            $rol=json_decode($rol,TRUE);
            $user->setRoles(['ROLE_LECTOR']);

            //El parámetro estado en este caso no lo vamos a agregar.
            //Pero si lo desea, agregue un atributo en la entidad User y actualice la BD
            //$user->setEstado($estado);
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

        }else{
            //Si ya existe, entonces simplemente lo guardamos en la sesión
            foreach ($users as  $user){

                //Lo mismo, decodificamos y lo seteamos.
                $rol=json_decode($rol,TRUE);
                //$user->setRoles($rol);
                
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));
                $em->flush();
            }
        }
        
        return $this->redirectToRoute('sistema');
    }
}
