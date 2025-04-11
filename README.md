
<img src="assets\img\interface\logo.png" alt="CritiPixel" width="200" />

# Neobook
Librairie en ligne Neobook v2

## Pré-requis
* PHP >= 8.2
* Composer
* Symfony (binaire)

## Installation

### Composer
Dans un premier temps, installer les dépendances :
```bash
composer install
```

## Configuration

### Base de données
Vous pouvez créer un fichier `.env.local` si nécessaire pour configurer l'accès à la base de données.
Exemple :
```dotenv
DATABASE_URL=mysql://root@127.0.0.1:3306/neobook?serverVersion=8.0.32&charset=utf8mb4
```

## Usage

### Base de données

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
 
### Docker 
Si vous utiliser Docker Compose pour meilisearch (moteur de recherche), il vous suffit de lancer la commande suivante :
```bash
docker compose up -d
```
```