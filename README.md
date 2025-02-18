# TP PHP MVC / Git

:warning: Les fichier .env sont normalement dans le gitignore mais pour le bien de la notation il sera inlcu dans le repo
La structure du projet est un framework créer par mes soins

## Installation

1. **Cloner le dépôt**

   ```sh
   git clone https://github.com/Furrioxx/TP.git
   cd PHP-TP
   ```

2. **Installer les dépendances avec Composer**

   ```sh
   composer install
   ```

3. **Créer la base de donnée**

   Dans le repo se trouve le fichier sql pour créer la base de donnée

## Structure du projet

- **controller/** : Contient les controllers pour gérer les requêtes.
- **repository/** : Contient les repositories pour interagir avec les données.
- **template/** : Contient les vues pour l'affichage.

## Elements techniques

Les vues sont géré par [Twig](https://github.com/twigphp/Twig)

Ce projet utilise [**phpdotenv**](https://github.com/vlucas/phpdotenv) pour la gestion des variables d'environnement.

Le projet implement aussi [Bootstrap](https://getbootstrap.com)

j'ai utilisé twig et bootstrap pour la rapidité et la simplicité pour créer des vues

Git à été utilisé

Un commit à été réalisé pour chaque feature, fix...

Dans un environnement professionnel la création de branches aurait été nécéssaire

# Options supplémentaires

- implémentation d'alertes pour les utilisateurs
- case "remember me" lors du login

## Contributeur

- Tom PELUD
