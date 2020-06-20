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
                ->from($contact->getEmail())
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
                    'Coś poszło nie tak i Twoja wiadomość nie została wysłana. Spróbuj ponownie później.',
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

//    public function sendAction(Request $request)
//    {
//        if (!$request->isXmlHttpRequest()) {
//            return $this->redirectToRoute('contact');
//        }
//
//        if (!$request->isMethod('post')) {
//            return JsonResponse::create(['ok' => false]);
//        }
//
//        $contact = new Contact();
//        $contact->email = trim($request->get('email'));
//        $contact->phone = trim($request->get('phone'));
//        $contact->message = trim($request->get('message'));
//
//        $validator = $this->get('validator');
//        $constraintViolationList = $validator->validate($contact);
//
//        if (count($constraintViolationList) > 0) {
//            foreach ($constraintViolationList->getIterator() as $constraintViolation) {
//                $errors[$constraintViolation->getPropertyPath()] = $constraintViolation->getMessage();
//            }
//            return JsonResponse::create(['ok' => false, 'errors' => $errors]);
//        }
//
//        $message = $this->renderView('AppBundle:Contact:email.html.twig', [
//            'message' => $contact->message,
//            'phone' => $contact->phone,
//            'email' => $contact->email,
//            'date' => date('d.m.Y H:i:s')
//        ]);
//
//        $to = $this->getParameter('mailer_to');
//        $subject = 'Studio Figura - Zakopane';
//
//        $headers[] = sprintf('From: %s', $contact->email);
//        $headers[] = sprintf('Reply-To: %s', $contact->email);
//        $headers[] = 'MIME-Version: 1.0';
//        $headers[] = 'Content-Type: text/html; charset=UTF-8';
//
//        $sent = mail($to, $subject, $message, implode("\r\n", $headers), '-f ' . $contact->email);
//
//        if (!$sent) {
//            return JsonResponse::create(['ok' => false, 'errors' => [], 'msg' => 'Problem z wysyłką']);
//        }
//
//        return JsonResponse::create(['ok' => true, 'errors' => [], 'msg' => 'Wiadomość wysłana']);
//    }
}
