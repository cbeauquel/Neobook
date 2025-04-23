<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'admin_category')]
    public function listAllCategories(CategoryRepository $categoryRepository): Response
    {
        $allCategories = $categoryRepository->findAll();
        
        return $this->render('admin/adminCategory.html.twig', [
            'controller_name' => 'AdminCategoryController',
            'all_categories' => $allCategories,
        ]);
    }

    #[Route('/admin/category/add', name: 'admin_category_add')]
    #[Route('/admin/category/edit/{id}', name: 'admin_category_edit', requirements: ['id' => '\d+'])]
    public function createCategory(
        ?Category $category,
        Request $request,
        EntityManagerInterface $manager,
    ): Response {
        $category ??= new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();
            
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/addCategoryForm.html.twig', [
            'controller_name' => 'AdminCategoryController',
            'form' => $form,
            'category' => $category,
        ]);
    }

    #[Route('admin/category/remove/{id}', name: 'admin_category_remove', methods: ['GET', 'POST'])]
    public function remove(?Category $category, EntityManagerInterface $manager): Response
    {
        $manager->remove($category);
        $manager->flush();
            
        return $this->redirectToRoute('admin_category');
    }
}
