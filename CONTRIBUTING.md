
# Guide de Contribution

Merci de l'intérêt que vous portez à notre librairie en ligne ! Nous sommes ravis que vous souhaitiez contribuer. Ce guide vous aidera à comprendre comment installer, configurer et contribuer à ce projet.

## Description du projet

Cette librairie en ligne permet aux lecteurs d’acheter des livres numériques au format epub et au format audio. Le design et le fonctionnement de cette librairie sont spécialement conçus pour être utilisés par des personnes ayant des troubles visuels ou de la lecture.

## Prérequis techniques

Pour contribuer à ce projet, vous aurez besoin des éléments suivants :

- PHP >= 8.2
- Composer
- Symfony (binaire)
- Docker (pour Meilisearch)

## Installation et configuration

Suivez ces étapes pour installer et configurer le projet localement :

1. **Lancer Docker pour Meilisearch :**
   Si vous utilisez Docker Compose pour Meilisearch (moteur de recherche), exécutez la commande suivante :
   ```bash
   docker compose up -d
   ```

2. **Supprimer la base de données existante :**
   ```bash
   symfony console doctrine:database:drop --force --if-exists
   ```

3. **Créer la base de données :**
   ```bash
   symfony console doctrine:database:create
   ```

4. **Exécuter les migrations :**
   ```bash
   symfony console doctrine:migrations:migrate -n
   ```

5. **Charger les fixtures :**
   ```bash
   symfony console doctrine:fixtures:load -n
   ```


## Lignes directrices de codage

Nous suivons les standards de codage PSR-12. Utilisez les outils suivants pour garantir la qualité du code :

- **ECS (Easy Coding Standard)**
- **Rector**
- **PHPStan**
- **Lint (yaml, container, twig)**

## Tests

Pour exécuter les tests, utilisez PHPUnit. Les tests incluent des tests unitaires et fonctionnels.

## Soumission des contributions

Chaque contribution passe par un pipeline d’intégration continue qui vérifie les éléments suivants :

1. **Audit de sécurité :** Vérifie les bundles pour détecter des failles de sécurité. Le test échoue si une faille est découverte.
2. **Qualité du code :** Analyse statique avec les outils mentionnés ci-dessus.
3. **Tests (PHPUnit) :** Tests unitaires et fonctionnels.

### Processus de contribution

1. **Créez une branche** pour votre contribution :
   ```bash
   git checkout -b feature/votre-contribution
   ```

2. **Faites vos modifications** et assurez-vous que tous les tests passent.

3. **Soumettez une pull request** en décrivant clairement vos modifications.

## Révision du code

Les contributions sont révisées par les mainteneurs du projet. Assurez-vous que votre code respecte les lignes directrices et passe tous les tests du pipeline d’intégration continue.

## Documentation

Les contributions doivent inclure une documentation appropriée et passer tous les tests du pipeline d’intégration continue.

## Licence

Ce projet est distribué sous la licence MIT.

## Contact et support

En cas de questions ou de problèmes, veuillez soumettre une issue sur GitHub.

