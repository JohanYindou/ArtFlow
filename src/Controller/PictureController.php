<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Comment;
use App\Form\ImageType;
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
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            if (!$this->getUser()) {
                return $this->redirectToRoute('app_login');
            }

            $comment = $commentForm->getData();
            $comment->setContent($commentForm->get('content')->getData());
            $comment->setUser($this->getUser());
            $comment->setImage($image);
            $comment->setCreatedAt(new \DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_picture', ['id' => $image->getId()]);
        }

        return $this->render('picture/index.html.twig', [
            'image' => $image,
            'commentForm' => $commentForm->createView(),
        ]);
    }

    #[Route('/add-picture', name: 'app_add_picture', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

        $image = new Image();
        $imageForm = $this->createForm(ImageType::class, $image);
        $imageForm->handleRequest($request);


        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $image = $imageForm->getData();

            $image->setTitle($imageForm->get('title')->getData());

            $file = $imageForm->get('path')->getData();
            $originalFileName = $file->getClientOriginalName();
            $file->move(
                $this->getParameter('upload_images'),
                $originalFileName
            );
            $image->setPath('/uploads/images/' . $originalFileName);


            foreach ($imageForm->get('categories')->getData() as $category) {
                $image->addCategory($category);
            }

            $image->setCreatedAt(new \DateTime());
            $image->setUpdatedAt(new \DateTime());
            $image->setUser($user);

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('picture/add.html.twig', [
            'imageForm' => $imageForm,
        ]);
    }
}
