<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PictureController extends AbstractController
{
    #[Route('/picture/{id}', name: 'app_picture', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        ImageRepository $imageRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $image = $imageRepository->findOneBy([
            'id' => $request->get('id')
        ]);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setContent($form->get('content')->getData());
            $comment->setUser($form->get('user')->getData());
            $comment->setImage($form->get('image')->getData());
            $comment->setCreatedAt(new \DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_picture', ['id' => $image->getId()]);
        }

        return $this->render('picture/index.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }
}
