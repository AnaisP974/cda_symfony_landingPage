<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
