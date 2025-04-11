<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class InvoicesController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED', message: 'Vous devez avoir un compte pour afficher cette page')]
    #[Route('/invoices', name: 'customer_invoices')]
    public function showInvoices(OrderRepository $orderRepository): Response
    {
        $myInvoices = $orderRepository->findByCustomerId($this->getUser());

        //  dd($myInvoices);
        return $this->render('customer/invoices.html.twig', [
            'controller_name' => 'CustomerAccountController',
            'my_invoices' => $myInvoices,
         ]);
    }
}
