<?php

namespace App\DataFixtures;

use App\Enum\BasketStatus;
use App\Factory\BasketFactory;
use App\Factory\BookFactory;
use App\Factory\BoSkCoFactory;
use App\Factory\CategoryFactory;
use App\Factory\ContributorFactory;
use App\Factory\EditorFactory;
use App\Factory\FeedbackFactory;
use App\Factory\FormatFactory;
use App\Factory\KeyWordFactory;
use App\Factory\OrderFactory;
use App\Factory\OrderStatusFactory;
use App\Factory\PaymentFactory;
use App\Factory\SkillFactory;
use App\Factory\TvaFactory;
use App\Factory\TypeFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        KeyWordFactory::createMany(75);

        SkillFactory::createSequence([
            ['name' => 'Auteur'],
            ['name' => 'Lecteur'],
            ['name' => 'Préfacier'],
            ['name' => 'Illustrateur'],
        ]);

        TypeFactory::createSequence([
            ['name' => 'Audio', 'typeImg' => 'headphones'],
            ['name' => 'eBook', 'typeImg' => 'book'],
        ]);

        $manager->flush();

        TvaFactory::createSequence([
            ['taux' => '5.5'],
            ['taux' => '20.00'],
        ]);

        $manager->flush();

        CategoryFactory::createSequence([
            ['name' => 'Classiques'],
            ['name' => 'Roman noir'],
            ['name' => 'Romance'],
            ['name' => 'Fantasy, SF'],
            ['name' => 'Roman historique'],
            ['name' => 'Théâtre'],
            ['name' => 'Contes et nouvelles'],
            ['name' => 'Poésie'],
            ['name' => 'Jeunesse'],
            ['name' => 'Essais, témoignage'],
            ['name' => 'Biographies'],
            ['name' => 'Sport et bien-être'],
        ]);

        PaymentFactory::createSequence([
            ['mode' => 'Carte Bancaire'],
            ['mode' => 'Paypal'],
            ['mode' => 'Virement'],
        ]);

        OrderStatusFactory::createSequence([
            ['status' => 'En attente'],
            ['status' => 'Échoué'],
            ['status' => 'Paiement accepté'],
        ]);

        EditorFactory::createCustomEditors();
        
        UserFactory::createCustomUsers();

        ContributorFactory::createCustomContributors();
        
        $manager->flush();


        // Vérifier qu'on a bien des Types et des TVA avant de les utiliser
        if (TypeFactory::count() === 0 || TvaFactory::count() === 0) {
            throw new \Exception("Les entités Type et Tva doivent exister avant de créer des Formats.");
        }

        BookFactory::createMany(36);

        $manager->flush();

        FormatFactory::new();

        $books = BookFactory::all();
        $auteurSkill = SkillFactory::find(['name' => 'Auteur']);
        $otherSkills = array_filter(
            SkillFactory::all(),
            fn ($s) => $s->getName() !== 'Auteur'
        );
        
        // Générer les liaisons BoSkCo
        foreach ($books as $book) {
            $contributor = ContributorFactory::random();
            $usedContributorIds[] = $contributor->getId();

            BoSkCoFactory::createOne([
                'book' => $book,
                'contributor' => $contributor,
                'skill' => $auteurSkill,
            ]);
        
            // Ajout optionnel d'autres skills
            $count = random_int(0, 3);
            for ($i = 0; $i < $count; $i++) {
                // Filtrer les contributeurs déjà utilisés
                $availableContributors = array_filter(
                    ContributorFactory::all(),
                    fn ($c) => !in_array($c->getId(), $usedContributorIds)
                );

                // Si plus aucun contributeur dispo, on stoppe
                if (empty($availableContributors)) {
                    break;
                }

                // Sélection aléatoire
                $contributor = $availableContributors[array_rand($availableContributors)];
                $usedContributorIds[] = $contributor->getId();

                $skill = $otherSkills[array_rand($otherSkills)];
        
                BoSkCoFactory::createOne([
                    'book' => $book,
                    'contributor' => $contributor,
                    'skill' => $skill,
                ]);
            }
        }

        BasketFactory::createMany(40);

        // Créer une commande pour chaque panier transformé
        $transformedBaskets = BasketFactory::repository()->findBy(['status' => BasketStatus::TRANSFORMED]);

        foreach ($transformedBaskets as $basket) {
            OrderFactory::createOne([
                'totalHT' => $basket->getTotalHT(),
                'totalTTC' => $basket->getTotalTTC(),
                'customer' => $basket->getCustomer(),
                'basket' => $basket, // si Order a une relation vers Basket
            ]);
        }

        FeedbackFactory::createMany(30);
        
        $manager->flush();
    }
}
