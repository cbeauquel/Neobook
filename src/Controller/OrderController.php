<?php

namespace App\Controller;

use App\Entity\Basket;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/order', name: 'order')]
class OrderController extends AbstractController
{    
    #[IsGranted('IS_AUTHENTICATED', message:'Pour passer à la commande, identifiez vous ou créez votre compte')]
    #[Route('/view/{id}', name: '_view', requirements:['id' => '\d+'])]
    public function showOrder( ?Basket $basket): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'basket' => $basket,
        ]);
    }
}
