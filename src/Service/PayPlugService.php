<?php

namespace App\Service;

use Payplug\Payplug;
use Payplug\Resource\Payment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class PayPlugService
{
    private string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
        Payplug::init(['secretKey' => $this->secretKey]);
    }

    public function createPayment(float $amount, string $email, string $returnUrl): Payment|array|null
    {
        try {
            $payment = Payment::create([
                'amount'   => 1000, // ✅ 10.00€ en centimes
                'currency' => 'EUR',
                'billing' => ['email' => 'test@example.com'],
                'hosted_payment' => ['return_url' => 'https://example.com'],
            ]);
            return $payment;
        }
        catch (\Payplug\Exception\PayplugException $e) {
            // Log l'erreur détaillée PayPlug
            error_log("Erreur API PayPlug : " . $e->getMessage());
            return ['error' => 'PayPlug Error', 'details' => $e->getMessage()];
        } catch (\Exception $e) {
            error_log("Erreur Générale : " . $e->getMessage());
            return ['error' => 'General Error', 'details' => $e->getMessage()];
        }
    }
}