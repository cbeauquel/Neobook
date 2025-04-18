<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderStatusRepository;
use App\Service\PayPlugService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/payplug/pay/{id}', name: 'payplug_pay')]
    public function pay(
        PayPlugService $payPlugService,
        ?Order $order,
        OrderStatusRepository $orderStatusRepository,
        EntityManagerInterface $manager,
        ?User $user
    ): RedirectResponse {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur requis.');
        }
        $amount = $order->getTotalHT();
        $email = $user->getEmail();
        $firstName = $user->getFirstname();
        $lastName = $user->getLastname();
        $returnUrl = 'https://neobook.fr';
        if ($amount <= 0 || empty($email)) {
            throw $this->createNotFoundException('Requête invalide.');
        }
        $status = $orderStatusRepository->findByStatus('Échoué');
        $payment = $payPlugService->createPayment($amount, $email, $firstName, $lastName, $returnUrl);
        if (!$payment || !isset($payment->hosted_payment->payment_url)) {
            $order->setStatus($status);
            $manager->persist($order);
            $manager->flush();
            throw $this->createNotFoundException('Impossible de créer le paiement.');
        }

        // Redirection directe vers la page de paiement PayPlug
        return new RedirectResponse($payment->hosted_payment->payment_url);
    }
}
