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

## Structure du projet

- **controller/** : Contient les controllers pour gérer les requêtes.
- **repository/** : Contient les repositories pour interagir avec les données.
- **template/** : Contient les vues pour l'affichage.

## Elements techniques

Les vues sont géré par [Twig](https://github.com/twigphp/Twig)

Ce projet utilise [**phpdotenv**](https://github.com/vlucas/phpdotenv) pour la gestion des variables d'environnement.

## Contributeur

- Tom PELUD
