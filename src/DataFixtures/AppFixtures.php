<?php

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\BoSkCoFactory;
use App\Factory\CategoryFactory;
use App\Factory\ContributorFactory;
use App\Factory\EditorFactory;
use App\Factory\FormatFactory;
use App\Factory\KeyWordsFactory;
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
        KeyWordsFactory::createMany(75);

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

        BookFactory::createMany(36, fn () => [
            'categories' => CategoryFactory::randomRange(0, 3),
            'editor' => EditorFactory::random(),
            'boSkCos' => BoSkCoFactory::new()->range(1, 4),
            'keyWords' => KeyWordsFactory::new()->range(1, 5),
            'formats' => FormatFactory::new()->range(1, 2),
        ]);

        $manager->flush();

        FormatFactory::new()
        ->create(fn () => [
            'type' => TypeFactory::random(),
            'tvaRate' => TvaFactory::random(),
            'book' => BookFactory::random(),
        ]);

        $manager->flush();

        BoSkCoFactory::new()
            ->create(fn () => [
                'book' => BookFactory::random(),
                'contributor' => ContributorFactory::random(),
                'skill' => SkillFactory::random(),
            ]);

        $manager->flush();
    }
}
