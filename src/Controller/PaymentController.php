<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\PayPlugService;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PaymentController extends AbstractController
{
    #[Route('/payplug/create/{amount}', name: 'payplug_create')]
    public function createPayment(PayPlugService $payPlugService, $amount): JsonResponse
    {
        $customer = $this->getUser();
        if (!$customer){
            throw new UnauthorizedHttpException('L\'utilisateur n\'est pas authentifié');
        }
        $amount = $amount; // Exemple de montant
        $email = $customer->getEmail();
        dd($customer);
        $returnUrl = $this->generateUrl('home', [], true);

        $payment = $payPlugService->createPayment($amount, $email, $returnUrl);

        // if (!$payment) {
        //     return $this->json(['error' => 'Erreur lors de la création du paiement'], 500);
        // }
        // Si PayPlug retourne un tableau, il y a une erreur
        if (is_array($payment) && isset($payment['error'])) {
            return $this->json($payment, 500); // HTTP 500 pour signaler une erreur
        }
        return $this->json([
            'payment_id' => $payment->id,
            'payment_url' => $payment->hosted_payment->payment_url
        ]);

    }
}
