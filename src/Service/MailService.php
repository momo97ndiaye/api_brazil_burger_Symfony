<?php
namespace App\Service;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailService{
    
    public function __construct(MailerInterface $mailer, Environment $twig){
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /** 
     *@param User $user
     *
     */
    public function envoiMail($user,$subject="Création de compte"){
        $from = "brazilburger@gmail.com";
        $email = (new Email())
            ->from($from)
            ->to($user->getEmail())
            ->subject($subject)
            ->html($this->twig->render('Registration/email.html.twig',[
                'token' => $user->getToken(),
                'subject' => $subject,
                'name' => $user->getNomComplet()
            ]));
            $this->mailer->send($email);

    }
    

}