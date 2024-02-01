<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/delete-comment/{id}', name: 'app_delete_comment')]
    public function index(
        Request $request,
        CommentRepository $commentRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        $comment = $commentRepository->findOneBy([
            'id' => $request->get('id')
        ]);
        $image = $comment->getImage();

        if ($user == $comment->getUser()) {
            $user->removeComment($comment);
            $image->removeComment($comment);

            $entityManager->remove($comment);
            $entityManager->flush();

            $this->addFlash('delete', 'Your comment has been deleted!');
            return $this->redirectToRoute('app_picture', ['id' => $image->getId()]);
        }
    }
}
