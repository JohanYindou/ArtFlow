<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\TagRepository;
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
        Request $request,
        EntityManagerInterface $em
    ): Response
    {
        $categories = $categoryRepository->findAll();

        $categoryId = $request->query->get('category');
        $selectedCategory = $categoryId ? $categoryRepository->find($categoryId)
        : null;

        $images = $selectedCategory ? $imageRepository->findByCategory($selectedCategory)
        : $imageRepository->findAll();
        //$images = $imageRepository->findAll();

        return $this->render('home/index.html.twig', [
            'images' => $images,
            'selectedCategory' => $selectedCategory,
            'categories' => $categories,
        ]);
    }
}
