# Création d'un landing page

Rendez-vous sur ce dépôt GitHub : [Landing Page](https://github.com/Jensone/sf-00)

Téléchargez le projet et ouvrez-le dans VS Code (ou autre).

## Installation des dépendances PHP 8.3

Pour commencer, il faut installer les dépendances PHP. Pour cela, il faut exécuter la commande suivante dans votre terminal :

```bash
composer install
```

## Lancement du serveur web

Pour lancer le serveur web, il faut exécuter la commande suivante dans votre terminal :

```bash
symfony serve
```

Si la commande `symfony serve` n'est pas reconnue, optez pour la commande suivante :

```bash
php -S localhost:8000 -t public public/index.php
```

## Créer une page

Pour créer une page, nous avons besoin d'un contrôleur et d'une vue. Pour cela, il faut exécuter la commande suivante dans votre terminal :

```bash
php bin/console make:controller Home
```

Cela va créer un contrôleur dans le dossier `src/Controller`. Son nom c'est `HomeController.php`.
La vue va être créée dans le dossier `templates/home/index.html.twig`.

Rendez-vous sur votre navigateur à l'adresse `http://localhost:8000/home` et vous devriez voir la page qui a été crée.

## Modifier le contenu de la page

Dans le template (la vue), vous allez modifier son contenu avec celui-ci :

```
{% extends 'base.html.twig' %}

{% block title %}Landing Page{% endblock %}

{% block body %}
    <main class="bg-gradient-to-r from-neutral-50 to-neutral-100 h-screen flex flex-col items-center justify-center">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-neutral-800">
                Welcome to my Landing Page
            </h1>
            <p class="mt-4 text-2xl text-neutral-500">
                I'm <span class="font-bold text-orange-800">{{ name ?? 'Nobody'}}</span>, a web developer.
            </p>
            <p class="mt-4 text-xl text-neutral-500">
                This is a landing page template for a personal website.
            </p>
        </div>
    </main>
{% endblock %}
```

---

Pause commit : enregistrez ce que vous avez fait jusqu'à maintenant.

```bash
git add .
git commit -m "Mise à jour du template de la page Home"
```

---

## Ajouter des données dynamiques

"Nobody" est le nom par défaut. Modifiez-le sans toucher au code du template. Pour cela, on passe par le controlleur `HomeController.php`.

```php
# src/Controller/HomeController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/{name}', name: 'home', methods: ['GET'])] // Ceci est une annotation PHP, ici elle permet de définir une route pour le contrôleur et ses paramètres.
    public function index(): Response // Ceci est le contrôleur qui va être appelé lorsque l'utilisateur accède à la page '/'
    {
        $name = ''; // Nous allons l'envoyer à la vue.
        return $this->render('home/index.html.twig', [ // La méthode render() de la classe AbstractController permet de renvoyer un template avec des données.
            'name' => $name ?? 'Nobody', // Si le paramètre n'est pas renseigné, on lui donne un nom par défaut.
        ]);
    }
}

```

Rendez-vous sur votre navigateur à l'adresse `http://localhost:8000/`.

---

Pause commit : enregistrez ce que vous avez fait jusqu'à maintenant.

```bash
# Dans le terminal de commande
git add .
git commit -m "Récupération des paramètres de la route et renvoi du template avec les données"
```

## Afficher des données de la base de données

Il y a une liste de prénoms et noms de personnes dans la base de données. Vous allez les afficher de la manière suivante :

1. Mettez à jour le contrôleur `HomeController.php` pour qu'il récupère les données de la base de données.

```php
# src/Controller/HomeController.php
namespace App\Controller;

// ...

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])] // Ceci est une annotation PHP, ici elle permet de définir une route pour le contrôleur et ses paramètres.
    public function index(PersonRepository $pr): Response // Ceci est le contrôleur qui va être appelé lorsque l'utilisateur accède à la page '/'
    {
        $name = 'Alex'; // À l'aide de la classe Request de HttpFoundation, on peut récupérer les paramètres de la route.
        return $this->render('setting/index.html.twig', [ // La méthode render() de la classe AbstractController permet de renvoyer un template avec des données.
            'name' => $name ?? 'Nobody', // Si le paramètre n'est pas renseigné, on lui donne un nom par défaut.
            'people' => $pr->findAll(), // On récupère tous les personnages dans la base de données.
        ]);
    }
}
```

2. Bouclez sur les données de la base de données pour afficher les noms et prénoms.

```
# src/templates/setting/index.html.twig
{% extends 'base.html.twig' %}
//...
{% block body %}
    <main class="bg-gradient-to-r from-neutral-50 to-neutral-100 h-screen flex flex-col items-center justify-center">
        //...
        <ul class="mt-4 text-neutral-500 flex flex-wrap gap-4 max-w-md mx-auto">
            {% for person in people %}
                <li class="px-2 py-1 mb-2 rounded-full bg-orange-300 text-neutral-800 text-center">
                    {{ person.name }} {{ person.lastName }}
                </li>
            {% endfor %}
        </ul>
    </main>
{% endblock %}
```

Allez voir le résultat sur votre navigateur à l'adresse `http://localhost:8000/`.

---

## Félicitations !

Vous avez édité votre premier projet Symfony.

Maintenant, découvrons comment créer un projet de zéro avec pour thème une application de partage de notes, "CodeXpress".
