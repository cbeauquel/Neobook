<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Basket;
use App\Form\OrderType;
use App\Enum\BasketStatus;
use App\Service\BreadcrumbService;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderStatusRepository;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\throwException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/order', name: 'order_')]
class OrderController extends AbstractController
{    
    #[IsGranted('IS_AUTHENTICATED', message:'Pour passer à la commande, identifiez vous ou créez votre compte')]
    #[Route('/add/{id}', name: 'add', requirements:['id' => '\d+'])]
    public function addOrder(
        ?Basket $basket, 
        EntityManagerInterface $manager, 
        ?Order $order, 
        OrderStatusRepository $orderStatusRepository, 
        OrderRepository $orderRepository,
        int $id,
        ): Response
    {
        $defautStatus = $orderStatusRepository->findByStatus('En attente');
        $customerOrders = $orderRepository->findByUserId($this->getUser());
        if(isset($customerOrders)){
            $newCustomer = false;
        }
        $existingOrder = $orderRepository->findByBasketId($id);
        $customerId = $basket->getCustomer();
        $totalHT = $basket->getTotalHT();
        $totalTTC = $basket->getTotalTTC();
        if(!$existingOrder){
            $order ??= new Order();
            $order->setCustomer($customerId);
            $order->setTotalHT($totalHT);
            $order->setTotalTTC($totalTTC);
            $order->setStatus($defautStatus);
            $order->setBasket($basket);
            $order->setUserToken($basket);
            $order->setNewCustomer($newCustomer);
            $manager->persist($order);
            $manager->flush();
            } elseif($existingOrder->getStatus()->getId() != '1') {
                throw new \RuntimeException('Une commande a déjà été passée avec ce panier');
            } else {
                return $this->redirectToRoute('order_view', ['id' => $existingOrder->getId()]);
            }

        return $this->redirectToRoute('order_view', ['id' => $order->getId()]);
    }

    #[IsGranted('IS_AUTHENTICATED', message:'Pour passer à la commande, identifiez vous ou créez votre compte')]
    #[Route('/view/{id}', name: 'view', requirements: ['id' => '\d+'])]
    public function viewOrder(?Order $order, BreadcrumbService $breadcrumbService,): Response
    {
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Commande', $this->generateUrl('order_view', ['id' => $order->getId()]));

        $formatsOrder = $order->getBasket();
        // dd($formatsOrder);
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'formatsOrder' => $formatsOrder,
            'order' => $order,
            'breadcrumbs' => $breadcrumbService->get(),

        ]);
    }

    #[IsGranted('IS_AUTHENTICATED', message:'Pour passer à la commande, identifiez vous ou créez votre compte')]
    #[Route('/abort/{id}', name: 'abort', requirements: ['id' => '\d+'])]
    public function deleteOrder(?Order $order, EntityManagerInterface $manager, OrderStatusRepository $orderStatusRepository): Response
    {
        $abortStatus = $orderStatusRepository->findByStatus('Échoué');
        $basket = $order->getBasket();
        $order->setStatus($abortStatus);
        $basket->setStatus(BasketStatus::ABORTED);

        $manager->persist($order);
        $manager->flush();
            
            return $this->redirectToRoute('customer_account');
    }

}
