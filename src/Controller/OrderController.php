<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Order;
use App\Entity\User;
use App\Enum\BasketStatus;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Service\BreadcrumbService;
use App\Service\PayPlugService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\TypeInfo\Type\EnumType;
use Symfony\Component\Validator\Constraints\IsTrue;

use function PHPUnit\Framework\throwException;

#[Route('/order', name: 'order_')]
class OrderController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED', message: 'Pour passer à la commande, identifiez vous ou créez votre compte')]
    #[Route('/add/{id}', name: 'add', requirements: ['id' => '\d+'])]
    public function addOrder(
        ?Basket $basket,
        EntityManagerInterface $manager,
        ?Order $order,
        OrderStatusRepository $orderStatusRepository,
        OrderRepository $orderRepository,
        ?UserInterface $user,
        RequestStack $requestStack,
        int $id,
    ): Response {
        $user = $this->getUser();
        $defautStatus = $orderStatusRepository->findByStatus('En attente');
        $customerOrders = $orderRepository->findByUserId($user);
        $newCustomer = true;
        if ($customerOrders) {
            $newCustomer = false;
        }

        $existingOrder = $orderRepository->findByBasketId($id);
        $customerId = $basket->getCustomer();
        $totalHT = $basket->getTotalHT();
        $totalTTC = $basket->getTotalTTC();
        if (!$existingOrder) {
            $order ??= new Order();
            $order->setCustomer($customerId);
            $order->setTotalHT($totalHT);
            $order->setTotalTTC($totalTTC);
            $order->setStatus($defautStatus);
            $order->setBasket($basket);
            $order->setNewCustomer($newCustomer);
            $basket->setStatus(BasketStatus::TRANSFORMED);
            $manager->persist($order);
            $manager->persist($basket);
            $manager->flush();
        } elseif ($existingOrder->getStatus()->getStatus() != 'En attente') {
            throw new \RuntimeException('Une commande a déjà été passée avec ce panier');// @codeCoverageIgnore
        } else {
            return $this->redirectToRoute('order_view', ['id' => $existingOrder->getId()]);
        }
        // Nettoyer toutes les données du panier en session
        $session = $requestStack->getSession();
        $session->remove('basket');
        $session->remove('basket_items');
        $session->remove('basket_total');
        return $this->redirectToRoute('order_view', ['id' => $order->getId()]);
    }

    #[IsGranted('IS_AUTHENTICATED', message: 'Pour passer à la commande, identifiez vous ou créez votre compte')]
    #[Route('/view/{id}', name: 'view', requirements: ['id' => '\d+'])]
    public function viewOrder(
        ?Order $order,
        BreadcrumbService $breadcrumbService,
        PayPlugService $payPlugService,
        EntityManagerInterface $manager,
        OrderStatusRepository $orderStatusRepository,
    ): Response {
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Commande', $this->generateUrl('order_view', ['id' => $order->getId()]));
        $formatsOrder = $order->getBasket();

        // dd($order->getStatus()->getId());
        if ($order->getPaymentID()) {
            $isPaidStatus = $orderStatusRepository->findByStatus('Paiement accepté');
            $isFailedStatus = $orderStatusRepository->findByStatus('Échoué');
            $payment = $payPlugService->retrievePayment($order->getPaymentID());
            /** @phpstan-ignore-next-line */
            $paymentStatus = $payment->is_paid;
            if ($paymentStatus === true) {
                $order->setStatus($isPaidStatus);
            } else {
                $order->setStatus($isFailedStatus);
            }
            $manager->persist($order);
            $manager->flush();
        }


        // dd($formatsOrder);
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'formatsOrder' => $formatsOrder,
            'order' => $order,
            'breadcrumbs' => $breadcrumbService->get(),

        ]);
    }

    #[IsGranted('IS_AUTHENTICATED', message: 'Pour passer à la commande, identifiez vous ou créez votre compte')]
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
