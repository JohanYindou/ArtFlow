<?php

namespace App\Controller;

use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/edit-profile', name: 'app_edit-profile',methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
    ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        $userForm = $this->createForm(ProfileType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted()) {
            if ($userForm->isValid()) {
                $user = $userForm->getData();
                $user->setUsername($userForm->get('username')->getData());
                $user->setDescription($userForm->get('description')->getData());
                /*
            Si on veux modifer la photo de profil
            $user->setProfilePicture($userForm->get('profilePicture')->getData());
            */
            // Test
                $test = "Je suis arrivé jusqu'ici";
                dump($test);


                $em->persist($user);
                $em->flush();
                $this->addFlash('success', "Votre profil a bien été mis à jour");
                return $this->redirectToRoute('app_profile');
            }
            else{
                $this->addFlash('error', "Le formulaire n'est pas valide");
        }
        }
        


        return $this->render('profile/edit-profile.html.twig', [
            'user' => $user,
            'userForm'=> $userForm->createView(),
        ]);
    }
}