<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Basket;
use App\Form\OrderType;
use App\Enum\BasketStatus;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderStatusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderController extends AbstractController
{    
    #[IsGranted('IS_AUTHENTICATED', message:'Pour passer à la commande, identifiez vous ou créez votre compte')]
    #[Route('/add/{id}', name: 'order_add', requirements:['id' => '\d+'])]
    public function addOrder(
        ?Basket $basket, 
        EntityManagerInterface $manager, 
        ?Order $order, 
        OrderStatusRepository $orderStatusRepository, 
        OrderRepository $orderRepository,
        ): Response
    {
        $defautStatus = $orderStatusRepository->findByStatus('En attente');
        $customerOrders = $orderRepository->findByUserId($this->getUser());
        if(isset($customerOrders)){
            $newCustomer = true;
        }
        $customerId = $basket->getCustomer();
        $totalHT = $basket->getTotalHT();
        $totalTTC = $basket->getTotalTTC();
        if(!$order){
            $order ??= new Order();
            $order->setCustomer($customerId);
            $order->setTotalHT($totalHT);
            $order->setTotalTTC($totalTTC);
            $order->setStatus($defautStatus);
            $order->setBasket($basket);
            $order->setUserToken($basket);
            $order->setNewCustomer($newCustomer);
            $manager->persist($order);
            $manager->persist($basket);
            $manager->flush();
            } 
        return $this->redirectToRoute('order_view', ['id' => $order->getId()]);
    }

    #[IsGranted('IS_AUTHENTICATED', message:'Pour passer à la commande, identifiez vous ou créez votre compte')]
    #[Route('/view/{id}', name: 'order_view', requirements: ['id' => '\d+'])]
    public function viewOrder(?Order $order, OrderRepository $orderRepository): Response
    {
        $formatsOrder = $order->getBasket();
        // dd($formatsOrder);
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'order' =>$formatsOrder,
        ]);
    }

}
