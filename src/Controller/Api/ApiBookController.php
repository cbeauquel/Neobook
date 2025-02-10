<?php

namespace App\Controller\Api;

use App\Entity\Book;
use OpenApi\Attributes as OA;
use App\Repository\BookRepository;
use OpenApi\Attributes\JsonContent;
use App\Repository\BoSkCoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use Symfony\Contracts\Cache\ItemInterface;
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

class ApiBookController extends AbstractController
{
    /**
     * Cette méthode permet de récupérer l'ensemble des livres.
     *
     */
    #[Route('/api/books', name: 'api_book', methods:['GET'])]
      #[OA\Response(
          response:200,
          description:'Retourne la liste des livres',
          content: new JsonContent(
             type:'array',
             items: new OA\Items(ref: new Model(type:Book::class, groups: ['getBooks']))
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

      #[OA\Tag(name:'Books')]
    public function getBookList(
        ?BookRepository $bookRepository, 
        SerializerInterface $serializer, 
        Request $request, 
        TagAwareCacheInterface $cachePool
    ): JsonResponse
    {
        // Récupérer la version à partir de l'en-tête "Accept"
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        $idCache = "getAllBooks-" . $page . "-" . $limit;
        
        $jsonBookList = $cachePool->get($idCache, function (ItemInterface $item) use ($bookRepository, $page, $limit, $serializer, $request)
        {
            // $version = $this->getVersionFromRequest($request);
            $item->tag("booksCache");
            $item->expiresAfter(1);
            $bookList = $bookRepository->findPaginatedBooks($page, $limit);          

            return $serializer->serialize($bookList, 'json', ['groups' => 'getBooks']);
        });

        return new JsonResponse($jsonBookList, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/api/book/{id}', name: 'api_book_detail', requirements:['id' => '\d+'], methods:['GET'])]
    /**
     * Cette méthode permet de récupérer un livre en fonction de son ID.
     *
     */

    #[OA\Response(
        response:200,
        description:'Retourne la liste d\'un livre en fonction de son ID',
        content: new OA\JsonContent(
           type:'array',
           items: new OA\Items(ref: new Model(type:Book::class, groups: ['getBooks']))
        )
    )]
    #[OA\Tag(name:'Books')]
    public function getBookDetail(Book $bookDetail, SerializerInterface $serializer, Request $request): JsonResponse
    {
        // $version = $this->getVersionFromRequest($request);
        $jsonBookDetail = $serializer->serialize($bookDetail, 'json', ['groups' => ['getBooks', 'getBook']]);
        return new JsonResponse($jsonBookDetail, JsonResponse::HTTP_OK, ['accept' => 'json'], true);
    }

    #[IsGranted('ROLE_ADMIN', message:'Vous n\'avez pas les droits suffisants pour agir sur un livre')]
    #[Route('/api/book/{id}', name: 'book_delete', requirements:['id' => '\d+'], methods:['DELETE'])]
    /**
     * Cette méthode permet de supprimer un livre (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Books')]

    public function deleteBook(?Book $book, EntityManagerInterface $manager, TagAwareCacheInterface $cachePool): JsonResponse
    {
        $cachePool->invalidateTags(["booksCache"]);
        $manager->remove($book);
        $manager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[IsGranted('ROLE_ADMIN', message:'Vous n\'avez pas les droits suffisants pour agir sur un livre')]
    #[Route('/api/books', name: 'book_post', methods:['POST'])]
    /**
     * Cette méthode permet d'ajouter un livre (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Books')]

    public function postBook(
        EntityManagerInterface $manager, 
        SerializerInterface $serializer, 
        Request $request, 
        UrlGeneratorInterface $urlGenerator,
        BoSkCoRepository $boSkCoRepository,
        ValidatorInterface $validator
        ): JsonResponse
    {
        $book = $serializer->deserialize($request->getContent(), Book::class, 'json');
       
        //on vérifie les erreurs
        $errors = $validator->validate($book);

        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $content = $request->toArray();
        $idBoSkCo = $content['idBoSkCo'] ?? -1;

        $book->setBoSkCo($boSkCoRepository->find($idBoSkCo));

        $manager->persist($book);
        $manager->flush();
        $jsonBook = $serializer->serialize($book, 'json', ['groups' => 'getBooks']);

        $location = $urlGenerator->generate('book_detail', ['id' => $book->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonBook, JsonResponse::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/book/{id}', name: 'book_update', requirements:['id' => '\d+'], methods:['PUT'])]
    /**
     * Cette méthode permet de modifier un livre (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Books')]

    public function updateBook(
        EntityManagerInterface $manager, 
        SerializerInterface $serializer, 
        Request $request, 
        BoSkCoRepository $boskcoRepository,
        Book $currentBook,
        ValidatorInterface $validator
        ): JsonResponse
    {
        $book = $serializer->deserialize($request->getContent(), 
                                            Book::class, 
                                            'json',
                                            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentBook]);

                                                    //on vérifie les erreurs
        $errors = $validator->validate($book);

        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $content = $request->toArray();
        $idBoSkCo = $content['idBoSkCo'] ?? -1;
        $book->setBoSkCo($boskcoRepository->find($idBoSkCo));

        $manager->persist($book);
        $manager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
  
    }

    private function getVersionFromRequest(Request $request): string
    {
        // Exemple de détection de version dans l'en-tête "Accept"
        $acceptHeader = $request->headers->get('Accept', '');
        if (str_contains($acceptHeader, 'application/vnd.api+json;version=2')) {
            return 'v2';
        }
        return 'v1'; // Valeur par défaut
    }
}

