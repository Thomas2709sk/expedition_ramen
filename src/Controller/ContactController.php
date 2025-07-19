<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $contactForm = $this->createForm(ContactFormType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            $data = $contactForm->getData();

            $email = (new Email())
                ->from($data['email'])
                ->to('contact@expedition-ramen.fr')
                ->subject($data['subject'])
                ->text($data['message']);

            $mailer->send($email);


            $confirmation = (new Email())
                ->from('contact@expedition-ramen.fr')
                ->to($data['email'])
                ->subject('Confirmation de réception : ' . $data['subject'])
                ->text("Bonjour,\n\nNous avons bien reçu votre message et nous vous répondrons dans les meilleurs délais.\n\nMerci pour votre confiance.\n\nL'équipe Expedition Ramen");
            $mailer->send($confirmation);


            $this->addFlash('success', 'Votre message a été envoyé avec succès.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm
        ]);
    }
}
