<?php

namespace App\Factory;

use App\Entity\Basket;
use App\Enum\BasketStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Basket>
 */
final class BasketFactory extends PersistentProxyObjectFactory
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
        return Basket::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     * @return array<mixed>
     */
    protected function defaults(): array
    {
        return [
            'status' => self::faker()->randomElement(
                array_merge(
                    array_fill(0, 70, BasketStatus::TRANSFORMED),
                    array_fill(0, 5, BasketStatus::IN_PROGRESS),
                    array_fill(0, 25, BasketStatus::ABORTED),
                )
            ),
            'customer' => UserFactory::random(),
            'formats' => FormatFactory::randomRange(1, 4),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (Basket $basket): void {
                $totalHT = 0.0;
                $totalTTC = 0.0;

                foreach ($basket->getFormats() as $format) {
                    $totalHT += $format->getPriceHT();
                    $totalTTC += $format->getPriceTTC();
                }

                $basket->setTotalHT($totalHT);
                $basket->setTotalTTC($totalTTC);
            });
    }
}
