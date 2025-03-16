<?php


namespace App\Service;

use App\Form\SearchFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;

class SearchFormProvider
{
    // Injection du FormFactoryInterface via le constructeur
    public function __construct(private readonly FormFactoryInterface $formFactory)
    {
    }

    public function getSearchForm(): FormView
    {
        $form = $this->formFactory->create(SearchFormType::class, null, [
            'method' => 'GET',
            'action' => '/search', // Chemin où envoyer la requête
        ]);

        return $form->createView();
    }
}
