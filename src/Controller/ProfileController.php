<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(
        Request $request,
    ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            return $this->redirectToRoute('app_login');
        }
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/edit-profile', name: 'app_edit-profile')]
    public function edit(
        Request $request,
    ): Response
    {
        $user = $this->getUser();
        // Faire comme dans Picture controller

        if (!$user) {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            return $this->redirectToRoute('app_login');
        }
        return $this->render('profile/edit-profile.html.twig', [
            'user' => $user,
        ]);
    }
}