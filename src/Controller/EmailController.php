<?php


namespace App\Controller;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function index(Swift_Mailer $mailer)
    {
        // Création du mail
        $mail = new Swift_Message('Bonjour depuis ma boite mail');
        $mail->setSubject('Envoi de mail depuis Symfony 4 Perfectionnement');
        $mail->setFrom('doranco2019@gmail.com');
        $mail->setTo('agathefert60@gmail.com');
        $mail->setBody(
            $this->renderView('email/modele-mail.html.twig'),
            'text/html'
        );
        // Envoi du mail
        $mailer->send($mail);
        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
