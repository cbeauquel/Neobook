<?php

namespace App\Controller\Admin;

use App\Entity\Sale;
use App\Form\SaleType;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminSaleController extends AbstractController
{
    #[Route('/admin/sales', name: 'admin_sales')]
    public function listAllSale(SaleRepository $saleRepository): Response
    {
        $allSales = $saleRepository->findAll();

        return $this->render('admin/adminSale.html.twig', [
            'controller_name' => 'AdminSaleController',
            'all_sales' => $allSales,
        ]);
    }

    #[Route('/admin/sale/add', name: 'admin_sale_add')]
    #[Route('/admin/sale/edit/{id}', name: 'admin_sale_edit', requirements: ['id' => '\d+'])]
    public function createSale(
        ?Sale $sale,
        Request $request,
        EntityManagerInterface $manager,
    ): Response {
        $sale ??= new Sale();

        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($sale);
            $manager->flush();
            
            return $this->redirectToRoute('admin_sales');
        }

        return $this->render('admin/addSaleForm.html.twig', [
            'controller_name' => 'AdminSaleController',
            'form' => $form,
            'sale' => $sale,
        ]);
    }

    #[Route('admin/sale/remove/{id}', name: 'admin_sale_remove', methods: ['GET', 'POST'])]
    public function remove(?Sale $sale, EntityManagerInterface $manager): Response
    {
        $manager->remove($sale);
        $manager->flush();
            
        return $this->redirectToRoute('admin_sale');
    }
}
