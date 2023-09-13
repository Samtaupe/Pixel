<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game')]
    public function index(GameRepository $repository): Response
    {
        $entities = $repository->findAll(); // SELECT * FROM game

        return $this->render('game/index.html.twig', [
            'entities' => $entities, // Envois de tous les jeux dans le vue
        ]);
    }

    // Injection de dépendance: SF va m'envoyer les objets dont j'ai besoin en paramètre
    #[Route('/game/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $entity = new Game();
        $entity->setName('Megaman');
        $entity->setDescription('');

        // Indique à Doctrine de prendre en charge cet objet
        // Prepare la requête
        $entityManager->persist($entity);

        $entityManager->flush(); // Exécute la requête

        return $this->render('game/index.html.twig', []);
    }
}
