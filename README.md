# ArtFlow

## Description

Artflow est un projet réalisé en groupe lors la formation CDA chez PrepAvenir. Cette application est une galerie d'images qui permet de voir, partager, télécharger et comenter des images.

## Installation

Pour installer Artflow, vous avez besoin de composer et symfony.
Après avoir cloné le repository sur votre machine locale, ouvrez un terminal et tappez les ligne de code suivante :

```bash
composer install
```

Cela permet d'installer les dépendances de l'application.

Après avoir installé les dépendances, il est nécessaire d'initialiser la base de données de l'application.
Vous pouvez le faire en utilisant la commande suivante :

```bash
symfony console doctrine:database:create
```

ensuite, pour creer les migrations :

```bash
symfony console make:migration
```

Pour appliquer les migrations à la base de données :

```bash
symfony console doctrine:migrations:migrate
```

enfin, il faut charger les fixtures générées par faker dans la base de données :

```bash
symfony console doctrine:fixtures:load
```

## Auteurs

- Johan Yindou - [GitHub](https://github.com/JohanYindou)
- Alexandre Viegas - [GitHub](https://github.com/rAlexandreViegas)
- Michel Bondonga - [GitHub](https://github.com/michelbdg)
