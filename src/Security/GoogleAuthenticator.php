<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;

class GoogleAuthenticator extends SocialAuthenticator
{
    
    private $clientRegistry;
    private $em;
    private $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }
    
    public function supports(Request $request)
    {
        return $request->getPathInfo() == '/connect/google/check' && $request->isMethod('GET');
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getGoogleClient());
    }


    //Cuando se loguea con Google le otorga el Rol de lector
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $googleUser */
        $googleUser = $this->getGoogleClient()
            ->fetchUserFromToken($credentials);
        
        $email = $googleUser->getEmail();

        $user = $this->em->getRepository('App:User')
            ->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new User();
            $user->setEmail($googleUser->getEmail());
            $user->setRoles(['ROLE_LECTOR']);
            //$user->setUltimoAcceso($this->getFechActual());
            //$user->setEstado("Alta");
            
            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }
    
    public function getFechActual(){
        $fechaActual=  new \DateTime();
        
        //Se le resta 3 horas a la fecha para que sea correcta a la actual. Desconozco el motivo
        $fechaActual->modify("-3 hours");
        
        return $fechaActual;
    }
    
    /**
     * @return \KnpU\OAuth2ClientBundle\Client\OAuth2Client
     */
    private function getGoogleClient()
    {
        return $this->clientRegistry
            ->getClient('google');
    }

    public function onAuthenticationFailure(Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $exception)
    {
        // TODO: Implement onAuthenticationFailure() method.
    }

    public function onAuthenticationSuccess(Request $request, \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token, $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function start(Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $authException = null)
    {
        $redireccion = new RedirectResponse('/');
        $redireccion->setTargetUrl('http://intranet.unraf.edu.ar/FAQS/login');
        return $redireccion;
    }

}