<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    public function index(Request $request, MailerInterface $mailer, LoggerInterface $logger)
    {
        $contact = new Contact();
        $contact->setPhone(trim($request->get('phone', '')));
        $contact->setEmail(trim($request->get('email', '')));
        $contact->setMessage(trim($request->get('message', '')));

        $form = $this->get('form.factory')->createNamed('', ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $message = $this->renderView('email.html.twig', [
                'message' => $contact->getMessage(),
                'phone' => $contact->getPhone(),
                'email' => $contact->getEmail(),
                'date' => date('d.m.Y H:i:s'),
            ]);
            $email = (new Email())
                ->from($this->getParameter('app.from_email'))
                ->replyTo($contact->getEmail())
                ->to($this->getParameter('app.to_email'))
                ->subject('Studio Figura - Zakopane')
                ->html($message);

            try {
                $mailer->send($email);
                $this->addFlash(
                    'success',
                    'Twoja wiadomość została wysłana. Dziękujemy.'
                );
            } catch (\Exception $e) {
                $logger->critical($e->getMEssage(), [
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'data' => [
                        'phone' => $contact->getPhone(),
                        'email' => $contact->getEmail(),
                        'message' => $contact->getMessage(),
                    ],
                ]);
                $this->addFlash(
                    'danger',
                    'Coś poszło nie tak i Twoja wiadomość nie została wysłana. Spróbuj ponownie później.'
                );
            }

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
            'googleMapsApiKey' => $this->getParameter('app.google_maps_api_key'),
            'googleMapsLat' => $this->getParameter('app.google_maps_lat'),
            'googleMapsLng' => $this->getParameter('app.google_maps_lng'),
        ]);
    }
}
