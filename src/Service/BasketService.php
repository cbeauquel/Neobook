<?php 

namespace App\Service;

use App\Entity\User;
use App\Entity\Basket;
use App\Entity\Format;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Psr\Log\LoggerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node\Expr\Cast\Array_;

class BasketService
{ 
    private $requestStack;
    private $manager;
    private $logger;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $manager, LoggerInterface $logger = null)
    {
        $this->requestStack = $requestStack;
        $this->manager = $manager;
        $this->logger = $logger; // Logger optionnel pour suivre les erreurs
    }

    /**
     * Sauvegarde le panier de la session dans la base de données.
     */
    public function persistBasket(?User $customer = null): void
    {      
        // Récupérer ou créer un panier en base
        $bddBasket = $this->getOrCreateBddBasket($customer);
        $idBasket = $bddBasket->getId();
        // dd($bddBasket);
        // Récupérer les formats en base et en session
        //on isole les formats du panier
        $bddBasketFormats = $this->loadBasketFormats($idBasket);
        $sessionBasket = $this->getOrCreateSessionBasket();

        // Pour chaque format du panier en session on vérifie s'il existe dans le panier en base. Sinon on l'ajoute au panier en base
        foreach($sessionBasket as $sessionFormat){
            // Vérifier si le produit est déjà dans le panier
            $exists = $bddBasketFormats->exists(fn($key, $item) => $item->getId() === $sessionFormat->getId());
            if(!$exists){
                $bddBasketFormats->add($sessionFormat);
            }
        }

        // SUPPRIMER les formats qui ne sont plus dans la session
        foreach ($bddBasketFormats as $bddFormat) {
            if (!$sessionBasket->exists(fn($key, $item) => $item->getId() === $bddFormat->getId())) {
                $bddBasketFormats->removeElement($bddFormat);
            }
        }

        // on injecte la nouvelle liste de formats dans le panier en base
        $bddBasket->setFormats($bddBasketFormats);
       
        // Sauvegarder le panier en base
        $this->manager->persist($bddBasket);
        $this->manager->flush();
    }

    public function loadBasket(?User $customer): ?Basket
    {        
        // Récupérer ou créer un panier en base
        $session = $this->getSession();
        $userToken = $session->getId();

        $bddBasket = $this->manager->getRepository(Basket::class)->findBasketByCustomerOrUserToken($customer, $userToken);

        return $bddBasket;
    }

    public function loadBasketFormats($bddBasketId): ArrayCollection
    {        
        // Récupérer ou créer un panier en base
        $basketFormats = $this->manager->getRepository(Format::class)->findFormatsByBasketId($bddBasketId);
        return $basketFormats;
    }

    public function getOrCreateSessionBasket(): ArrayCollection
    {
        $session = $this->getSession();
        return $session->get('basket', new ArrayCollection());
    }

    public function saveBasket(ArrayCollection $sessionBasket)
    {
        // Sauvegarde du panier mis à jour dans la session
        $this->getSession()->set('basket', $sessionBasket);
    }

    public function addToBasket(array  $formats)
    {
        $sessionBasket = $this->getOrCreateSessionBasket();
        foreach($formats as $format){
            // Vérifier si le produit est déjà dans le panier
            $exists = $sessionBasket->exists(fn($key, $item) => $item->getId() === $format->getId());
            if(!$exists){
                $sessionBasket->add($format);
            }
        }
        $this->saveBasket($sessionBasket);
    }

    public function removeToBasket(object $formatToRemove)
    {
        $sessionBasket = $this->getOrCreateSessionBasket();
        foreach ($sessionBasket as $format) {
            if ($format->getId() === $formatToRemove->getId()) {
                $sessionBasket->removeElement($format);
                break; // On sort de la boucle dès qu'on a trouvé l'élément
            }
        }
        $this->saveBasket($sessionBasket);
    }

    /**
     * Récupérer un panier existant en base donnée ou en créer un nouveau.
     */
    private function getOrCreateBddBasket(?User $customer = null): Basket
    {
        $session = $this->getSession();
        $userToken = $session->getId();
        
        $basket = $this->manager->getRepository(Basket::class)->findBasketByCustomerOrUserToken($customer, $userToken);
        // Créer un panier s'il n'existe pas
        if (!$basket) {
            $basket = new Basket();
            if ($customer) {
                $basket->setCustomer($customer);
            } else {
                $basket->setUserToken($session->getId());
            }
        } else {
            if ($customer) {
                $basket->setCustomer($customer);
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