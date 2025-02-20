<?php 

namespace App\Service;

use App\Entity\User;
use App\Entity\Basket;
use App\Entity\Format;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Common\Collections\ArrayCollection;

class BasketService
{ 
    private $requestStack;
    private $manager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $manager)
    {
        $this->requestStack = $requestStack;
        $this->manager = $manager;
    }
   
    /**
     * Si un user se connecte, vérifier si un panier est en base et mettre à jour avec les nouveaux formats
     */
    public function persistBasket(?User $customer = null): void
    {
        // Récupérer un nouveau panier en base s'il y en a un       
        $bddBasketOld = $this->loadBasket($customer);
        $session = $this->getSession();
        $userToken = $session->getId();
        $bddBasketNew = $this->manager->getRepository(Basket::class)->findBasketByUserToken($userToken);

        if($bddBasketOld && $bddBasketNew){
            $this->manager->getRepository(Basket::class)->bulkUpdateBasketsToAbandoned($customer);
        } 
        if(!$this->getSessionBasket()->isEmpty()){
            $this->getOrCreateBddBasket($customer);
        }
    }

    /**
     * Ajoute un format au panier en session et synchronise avec la BDD
     */
    public function addToBasket(array $formats, ?User $customer = null)
    {
        $sessionBasket = $this->getSessionBasket();

        foreach($formats as $format){
            // Vérifier si le produit est déjà dans le panier
            $exists = $sessionBasket->exists(fn($key, $item) => $item->getId() === $format->getId());
            if(!$exists){
                $sessionBasket->add($format);
            }
        }
        $this->saveBasket($sessionBasket);
        // Récupérer ou créer un panier en base
        $bddBasket = $this->getOrCreateBddBasket($customer);
        // dd($customer);
        $idBasket = $bddBasket->getId();
        // Récupérer les formats en base et en session
        $bddBasketFormats = $this->loadBasketFormats($idBasket);
        // Pour chaque format du panier en session on vérifie s'il existe dans le panier en base. Sinon on l'ajoute au panier en base
        foreach($sessionBasket as $sessionFormat){
            // Vérifier si le produit est déjà dans le panier
            $exists = $bddBasketFormats->exists(fn($key, $item) => $item->getId() === $sessionFormat->getId());
            if(!$exists){
                $bddBasketFormats->add($sessionFormat);
            }
        }      

        // on injecte la nouvelle liste de formats dans le panier en base
        $bddBasket->setFormats($bddBasketFormats);
        // dd($bddBasket);
        // Sauvegarder le panier en base
        $this->manager->persist($bddBasket);
        $this->manager->flush();
    }

    /**
     * Supprime un format du panier en session et synchronise avec la BDD
     */
    public function removeToBasket(object $formatToRemove,?User $customer)
    {
        $sessionBasket = $this->getSessionBasket();
        foreach ($sessionBasket as $format) {
            if ($format->getId() === $formatToRemove->getId()) {
                $sessionBasket->removeElement($format);
                break; // On sort de la boucle dès qu'on a trouvé l'élément
            }
        }
        $this->saveBasket($sessionBasket);
        // Récupérer ou créer un panier en base
        $bddBasket = $this->loadBasket($customer);
        if($bddBasket){
            $idBasket = $bddBasket->getId();
            // Récupérer les formats en base et en session
            //on isole les formats du panier
            $bddBasketFormats = $this->loadBasketFormats($idBasket);
            // dd($sessionBasket);
            // SUPPRIMER les formats qui ne sont plus dans la session
            foreach ($bddBasketFormats as $bddFormat) {
                if (!$sessionBasket->exists(fn($key, $item) => $item->getId() === $bddFormat->getId())) {
                    $bddBasketFormats->removeElement($bddFormat);
                }
            }
        
            //s'il n'y a plus de formats dans le panier, on supprime le panier sinon on injecte la nouvelle liste de formats dans le panier en base
            if($bddBasketFormats->isEmpty()){
                $this->manager->remove($bddBasket);
            } else {
                $bddBasket->setFormats($bddBasketFormats);
                // dd($bddBasket);
                // Sauvegarder le panier en base
                $this->manager->persist($bddBasket);
            }
            $this->manager->flush();
        }
    }

    /**
     * @return Basket retourne l'objet basket issu de la BDD sur interrogation de l'ID customer ou du UserToken (user non authentifié)
     */
    public function loadBasket(?User $customer): ?Basket
    {        
        // Récupérer un panier en base
        $session = $this->getSession();
        $userToken = $session->getId();

        $bddBasket = $this->manager->getRepository(Basket::class)->findBasketByCustomerOrUserToken($customer, $userToken);

        return $bddBasket;
    }

    
    /**
     * @return Basket retourne l'objet basket issu de la BDD sur interrogation du UserToken 
     */
    public function loadAllBaskets($userToken): ?Basket
    {        

        $oldBasket = $this->manager->getRepository(Basket::class)->findBasketByUserToken($userToken);

        return $oldBasket;
    }

    /**
     * @return ArrayCollection retourne les formats d'un panier en base sous forme d'arraycollection sur interrogation de l'id du panier
     */
    public function loadBasketFormats($bddBasketId): ArrayCollection
    {        
        // Récupérer ou créer un panier en base
        $basketFormats = $this->manager->getRepository(Format::class)->findFormatsByBasketId($bddBasketId);
        return $basketFormats;
    }

    /**
     * @return ArrayCollection retourne les formats stockés en session sous forme d'arraycollection, interrogation par ID de session
     */
    public function getSessionBasket(): ArrayCollection
    {
        $session = $this->getSession();
        return $session->get('basket', new ArrayCollection());
    }

    /**
     * Enregistre les changements dans le panier en session
     */
    public function saveBasket(ArrayCollection $sessionBasket)
    {
        // Sauvegarde du panier mis à jour dans la session
        $this->getSession()->set('basket', $sessionBasket);
    }

    /**
     * @return Basket Récupérer un panier existant en base donnée ou en créer un nouveau.
     */
    public function getOrCreateBddBasket(?User $customer = null): Basket
    {
        $session = $this->getSession();
        $userToken = $session->getId();
        $basket = $this->manager->getRepository(Basket::class)->findBasketByCustomerOrUserToken($customer, $userToken);
        // Créer un panier s'il n'existe pas
        if (!$basket) {
            $basket = new Basket();
            if ($customer) {
                $basket->setCustomer($customer);
                $basket->setUserToken($userToken);
            } else {
                $basket->setUserToken($userToken);
            }
        } else {
            if ($customer) {
                $basket->setCustomer($customer);
                $basket->setUserToken($userToken);
            }
        }
        $this->manager->persist($basket);
        $this->manager->flush();
        return $basket;
    }

    /**
     * Helper pour obtenir la session depuis le RequestStack.
     */
    private function getSession()
    {
        $session = $this->requestStack->getSession();
        if (!$session) {
            throw new \RuntimeException('No session available.');
        }

        return $session;
    }
}