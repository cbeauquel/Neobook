<?php

namespace App\Controller\Api;

use App\Entity\Contributor;
use OpenApi\Attributes as OA;
use App\Repository\ContributorRepository;
use OpenApi\Attributes\JsonContent;
use App\Repository\BoSkCoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Contracts\Cache\ItemInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiContributorController extends AbstractController
{
    /**
     * Cette méthode permet de récupérer l'ensemble des contributeurs.
     *
     */
    #[Route('/api/contributors', name: 'api_contributor', methods:['GET'])]
      #[OA\Response(
          response:200,
          description:'Retourne la liste des contributeurs',
          content: new JsonContent(
             type:'array',
             items: new OA\Items(ref: new Model(type:Contributor::class, groups: ['getContributors']))
          )
      )]
      #[OA\Parameter(
          name:'page',
          in:'query',
          description:'La page que l\'on veut récupérer',
          schema: new OA\Schema(type:'int')
      )]
      #[OA\Parameter(
          name:'limit',
          in:'query',
          description:'Le nombre d\'éléments que l\'on veut récupérer',
          schema: new OA\Schema(type:'int')
      )]

      #[OA\Tag(name:'Contributors')]
    public function getContributorList(
        ?ContributorRepository $contributorRepository, 
        SerializerInterface $serializer, 
        Request $request, 
        TagAwareCacheInterface $cachePool
    ): JsonResponse
    {
        // Récupérer la version à partir de l'en-tête "Accept"
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        $idCache = "getAllcontributors-" . $page . "-" . $limit;
        
        $jsoncontributorList = $cachePool->get($idCache, function (ItemInterface $item) use ($contributorRepository, $page, $limit, $serializer, $request)
        {
            // $version = $this->getVersionFromRequest($request);
            $item->tag("contributorsCache");
            $item->expiresAfter(1);
            $contributorList = $contributorRepository->findPaginatedcontributors($page, $limit);          

            return $serializer->serialize($contributorList, 'json', ['groups' => 'getContributors']);
        });

        return new JsonResponse($jsoncontributorList, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/api/contributor/{id}', name: 'api_contributor_detail', requirements:['id' => '\d+'], methods:['GET'])]
    /**
     * Cette méthode permet de récupérer un contributeur en fonction de son ID.
     *
     */
    #[OA\Response(
        response:200,
        description:'Retourne un contributeur en fonction de son ID',
        content: new OA\JsonContent(
           type:'array',
           items: new OA\Items(ref: new Model(type:Contributor::class, groups: ['getContributors']))
        )
    )]
    #[OA\Tag(name:'Contributors')]
    public function getContributorDetail(Contributor $contributorDetail, SerializerInterface $serializer, Request $request): JsonResponse
    {
        // $version = $this->getVersionFromRequest($request);
        $jsoncontributorDetail = $serializer->serialize($contributorDetail, 'json', ['groups' => ['getContributors', 'getContributor']]);
        return new JsonResponse($jsoncontributorDetail, JsonResponse::HTTP_OK, ['accept' => 'json'], true);
    }

    #[IsGranted('ROLE_ADMIN', message:'Vous n\'avez pas les droits suffisants pour agir sur un contributeur')]
    #[Route('/api/contributor/{id}', name: 'contributor_delete', requirements:['id' => '\d+'], methods:['DELETE'])]
    /**
     * Cette méthode permet de supprimer un contributeur (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Contributors')]

    public function deleteContributor(?Contributor $contributor, EntityManagerInterface $manager, TagAwareCacheInterface $cachePool): JsonResponse
    {
        $cachePool->invalidateTags(["contributorsCache"]);
        $manager->remove($contributor);
        $manager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[IsGranted('ROLE_ADMIN', message:'Vous n\'avez pas les droits suffisants pour agir sur un contributeur')]
    #[Route('/api/contributors', name: 'contributor_post', methods:['POST'])]
    /**    * Cette méthode permet d'ajouter un contributeur (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Contributors')]

    public function postContributor(
        EntityManagerInterface $manager, 
        SerializerInterface $serializer, 
        Request $request, 
        UrlGeneratorInterface $urlGenerator,
        BoSkCoRepository $boSkCoRepository,
        ValidatorInterface $validator
        ): JsonResponse
    {
        $contributor = $serializer->deserialize($request->getContent(), contributor::class, 'json');
       
        //on vérifie les erreurs
        $errors = $validator->validate($contributor);

        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $content = $request->toArray();
        $idBoSkCo = $content['idBoSkCo'] ?? -1;

        $contributor->setBoSkCo($boSkCoRepository->find($idBoSkCo));

        $manager->persist($contributor);
        $manager->flush();
        $jsoncontributor = $serializer->serialize($contributor, 'json', ['groups' => 'getContributors']);

        $location = $urlGenerator->generate('contributor_detail', ['id' => $contributor->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsoncontributor, JsonResponse::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/contributor/{id}', name: 'contributor_update', requirements:['id' => '\d+'], methods:['PUT'])]
    /**
     * Cette méthode permet de modifier un contributeur (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Contributors')]

    public function updatecontributor(
        EntityManagerInterface $manager, 
        SerializerInterface $serializer, 
        Request $request, 
        BoSkCoRepository $boskcoRepository,
        contributor $currentcontributor,
        ValidatorInterface $validator
        ): JsonResponse
    {
        $contributor = $serializer->deserialize($request->getContent(), 
                                            contributor::class, 
                                            'json',
                                            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentcontributor]);

                                                    //on vérifie les erreurs
        $errors = $validator->validate($contributor);

        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $content = $request->toArray();
        $idBoSkCo = $content['idBoSkCo'] ?? -1;
        $contributor->setBoSkCo($boskcoRepository->find($idBoSkCo));

        $manager->persist($contributor);
        $manager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
  
    }

    // private function getVersionFromRequest(Request $request): string
    // {
    //     // Exemple de détection de version dans l'en-tête "Accept"
    //     $acceptHeader = $request->headers->get('Accept', '');
    //     if (str_contains($acceptHeader, 'application/vnd.api+json;version=2')) {
    //         return 'v2';
    //     }
    //     return 'v1'; // Valeur par défaut
    // }
}

