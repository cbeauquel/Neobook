<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class FooterService
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    /**
     * @return array<int, object>
     */
    public function getFooterLinks(): array
    {
        return $this->manager->getRepository(\App\Entity\Category::class)->findAll();
    }
}
