# 📚 Gestion de bibliothèque

Application web de gestion d'une bibliothèque (PHP / MySQL / HTML / CSS) avec quatre espaces :
**utilisateur**, **bibliothécaire principal**, **bibliothécaire stagiaire** et **directeur**.

## Fonctionnalités

| Espace | Actions principales |
|---|---|
| **Utilisateur** | Inscription, connexion, lister les documents, consulter un exemplaire / un emprunt, emprunter, réserver |
| **Bibliothécaire principal** | Gestion des utilisateurs, documents, exemplaires, emprunts, relances, amendes, réservations, éditeurs, livres et périodiques, notifications |
| **Stagiaire** | Consulter / lister les utilisateurs, lister / modifier / consulter les emprunts, retourner un exemplaire, lister les bibliothécaires |
| **Directeur** | Ajouter, modifier, consulter, supprimer et lister les bibliothécaires |

## Structure du projet

```
gestion-bibliotheque/
├── index.html                  Page d'accueil (choix de l'espace)
├── pages/                      Pages publiques (vidéo, règles, à propos)
├── auth/                       Connexion, inscription, pages de bienvenue
├── utilisateur/                Espace utilisateur (index.html = menu)
├── bibliothecaire/             Espace bibliothécaire principal (index.html = menu)
│   ├── amendes/  documents/  editeurs/  emprunts/  exemplaires/
│   ├── livres-periodiques/  notifications/  relances/
│   └── reservations/  utilisateurs/
├── stagiaire/                  Espace stagiaire (index.html = menu)
├── directeur/                  Espace directeur (index.html = menu)
├── assets/                     css/  img/  video/
├── database/bibliotheque.sql   Schéma + données de démonstration
└── archive/                    Anciens brouillons non utilisés (voir plus bas)
```

Chaque sous-dossier de `bibliothecaire/` contient un `index.html` (menu du module)
et une page PHP par action.

## Installation (XAMPP / WAMP / Laragon)

1. Copier le dossier dans `htdocs` (XAMPP) ou `www` (WAMP).
2. Démarrer **Apache** et **MySQL**.
3. Importer `database/bibliotheque.sql` dans phpMyAdmin (il crée la base `bibliotheque`).
4. Ouvrir <http://localhost/gestion-bibliotheque/>.

**Connexion à la base** : chaque fichier PHP utilise `localhost` / `root` / mot de passe vide /
base `bibliotheque`. Si votre MySQL est configuré autrement, modifiez ces valeurs dans les fichiers `.php`.

## Comptes de démonstration

| Espace | Identifiant | Mot de passe |
|---|---|---|
| Directeur | `Directeur Demo` | `admin1234` |
| Bibliothécaire principal | `Principal Demo` | `demo1234` |
| Stagiaire | `Stagiaire Demo` | `demo1234` |
| Utilisateur | nom `Demo`, prénom `Utilisateur` | `user1234` |

> ⚠️ Données de test uniquement : à supprimer avant toute mise en ligne.

## Limites connues / pistes d'amélioration

- **Sécurité** : requêtes SQL construites par concaténation dans la plupart des fichiers
  (risque d'injection SQL) → passer aux requêtes préparées (déjà utilisées dans `directeur/`).
- **Mots de passe stockés en clair** → utiliser `password_hash()` / `password_verify()`.
- **Pas de sessions** : les pages d'un espace sont accessibles directement par leur URL
  sans être connecté → ajouter `session_start()` et un contrôle d'accès.
- **Identifiants MySQL dupliqués** dans ~60 fichiers → centraliser dans un fichier `config/`.
- **Statuts d'emprunt incohérents** : `en_retard` / `en retard`, `en_cours` / `en cours`
  selon les pages → à uniformiser.
- Menu stagiaire : « Vérifier les utilisateurs suspendus » et « Gérer le statut de l'emprunt »
  n'ont pas encore de page.
- `archive/` : brouillons de l'ancienne version (certains liens y pointent vers des pages
  qui n'existent plus). Conservés pour référence, à supprimer si inutiles.
