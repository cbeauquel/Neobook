<?php

namespace App\Factory;

use App\Entity\Basket;
use App\Entity\Order;
use App\Enum\BasketStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Order>
 */
final class OrderFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Order::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     * @return array<mixed>
     */
    protected function defaults(): array
    {
        // Filtrer les paniers transformés
        $transformedBaskets = BasketFactory::repository()->findBy(['status' => BasketStatus::TRANSFORMED]);

        if (empty($transformedBaskets)) {
            return []; // Pas de panier transformé = rien à créer
        }

        /** @var Basket $basket */
        $basket = self::faker()->randomElement($transformedBaskets);

        return [
            'TotalHT' => $basket->getTotalHT(),
            'TotalTTC' => $basket->getTotalTTC(),
            'basket' => $basket,
            'newCustomer' => '0',
            'status' => OrderStatusFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Order $order): void {})
        ;
    }
}
