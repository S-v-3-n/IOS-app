<?php

namespace App\Controller;

use App\Form\MessageType;
use Symfony\UX\Turbo\TurboBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        $form = $this->createForm(MessageType::class);
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/', name: 'app_message', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $form = $this->createForm(MessageType::class);

        $form->handleRequest($request);

        dump('yooo');
        dump($form->isSubmitted() && $form->isValid());
        dump($request->getRequestFormat());

        if ($form->isSubmitted() && $form->isValid()) {
            $messages = $form->getData();

            // die;
            // if ($request->getRequestFormat() === TurboBundle::STREAM_FORMAT) {
                // If the request comes from Turbo, set the content type as text/vnd.turbo-stream.html and only send the HTML to update
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                return $this->renderBlock('home/index.html.twig', 'message_stream',
                [
                    'messages' => $messages,
                    'form' => $form,
                ]);
            // }


            // If the client doesn't support JavaScript, or isn't using Turbo, the form still works as usual.
            // Symfony UX Turbo is all about progressively enhancing your applications!
        }

        return $this->render('home/index.html.twig', [
            'form' => $form,
            'messages' => []
        ]);
    }
}
