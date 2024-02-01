<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(
        ImageRepository $imageRepository,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $em
    ): Response
    {
        $categories = $categoryRepository->findAll();

        $selectedCategory = $em->getRepository(Category::class)->find(1);
        $images = $imageRepository->findByCategory($selectedCategory);

        return $this->render('home/index.html.twig', [
            'images' => $images,
            'selectedCategory' => $selectedCategory,
            'categories' => $categories,
        ]);
    }
}
