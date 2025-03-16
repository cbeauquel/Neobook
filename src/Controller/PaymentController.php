<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Service\PayPlugService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/payplug/pay/{id}', name: 'payplug_pay')]
    public function pay(PayPlugService $payPlugService, ?Order $order, OrderStatusRepository $orderStatusRepository, EntityManagerInterface $manager): RedirectResponse
    {
        $amount = $order->getTotalHT();
        $email = $this->getUser()->getEmail();
        $firstName = $this->getUser()->getFirstname();
        $lastName = $this->getUser()->getLastname();
        $returnUrl = 'https://neobook.fr';
        // dd($amount, $email);
        if ($amount <= 0 || empty($email)) {
            throw $this->createNotFoundException('Requête invalide.');
        }
        $status = $orderStatusRepository->findByStatus('Échoué');
        $payment = $payPlugService->createPayment($amount, $email, $firstName, $lastName, $returnUrl);
        // dd($payment);
        if (!$payment || !isset($payment->hosted_payment->payment_url)) {
            $order->setStatus($status);
            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute('customer_account');
            throw $this->createNotFoundException('Impossible de créer le paiement.');
        }

        // Redirection directe vers la page de paiement PayPlug
        return new RedirectResponse($payment->hosted_payment->payment_url);
    }
}
