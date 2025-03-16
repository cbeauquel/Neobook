<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\CustomerType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminCustomerController extends AbstractController
{
    #[Route('/admin/customer', name: 'admin_customer')]
    public function listAllCustomers(UserRepository $customerRepository): Response
    {
        $allCustomers = $customerRepository->findAll();
        
        return $this->render('admin/adminCustomer.html.twig', [
            'controller_name' => 'AdminCustomerController',
            'all_customers' => $allCustomers,
        ]);
    }

    #[Route('/admin/customer/add', name: 'admin_customer_add')]
    #[Route('/admin/customer/edit/{id}', name: 'admin_customer_edit', requirements: ['id' => '\d+'])]
    public function createCustomer(
        ?User $customer,
        Request $request,
        EntityManagerInterface $manager,
    ): Response {
        $customer ??= new User();

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($customer);
            $manager->flush();
            
            return $this->redirectToRoute('admin_customer');
        }

        return $this->render('admin/adminCustomer.html.twig', [
            'controller_name' => 'AdminCustomerController',
            'form' => $form,
            'customer' => $customer,
        ]);
    }

    #[Route('admin/customer/remove/{id}', name: 'admin_customer_remove', methods: ['GET', 'POST'])]
    public function remove(?User $customer, EntityManagerInterface $manager): Response
    {
        $manager->remove($customer);
        $manager->flush();
            
        return $this->redirectToRoute('admin_book');
    }
}
