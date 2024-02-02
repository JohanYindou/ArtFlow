# ArtFlow

![Artflow](/public/images/logo.png)

## Description

Artflow est un projet réalisé en groupe lors de la formation CDA chez PrepAvenir. Cette application est une galerie d'images qui permet de voir, partager, télécharger et commenter des images.

## Installation

Pour installer Artflow, vous avez besoin de Composer et Symfony.
Après avoir cloné le dépôt sur votre machine locale, ouvrez un terminal et tapez les lignes de code suivantes :

```bash
composer install
```

Cela permet d'installer les dépendances de l'application.

Après avoir installé les dépendances, il est nécessaire d'initialiser la base de données de l'application.
Vous pouvez le faire en utilisant la commande suivante :
Si vous souhaitez changer SQLite en une autre base de données, modifiez le fichier .env en modifiant la variable DATABASE_URL.

```bash
symfony console doctrine:database:create
```

Ensuite, pour créer les migrations :

```bash
symfony console make:migration
```

Pour appliquer les migrations à la base de données :

```bash
symfony console doctrine:migrations:migrate
```

Enfin, il faut charger les fixtures générées par Faker dans la base de données :

```bash
symfony console doctrine:fixtures:load
```

## Architecture

Artflow est une application monolithique développée avec Symfony 5.7. L'architecture utilisée est basée sur un pattern MVC (Model-View-Controller). Vous pouvez trouver les sources sur le [GitHub](https://github.com/JohanYindou/ArtFlow).

L'architecture de l'application est basée sur une architecture monolithique avec une seule base de données.

Les entités sont situées dans le répertoire `src/Entity` et les repositories dans le répertoire `src/Repository` et les controllers dans le répertoire `src/Controller`.

Le repertoire `src/DataFixtures` contient les fixtures de l'application. Le repertoire `src/Form` contient les formulaires de l'application.

Le repertoire `src/Security` contient les classes de securite de l'application. Il est responsable de la gestion des droits d'accès aux différentes parties de l'application.

Le repertoire `templates` contient les templates de l'application. Les templates sont divisés en sous-répertoires qui correspondent aux différentes parties de l'application.

## Fonctionalitées

Depuis la page Home vous pouver acceder aux fonctionnalités de l'application suivantes :

- Créer et Se connecter à l'application
- Aller sur son profil (avec son nom et sa description et ses images)
- Upload une image
- Afficher une image
- Filtrer les images en fonction de leur catégories

Depuis la page Profile vous pouver acceder aux fonctionnalités de l'application suivantes :

- Modifier son username et votre description de profile.
- Afficher toutes ses images.

Depuis la page Image vous pouver acceder aux fonctionnalités de l'application suivantes :

- Ajouter des commentaires sur une image.
- Voir les commentaires d'une image avec le nom de l'auteur.

## Auteurs

Ce projet est reéalisé par :

- Johan Yindou - [GitHub](https://github.com/JohanYindou)
- Alexandre Viegas - [GitHub](https://github.com/rAlexandreViegas)
- Michel Bondonga - [GitHub](https://github.com/michelbdg)
