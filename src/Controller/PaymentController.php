<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderStatusRepository;
use App\Service\PayPlugService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\isTrue;

class PaymentController extends AbstractController
{
    #[Route('/payplug/pay/{id}', name: 'payplug_pay')]
    public function pay(
        PayPlugService $payPlugService,
        ?Order $order,
        OrderStatusRepository $orderStatusRepository,
        EntityManagerInterface $manager,
        Request $request,
        ?User $user
    ): RedirectResponse {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur requis.');
        }
        $amount = $order->getTotalTTC();
        $returnUrl = 'http://neobookdev.local/order/view' . $order->getID();
        $email = $user->getEmail();
        $firstName = $user->getFirstname();
        $lastName = $user->getLastname();
        $returnUrl = $returnUrl;
        if ($amount <= 0 || empty($email)) {
            throw $this->createNotFoundException('Requête invalide.');
        }
        $status = $orderStatusRepository->findByStatus('Échoué');
        $payment = $payPlugService->createPayment($amount, $email, $firstName, $lastName, $returnUrl);
        // Vérification de l'id de paiement Payplug
        // La propriété id est définie dynamiquement par l'API Payplug
        /** @phpstan-ignore-next-line */
        $order->setPaymentId($payment->id);

        if (!$payment || !isset($payment->hosted_payment->payment_url)) {
            $order->setStatus($status);
            $manager->persist($order);
            $manager->flush();
            throw $this->createNotFoundException('Impossible de créer le paiement.');
        }

        $manager->persist($order);
        $manager->flush();
        // Redirection directe vers la page de paiement PayPlug
        return new RedirectResponse($payment->hosted_payment->payment_url);
    }
}
