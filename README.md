# Projet : Le Bestiaire de l'Apocalypse

## Contexte

Ce projet a été réalisé dans le cadre de la soutenance pour la formation Développeur d'Application Web 2024/2025. L'objectif est de créer une application permettant de gérer et de consulter un codex de créatures, de leurs habitats, ainsi que des zones sécurisées dans un contexte d'apocalypse.

## Contraintes

Le projet a été conçu en tenant compte des contraintes suivantes :

- **Accessibilité** : Intégration de l'accessibilité web avec des attributs ARIA.
- **Architecture MVC** : Utilisation du modèle de conception Model-View-Controller pour structurer l'application.
- **Technologies** : 
  - JavaScript (JS) pour l'interactivité.
  - PHP pour la gestion côté serveur.
- **Gestion de médias** : Importation de polices, images.
- **Administration CRUD** : Fonctionnalités d'administration permettant de gérer les entités du projet (Monstre, Habitat, Zone, etc.).

## Description du projet

Le projet s'inscrit dans un contexte apocalyptique où le gouvernement souhaite mettre à disposition un codex répertoriant les créatures monstrueuses, leurs habitats et les zones sécurisées. L'application permet aux utilisateurs de consulter ce codex, de filtrer les informations et de naviguer dans des cartes interactives représentant les zones de sécurité.

## Fonctionnement

### Côté Utilisateur

L'utilisateur peut :

- **Accéder au Bestiaire** : Une galerie affichant les monstres.
- **Accéder aux Cartes** : Affichage des cartes des zones sécurisées et des habitats des créatures.
- **Accéder au Glossaire** : Liste des mots-clés et leurs définitions.
- **Créer un compte** : Inscription pour un accès personnalisé.
- **Se connecter / Se déconnecter** : Accès authentifié à certaines fonctionnalités.
- **Utiliser la recherche** : Rechercher des monstres, habitats ou zones par nom.

Dans le **Bestiaire** :

- Les monstres sont affichés par grade ou via un organigramme depuis l'icône.
- Un système de filtres permet de trier les créatures.
- Un clic sur une carte ouvre une fenêtre modale avec les détails du monstre.

Dans les **Cartes** :

- L'utilisateur peut sélectionner une carte pour afficher les positions sur la carte des habitats et des zones sûres.
- L'interface permet de décocher des cases pour masquer certains éléments.
- Un sélecteur de monstres permet de visualiser les habitats dans lesquels les créatures peuvent vivre.

Le **Glossaire** affiche des mots-clés avec leurs définitions.

La **fonction de recherche** permet de rechercher des valeurs dans les noms des monstres, des habitats et des zones. Dans une future version (V2), la recherche inclura également les compétences des monstres.

### Partie Administration

Si l'utilisateur possède un rôle **Administrateur**, il peut :

- Ajouter des **slides** au slideshow en fonction des monstres inscrits dans le codex.
- **Ajouter / Modifier / Supprimer** des monstres.
- **Ajouter / Modifier / Supprimer** des grades, des types et des compétences.
- **Ajouter / Modifier / Supprimer** des habitats et des zones sûres.
- **Ajouter / Modifier / Supprimer** des mots-clés.

Lors de la création d'un monstre, l'utilisateur a la possibilité de découper une image dans l'en-tête de la modale.
Lors de la création / mise-à-jour d'un habitat ou d'une zone sûre, l'utilisateur a la possibilité de cliquer sur les cartes pour définir la position.
## Features à venir (V2)

- **Système de favoris** : Permettre aux utilisateurs connectés de marquer leurs monstres préférés.
- **Tchat** : Ajout d'une fonctionnalité de tchat pour les utilisateurs connectés.
- **Amélioration des filtres** : Optimisation et enrichissement des options de filtrage.
- **Amélioration de l'interface** : Amélioration de l'UX/UI pour rendre l'application plus intuitive.
- **Raccourcis clavier** : Ajout de raccourcis pour faciliter la navigation.
- **Découpage d'images optimisé** : Les images des monstres seront automatiquement découpées sous plusieurs formats pour une meilleure performance d'affichage.
- **Modification des images** : Permettre la modification des images existantes.
- **Galerie de photos** : Ajouter plusieurs photos pour chaque créature.
- **Filtres pour les habitats** : Ajout de filtres pour les habitats dans la section "Cartes" côté utilisateur.

## Installation

1. Clonez ce dépôt sur votre machine locale :
   ```bash
   git clone https://github.com/votre-utilisateur/votre-projet.git
