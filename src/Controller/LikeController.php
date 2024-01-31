<?php

namespace App\Controller;

use App\Entity\Like;
use App\Repository\ImageRepository;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    public function index(
        Request $request,
        LikeRepository $likeRepository,
        ImageRepository $imageRepository,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        $image = $imageRepository->findOneBy([
            'id' => $request->get('id')
        ]);

        $existingLike = $likeRepository->findOneBy([
            'user' => $user,
        ]);

        if ($existingLike) {
            $user->removeLike($existingLike);
            $image->removeLike($existingLike);

            $entityManager->persist($user);
            $entityManager->persist($image);
            $entityManager->remove($existingLike);
            $entityManager->flush();

            $this->addFlash('unlike', 'You have unliked this picture!');
            return $this->redirectToRoute('app_picture', ['id' => $image->getId()]);
        }

        $like = new Like();
        $like->setUser($user);
        $like->addImage($image);
        $like->setCreatedAt(new \DateTime());

        $entityManager->persist($like);
        $entityManager->flush();

        $this->addFlash('like', 'You have liked this picture!');
        return $this->redirectToRoute('app_picture', ['id' => $image->getId()]);
    }
}
