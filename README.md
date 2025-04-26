
<img src="assets\img\interface\logo.png" alt="neobook" width="200" />

# Neobook
Librairie en ligne Neobook v2

## Pré-requis
* PHP >= 8.2
* Composer
* Symfony (binaire)
* Docker (meilisearch)

## Installation

### Docker
pour installer Docker, se référer à la documentation de l'outil en fonction de son système d'exploitation : 
https://www.docker.com/get-started/ 


### Composer (installer composer si ce n'est pas déjà fait)
Dans un premier temps, installer les dépendances :
```bash
composer install
```

## Configuration

### Base de données
Vous pouvez créer un fichier `.env.local` pour configurer l'accès à la base de données.
Exemple :
```dotenv
DATABASE_URL=mysql://root@127.0.0.1:3306/neobook?serverVersion=8.0.32&charset=utf8mb4
```

## Usage

### Base de données

### Docker 
Une fois Docker installé, il vous suffit de lancer la commande suivante :
```bash
docker compose up -d
```

#### Supprimer la base de données
```bash
symfony console doctrine:database:drop --force --if-exists
```

#### Créer la base de données
 ```bash
 symfony console doctrine:database:create
 ```
 
 #### Exécuter les migrations
 ```bash
 symfony console doctrine:migrations:migrate -n
 ```
 
 #### Charger les fixtures
 ```bash
 symfony console doctrine:fixtures:load -n
 ```

#### Environnement de production
Pour utiliser le site en environnement de production, il faut :
- configurer le dossier public :
```bash
symfony console assets:install
```
```bash
symfony console asset-map:compile
```
- Installer le package pour apache :
```bash
composer require symfony/apache-pack
```
