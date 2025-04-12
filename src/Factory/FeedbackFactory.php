<?php

namespace App\Factory;

use App\Entity\Feedback;
use App\Enum\BasketStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Feedback>
 */
final class FeedbackFactory extends PersistentProxyObjectFactory
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
        return Feedback::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     * @return array<mixed>
     */
    protected function defaults(): array
    {
        // On récupère tous les formats qui sont dans des paniers transformés
        $baskets = BasketFactory::repository()->findBy(['status' => BasketStatus::TRANSFORMED]);

        $eligiblePairs = [];
        foreach ($baskets as $basket) {
            $user = $basket->getCustomer();

            foreach ($basket->getFormats() as $format) {
                $eligiblePairs[] = ['user' => $user, 'format' => $format];
            }
        }

        if (empty($eligiblePairs)) {
            return [];
        }

        // Éviter les doublons user/format
        static $usedPairs = [];

        do {
            $pair = self::faker()->randomElement($eligiblePairs);
            $format = $pair['format'];
            $user = $pair['user'];
            $key = $user->getId() . '_' . $format->getId();
        } while (in_array($key, $usedPairs) && count($usedPairs) < count($eligiblePairs));

        $usedPairs[] = $key;

        return [
            'nickName' => $user,
            'stars' => self::faker()->numberBetween(1, 5),
            'comment' => self::faker()->sentence(),
            'format' => $format,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Feedback $feedback): void {})
        ;
    }
}
