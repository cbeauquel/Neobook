<?php

namespace App\Service;

use Payplug\Payplug;
use Payplug\Resource\Payment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PayPlugService
{
    public function __construct(private readonly string $secretKey)
    {
        // Initialisation de PayPlug avec la nouvelle méthode
        Payplug::init([
            'secretKey' => $this->secretKey,
            'apiVersion' => '2019-08-06' // Vérifie la dernière version dans la doc
        ]);
    }
    public function createPayment(string $amount, string $customerEmail, string $firstName, string $lastName, string $returnUrl): ?Payment
    {
        try {
            $paymentData = [
                'amount' => (float)$amount * 100, // PayPlug attend les centimes
                'currency' => 'EUR',
                'billing' => [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $customerEmail,
                ],
                'shipping' => ['delivery_type' => 'DIGITAL_GOODS'],
                'hosted_payment' => ['return_url' => $returnUrl],
                'notification_url' => 'https://ton-site.com/webhook/payplug'
            ];
            //  dd($paymentData);
            $payment = Payment::create($paymentData);
    
            return $payment;
        } catch (\Exception) {
            return null;
        }
    }
}
