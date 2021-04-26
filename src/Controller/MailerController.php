<?php
// src/Controller/MailerController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class MailerController extends AbstractController
{
    /**
     * @Route("/user/email/{mensaje}")
     */
    public function sendEmail(MailerInterface $mailer, $mensaje)
    {
        $email = (new Email())
            ->from('intranet@unraf.edu.ar')
            ->to('luciano.romero@unraf.edu.ar')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')

            ->priority(Email::PRIORITY_HIGH)
            ->subject('Error reportado en FAQS')
            ->text('')
	    ->html("
		<div>
			<div style='border:3 px solid #fc447c;width:500px; padding:15px;'>
		        	<h2 style='color:#0F9FA8;text-align:center;'>Mensaje desde Intranet</h2>
				<hr>
				<h4>Usuario: ". $this->getUser()->getEmail() ."</h4>
				<hr>
				<h4 style='color:#fc447c;'>Error reportado: </h4>
				<hr>
				<h4 style='color:#2B2B2B;'> ". $mensaje ."</h4>
				<hr>
			</div>
		</div>

	    ");

        $mailer->send($email);
	    $this->addFlash('info', 'Se ha enviado el mail correctamente. Pronto tendrá su respuesta');
        return $this->redirectToRoute('sistema');
            
        }
}