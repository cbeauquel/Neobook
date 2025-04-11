<?php

namespace App\Controller;

use App\Entity\ToBeRead;
use App\Entity\User;
use App\Form\CustomerType;
use App\Repository\OrderRepository;
use App\Repository\ToBeReadRepository;
use App\Service\BreadcrumbService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CustomerAccountController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED', message: 'Vous devez avoir un compte pour afficher cette page')]
    #[Route('/account', name: 'customer_account')]
    public function index(ToBeReadRepository $toBeReadRepository, OrderRepository $orderRepository): Response
    {
        $booksToBeRead = $toBeReadRepository->findByCustomerId($this->getUser());
        $myInvoices = $orderRepository->findByCustomerId($this->getUser());

        return $this->render('customer/index.html.twig', [
            'controller_name' => 'CustomerAccountController',
            'my_invoices' => $myInvoices,
            'books_to_be_read' => $booksToBeRead,
         ]);
    }

    #[IsGranted('ROLE_USER', message: 'Vous devez avoir un compte pour afficher cette page')]
    #[Route('/edit/{id}', name: 'customer_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(?User $customer, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($customer);
            $manager->flush();
            
            return $this->redirectToRoute('customer_account');
        }

        return $this->render('customer/edit.html.twig', [
            'controller_name' => 'CustomerAccountController',
            'form' => $form,
        ]);
    }

    #[Route('/remove/{id}', name: 'tbr_remove', methods: ['GET', 'POST'])]
    public function remove(?ToBeRead $toBeRead, EntityManagerInterface $manager): Response
    {
        $manager->remove($toBeRead);
        $manager->flush();

        return $this->redirectToRoute('customer_account');
    }
}
