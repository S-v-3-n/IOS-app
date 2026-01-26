<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/message', name: 'app_message', methods: ['POST'])]
    public function message(Request $request): Response
    {
        $message = $request->request->get('message');

        return $this->render('home/_message.stream.html.twig', [
            'message' => $message,
        ]);
}
}
