<?php 

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class FooterService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getFooterLinks(): array
    {
        return $this->manager->getRepository(\App\Entity\Category::class)->findAll();
    }
}
