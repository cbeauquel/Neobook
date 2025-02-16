<?php

namespace App\Controller\Api;

use App\Entity\Editor;
use OpenApi\Attributes as OA;
use App\Repository\EditorRepository;
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

class ApiEditorController extends AbstractController
{
    /**
     * Cette méthode permet de récupérer l'ensemble des editeurs.
     *
     */
    #[Route('/api/editors', name: 'api_editor', methods:['GET'])]
      #[OA\Response(
          response:200,
          description:'Retourne la liste des editeurs',
          content: new JsonContent(
             type:'array',
             items: new OA\Items(ref: new Model(type:Editor::class, groups: ['getEditors']))
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

      #[OA\Tag(name:'Editors')]
    public function getEditorList(
        ?EditorRepository $editorRepository, 
        SerializerInterface $serializer, 
        Request $request, 
        TagAwareCacheInterface $cachePool
    ): JsonResponse
    {
        // Récupérer la version à partir de l'en-tête "Accept"
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        $idCache = "getAllEditors-" . $page . "-" . $limit;
        
        $jsonEditorList = $cachePool->get($idCache, function (ItemInterface $item) use ($editorRepository, $page, $limit, $serializer, $request)
        {
            // $version = $this->getVersionFromRequest($request);
            $item->tag("EditorsCache");
            $item->expiresAfter(1);
            $editorList = $editorRepository->findPaginatedEditors($page, $limit);          

            return $serializer->serialize($editorList, 'json', ['groups' => 'getEditors']);
        });

        return new JsonResponse($jsonEditorList, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/api/editor/{id}', name: 'api_editor_detail', requirements:['id' => '\d+'], methods:['GET'])]
    /**
     * Cette méthode permet de récupérer un editeur en fonction de son ID.
     *
     */
    #[OA\Response(
        response:200,
        description:'Retourne un editeur en fonction de son ID',
        content: new OA\JsonContent(
           type:'array',
           items: new OA\Items(ref: new Model(type:Editor::class, groups: ['getEditors']))
        )
    )]
    #[OA\Tag(name:'Editors')]
    public function getEditorDetail(Editor $editorDetail, SerializerInterface $serializer, Request $request): JsonResponse
    {
        // $version = $this->getVersionFromRequest($request);
        $jsonEditorDetail = $serializer->serialize($editorDetail, 'json', ['groups' => ['getEditors', 'getEditor']]);
        return new JsonResponse($jsonEditorDetail, JsonResponse::HTTP_OK, ['accept' => 'json'], true);
    }

    #[IsGranted('ROLE_ADMIN', message:'Vous n\'avez pas les droits suffisants pour agir sur un editeur')]
    #[Route('/api/editor/{id}', name: 'editor_delete', requirements:['id' => '\d+'], methods:['DELETE'])]
    /**
     * Cette méthode permet de supprimer un editeur (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Editors')]

    public function deleteEditor(?Editor $editor, EntityManagerInterface $manager, TagAwareCacheInterface $cachePool): JsonResponse
    {
        $cachePool->invalidateTags(["EditorsCache"]);
        $manager->remove($editor);
        $manager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[IsGranted('ROLE_ADMIN', message:'Vous n\'avez pas les droits suffisants pour agir sur un editeur')]
    #[Route('/api/editors', name: 'editor_post', methods:['POST'])]
    #[OA\RequestBody(
        required: true,
        content:new OA\JsonContent(ref: new Model(type: Editor::class, groups: ['getEditors', 'getEditor']))
    )]

    /**    * Cette méthode permet d'ajouter un editeur (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Editors')]

    public function postEditor(
        EntityManagerInterface $manager, 
        SerializerInterface $serializer, 
        Request $request, 
        UrlGeneratorInterface $urlGenerator,
        BoSkCoRepository $boSkCoRepository,
        ValidatorInterface $validator
        ): JsonResponse
    {
        $editor = $serializer->deserialize($request->getContent(), Editor::class, 'json');
       
        //on vérifie les erreurs
        $errors = $validator->validate($editor);

        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $content = $request->toArray();
        $idBoSkCo = $content['idBoSkCo'] ?? -1;

        $editor->setBoSkCo($boSkCoRepository->find($idBoSkCo));

        $manager->persist($editor);
        $manager->flush();
        $jsonEditor = $serializer->serialize($editor, 'json', ['groups' => 'getEditors']);

        $location = $urlGenerator->generate('editor_detail', ['id' => $editor->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonEditor, JsonResponse::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/editor/{id}', name: 'editor_update', requirements:['id' => '\d+'], methods:['PUT'])]
    #[OA\RequestBody(
        required: true,
        content:new OA\JsonContent(ref: new Model(type: Editor::class, groups: ['getEditors', 'getEditor']))
    )]

    /**
     * Cette méthode permet de modifier un editeur (uniquement pour les profils admin)'.
     *
     */
    #[OA\Tag(name:'Editors')]

    public function updateEditor(
        EntityManagerInterface $manager, 
        SerializerInterface $serializer, 
        Request $request, 
        Editor $currentEditor,
        ValidatorInterface $validator
        ): JsonResponse
    {
        $editor = $serializer->deserialize($request->getContent(), 
                                            Editor::class, 
                                            'json',
                                            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentEditor]);

                                                    //on vérifie les erreurs
        $errors = $validator->validate($editor);

        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $manager->persist($editor);
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

