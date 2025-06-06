<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Entity\Format;
use App\Entity\User;
use App\Form\FeedBackType;
use App\Repository\FeedbackRepository;
use App\Repository\FormatRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class FeedbacksController extends AbstractController
{
    #[Route('/myFeedbacks', name: 'my_feedbacks')]
    public function showMyFeedbacks(FeedbackRepository $feedbackRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur requis.');// @codeCoverageIgnore
        }
        $myComments = $feedbackRepository->findMyComments($user);
        
        return $this->render('feedbacks/feedbacks.html.twig', [
            'controller_name' => 'FeedbacksController',
            'my_comments' => $myComments,
        ]);
    }

    #[Route('/feedbacks/add/{id}', name: 'feedback_add')]
    public function createFeedback(
        ?Feedback $feedback,
        Request $request,
        EntityManagerInterface $manager,
        Format $format,
        UserRepository $userRepository
    ): Response {
        $customer = $this->getUser();
        if (!$customer instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur requis.');// @codeCoverageIgnore
        }
        $feedback = new Feedback();
        $feedbackUser = $userRepository->findFormatOrdered($format, $customer);
        $this->denyAccessUnlessGranted('OWNER_ACCESS', $feedbackUser);
        $feedback->setFormat($format);
        $feedback->setNickName($customer);
        $form = $this->createForm(FeedBackType::class, $feedback);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($feedback);
            $manager->flush();
            
            return $this->redirectToRoute('bookshelf');
        }

        return $this->render('feedbacks/addFeedbackForm.twig', [
            'controller_name' => 'FeedbacksController',
            'form' => $form,
        ]);
    }

    #[Route('/feedbacks/edit/{id}', name: 'feedback_edit', requirements: ['id' => '\d+'])]
    public function updateFeedback(
        ?Feedback $feedback,
        Request $request,
        EntityManagerInterface $manager,
    ): Response {
        $customer = $this->getUser();
        if (!$customer instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur requis.');// @codeCoverageIgnore
        }
        $feedback ??= new Feedback();
        $this->denyAccessUnlessGranted('OWNER_ACCESS', $feedback);

        $feedback->setNickName($customer);

        $form = $this->createForm(FeedBackType::class, $feedback);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($feedback);
            $manager->flush();
            
            return $this->redirectToRoute('my_feedbacks');
        }

        return $this->render('feedbacks/addFeedbackForm.twig', [
            'controller_name' => 'FeedbacksController',
            'form' => $form,
        ]);
    }
}
