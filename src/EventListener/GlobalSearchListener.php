<?php
namespace App\EventListener;

use App\Service\SearchFormProvider;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

#[AsEventListener(event: KernelEvents::CONTROLLER, method: '__invoke')]
final class GlobalSearchListener
{
    private SearchFormProvider $searchFormProvider;
    private Environment $twig;

    public function __construct(SearchFormProvider $searchFormProvider, Environment $twig)
    {
        $this->searchFormProvider = $searchFormProvider;
        $this->twig = $twig;
    }

    public function __invoke(ControllerEvent $event): void
    {
        // Vérifiez que l'événement est lié à une requête principale (non sous-requête)
        if (!$event->isMainRequest()) {
            return;
        }

        // Créez le formulaire de recherche global
        $searchForm = $this->searchFormProvider->getSearchForm();

        // Rendez le formulaire disponible globalement dans les templates Twig
        $this->twig->addGlobal('global_search_form', $searchForm);
    }
}