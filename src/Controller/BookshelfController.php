<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Entity\User;
use App\Repository\FeedbackRepository;
use App\Repository\FormatRepository;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookshelfController extends AbstractController
{
    #[Route('/bookshelf', name: 'bookshelf')]
    public function showMyBooks(FormatRepository $formatRepository, FeedbackRepository $feedbackRepository): Response
    {
        $customer = $this->getUser();
        if (!$customer instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur requis.');
        }
        $myFormats = $formatRepository->findByOrderStatus($customer);

        foreach ($myFormats as $format) {
            $reflection = new ReflectionClass($format);
            if ($reflection->hasProperty('feedbacks')) {
                $prop = $reflection->getProperty('feedbacks');
                $prop->setAccessible(true);
                $filtered = $format->getFeedbacks()->filter(fn ($f) => $f->getNickname() === $customer);
                $prop->setValue($format, $filtered);
            }
        }
        // dd($myFormats);
        return $this->render('bookshelf/index.html.twig', [
            'controller_name' => 'BookshelfController',
            'myFormats' => $myFormats,
            'customer' => $customer,
        ]);
    }
}
