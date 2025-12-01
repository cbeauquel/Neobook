<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FeedbackRepository;
use App\Repository\FormatRepository;
use App\Service\DownloadLinkManagerService;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookshelfController extends AbstractController
{
    #[Route('/bookshelf', name: 'bookshelf')]
    public function showMyBooks(FormatRepository $formatRepository, DownloadLinkManagerService $downloadLinkManager): Response
    {
        $customer = $this->getUser();
        $myFormats = $formatRepository->findByOrderStatus($customer);

        foreach ($myFormats as $format) {
            $reflection = new ReflectionClass($format);
            if ($reflection->hasProperty('feedbacks')) {
                $prop = $reflection->getProperty('feedbacks');
                $filtered = $format->getFeedbacks()->filter(fn ($f) => $f->getNickname() === $customer);
                $prop->setValue($format, $filtered);
            }
        }
        foreach ($myFormats as $format) {
            $reflection = new ReflectionClass($format);
            if ($reflection->hasProperty('downloadLinks')) {
                $prop = $reflection->getProperty('downloadLinks');
                $filtered = $format->getDownloadLinks()->filter(fn ($f) => $f->getCustomer() === $customer);
                $prop->setValue($format, $filtered);
            }
        }

        return $this->render('bookshelf/index.html.twig', [
            'controller_name' => 'BookshelfController',
            'myFormats' => $myFormats,
            'customer' => $customer,
        ]);
    }
}
