# Gestionnaire de tâches d'équipe — Groupe 13

Projet de fin de cours **« Projet d'initiation aux frameworks »** — Laravel, MySQL, Blade et Bootstrap 5.  
IFRI — UAC · Filière GL 3 · Année académique 2026-2027 · Enseignante : Maryse GAHOU

Application web permettant à une petite équipe d'organiser son travail : créer, consulter, modifier et supprimer des tâches, leur affecter un responsable, une échéance et un statut, puis suivre l'avancement grâce à des compteurs et des filtres.

---

## Sujet attribué

**Sujet A — Gestionnaire de tâches d'équipe.**

> Créer une application pour organiser le travail d'une petite équipe : créer, modifier et supprimer des tâches ; préciser leur responsable, leur échéance et leur statut ; filtrer les tâches par statut ou responsable ; afficher un résumé du travail (tâches à faire, en cours et terminées).

## Membres du groupe

| Membre | Rôle principal |
|---|---|
| **Djamal ALIDOU MADOUGOU** (Djam) | Back-end : socle Laravel, configuration, base de données MySQL, modèle, contrôleur, routes, seeders |
| **Saka Yazid Cédric YAROU** (Yazid) | Front-end et qualité : layout Blade, pages, assets, tests, documentation |

---

## Fonctionnalités réalisées

- **CRUD complet** des tâches : création, consultation, modification et suppression.
- **Champs métier** : titre, description facultative, responsable, date d'échéance et statut.
- **Trois statuts** : *À faire*, *En cours*, *Terminée*, avec badges colorés.
- **Résumé du travail** : quatre compteurs (total, à faire, en cours, terminées).
- **Recherche par titre** et **filtres par statut et par responsable**, avec bouton de réinitialisation.
- **Tri par échéance** croissante dans la liste.
- **Validation côté serveur** : titre et responsable obligatoires, longueurs maximales, date valide, statut autorisé ; les erreurs sont affichées **en français** sous chaque champ et les valeurs saisies sont conservées.
- **Messages compréhensibles** : confirmation après création, modification ou suppression, et message « Aucune tâche trouvée » lorsque la liste est vide.
- **Interface responsive** (Bootstrap 5) utilisable sur téléphone et ordinateur, avec navigation claire et lien actif.
- **Données de démonstration réalistes** : 5 tâches réparties dans les trois statuts, avec échéances passées et futures.
- **Tests fonctionnels** couvrant l'affichage, les filtres, la recherche, la validation et le CRUD.
- **Base de données MySQL** créée par migrations Laravel ; un script SQL est fourni en alternative pour phpMyAdmin.

### Pages de l'application

| Page | URL | Rôle |
|---|---|---|
| Liste des tâches | `/tasks` | Compteurs, recherche, filtres, tableau des tâches |
| Création | `/tasks/create` | Formulaire de création |
| Détail | `/tasks/{id}` | Consultation d'une tâche |
| Modification | `/tasks/{id}/edit` | Formulaire de modification |

La racine `/` redirige automatiquement vers `/tasks`.

### Routes Laravel

```text
GET|HEAD  /                    → redirection vers /tasks
GET|HEAD  /tasks               tasks.index    TaskController@index
POST      /tasks               tasks.store    TaskController@store
GET|HEAD  /tasks/create        tasks.create   TaskController@create
GET|HEAD  /tasks/{task}        tasks.show     TaskController@show
PUT|PATCH /tasks/{task}        tasks.update   TaskController@update
DELETE    /tasks/{task}        tasks.destroy  TaskController@destroy
GET|HEAD  /tasks/{task}/edit   tasks.edit     TaskController@edit
```

---

## Choix techniques

- **Laravel 13 / PHP 8.3+** : framework imposé par le cours, exploité selon le modèle **MVC**.
- **MySQL exclusivement** : la base est configurée sur le pilote `mysql` (`config/database.php`, `.env.example`) et créée par les migrations Laravel.
- **Routes RESTful** : `Route::resource('tasks', TaskController::class)` centralise les sept routes du CRUD et garde `routes/web.php` lisible.
- **Contrôleur unique `TaskController`** : il porte la logique de liste, de recherche, de filtrage et du CRUD ; les modèles restent responsables des données.
- **Modèle Eloquent `Task`** :
  - constante `STATUSES` pour éviter les valeurs de statut dispersées dans le code ;
  - `$fillable` pour l'assignation de masse ;
  - cast `due_date` en date pour formater les échéances ;
  - accesseurs `status_label` et `status_badge` pour l'affichage et la couleur Bootstrap.
- **Validation** dans les méthodes `store` et `update` avec `$request->validate()` et `Rule::in()` ; aucune règle métier n'est dupliquée dans les vues.
- **Messages de validation en français** : `lang/fr/validation.php` traduit les règles et fait correspondre les noms techniques aux libellés de l'interface (`due_date` → « date d'échéance », `responsible` → « responsable », etc.), conformément à `APP_LOCALE=fr`.
- **Vues Blade** organisées autour d'un layout commun (`layouts/app.blade.php`) et d'un formulaire partagé (`tasks/_form.blade.php`) réutilisé par la création et la modification.
- **Bootstrap 5 via CDN** : interface responsive sans étape de build front-end ; l'application se lance avec PHP et MySQL uniquement.
- **Seeders** : `TaskSeeder` insère des données de démonstration réalistes ; `DatabaseSeeder` l'appelle pour que `php artisan migrate --seed` suffise.
- **Script SQL d'appoint** (`database/sql/creation_bdd.sql`) : permet d'importer la base et les données directement dans phpMyAdmin (XAMPP) si l'on ne souhaite pas utiliser les migrations.
- **Tests PHPUnit** dans `tests/Feature/TaskTest.php`, avec `RefreshDatabase` sur une base MySQL de test dédiée.

---

## Structure du projet

```text
app/
├── Http/Controllers/
│   ├── Controller.php
│   └── TaskController.php        # Liste, filtres, CRUD
├── Models/
│   ├── Task.php                  # Modèle Eloquent, statuts, accesseurs
│   └── User.php
├── Providers/AppServiceProvider.php
bootstrap/
config/
├── app.php
├── database.php                  # Connexion MySQL
└── auth.php, cache.php, ...
database/
├── factories/UserFactory.php
├── migrations/
│   ├── ..._create_users_table.php
│   ├── ..._create_cache_table.php
│   ├── ..._create_jobs_table.php
│   └── 2026_11_01_025840_create_tasks_table.php
├── seeders/
│   ├── DatabaseSeeder.php
│   └── TaskSeeder.php            # 5 tâches de démonstration
└── sql/
    └── creation_bdd.sql          # Import alternatif phpMyAdmin
resources/
├── css/app.css
├── js/app.js
└── views/
    ├── layouts/app.blade.php     # Layout, navigation, messages
    └── tasks/
        ├── index.blade.php       # Compteurs, filtres, tableau
        ├── create.blade.php
        ├── edit.blade.php
        ├── show.blade.php
        └── _form.blade.php       # Formulaire partagé
routes/
└── web.php
lang/
└── fr/
    └── validation.php            # Messages de validation en français
tests/Feature/TaskTest.php
```

### Schéma de la table `tasks`

| Colonne | Type | Contrainte |
|---|---|---|
| `id` | BIGINT UNSIGNED | clé primaire, auto-incrément |
| `title` | VARCHAR(255) | requis |
| `description` | TEXT | facultatif |
| `responsible` | VARCHAR(100) | requis |
| `due_date` | DATE | requis |
| `status` | VARCHAR(20) | requis, défaut `a_faire` |
| `created_at` / `updated_at` | TIMESTAMP | gérés par Laravel |

---

## Prérequis

- **PHP 8.3** ou supérieur, avec les extensions `pdo_mysql`, `mbstring`, `openssl`, `fileinfo` et `tokenizer`.
- **Composer**.
- **MySQL 8** ou **MariaDB** (par exemple via XAMPP et phpMyAdmin).
- Un terminal (PowerShell, cmd ou Bash).

> Node.js et npm ne sont pas nécessaires pour lancer l'application : l'interface utilise Bootstrap 5 via CDN.

---

## Installation et lancement

### 1. Récupérer le projet

```bash
git clone <URL_DU_DEPOT>
cd TP_LARAVEL
composer install
```

### 2. Créer le fichier d'environnement

Sous Windows :

```powershell
copy .env.example .env
```

Sous Linux / macOS :

```bash
cp .env.example .env
```

Puis générer la clé applicative :

```bash
php artisan key:generate
```

### 3. Créer la base MySQL

Dans phpMyAdmin (XAMPP) ou en ligne de commande MySQL :

```sql
CREATE DATABASE gestionnaire_taches
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

Vérifier ensuite la configuration de `.env` :

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestionnaire_taches
DB_USERNAME=root
DB_PASSWORD=
```

Adapter `DB_USERNAME` et `DB_PASSWORD` à votre installation MySQL.

### 4. Créer les tables et charger les données de démonstration

```bash
php artisan migrate --seed
```

Pour repartir de zéro (supprime les tables puis les recrée) :

```bash
php artisan migrate:fresh --seed
```

### 5. Lancer l'application

```bash
php artisan serve
```

Ouvrir ensuite : **http://127.0.0.1:8000** (ou http://localhost:8000). La racine redirige vers la liste des tâches.

### Alternative : import SQL via phpMyAdmin

1. Créer la base `gestionnaire_taches` (ou laisser le script la créer).
2. Dans phpMyAdmin, onglet **Importer**, choisir `database/sql/creation_bdd.sql`.
3. Lancer uniquement `php artisan serve` : la table et les 5 tâches de démonstration sont déjà créées.

---

## Tests

Les tests utilisent une base MySQL de test séparée, indiquée dans `phpunit.xml` : `gestionnaire_taches_test`.

Créer cette base une seule fois :

```sql
CREATE DATABASE gestionnaire_taches_test
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

Puis lancer :

```bash
php artisan test
```

Les tests couvrent la redirection de la racine, l'affichage de la liste et des compteurs, le filtre par statut, la recherche par titre, la validation des champs obligatoires, ainsi que la création, la modification et la suppression d'une tâche.

---

## Utilisation rapide

1. Ouvrir **Liste des tâches** : les quatre compteurs résument l'état du travail.
2. Cliquer sur **Ajouter une tâche**, remplir le formulaire et valider : un message de confirmation s'affiche.
3. Utiliser **Recherche**, **Statut** et **Responsable**, puis **Filtrer** ; **Effacer** réinitialise la liste.
4. Cliquer sur **Voir** pour consulter une tâche, ou **Modifier** pour la mettre à jour.
5. Cliquer sur **Supprimer** et confirmer : la tâche disparaît et un message de succès s'affiche.

---

## Démonstration (5 à 7 minutes)

1. Présenter le sujet, le modèle MVC et les quatre pages.
2. Montrer les compteurs et le tableau de la liste.
3. Créer une tâche, puis provoquer une erreur de validation pour montrer les messages.
4. Filtrer par statut et par responsable, rechercher par titre, puis réinitialiser.
5. Consulter, modifier puis supprimer une tâche.
6. Expliquer un choix technique (routes RESTful, validation, accesseurs du modèle) et un problème rencontré avec sa solution.

---

## Remarques

- La base de données est **MySQL uniquement** ; elle est créée par les migrations Laravel.
- Aucun service externe, paiement ou envoi réel de courriel n'est utilisé.
- Les données de démonstration peuvent être rechargées à tout moment avec `php artisan migrate:fresh --seed`.
