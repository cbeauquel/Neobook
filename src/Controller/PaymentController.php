<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Service\PayPlugService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class PaymentController extends AbstractController
{
    #[Route('/payplug/pay/{id}', name: 'payplug_pay')]
    public function pay(?User $user, PayPlugService $payPlugService, ?Order $order): RedirectResponse
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

        $payment = $payPlugService->createPayment($amount, $email, $firstName, $lastName, $returnUrl);
        if (!$payment || !isset($payment->hosted_payment->payment_url)) {
            throw $this->createNotFoundException('Impossible de créer le paiement.');
        }

         // Redirection directe vers la page de paiement PayPlug
        return new RedirectResponse($payment->hosted_payment->payment_url);
    }
}
