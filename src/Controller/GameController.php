<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $entity = new Game();
        /* $entity->setName('Megaman');
        $entity->setDescription(''); */

        //Chargement du formulaire et envois de l'entité game pour initialiser les données
        $form = $this->createForm(GameType::class, $entity);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $entityManager->persist($entity);
            $entityManager->flush(); // Exécute la requête
            return $this->redirectToRoute('app_game_index');
        }




        return $this->render('game/new.html.twig', [
            'gameForm' => $form->createView(),
        ]);
    }
    
    #[Route('/game/{id<\d+>}/edit')]
    public function edit(Game $entity, Request $request, EntityManagerInterface $em):Response
    {
        $form = $this->createForm(GameType::class, $entity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('app_game_index');
        }

        return $this->render('game/edit.html.twig', [
            'gameForm' => $form->createView(),
        ]);
    }

    #[Route('/game/{id<\d+>}/delete')]
    public function delete(Game $entity, Request $request, EntityManagerInterface $em):Response
    {
        if($request->getMethod() === Request::METHOD_POST){
            if($this->isCsrfTokenValid('delete_game', $request->get('_token'))){
                $em->remove($entity);
                $em->flush();

                return $this->redirectToRoute('app_game_index');

            }
        }
        return $this->render('game/delete.html.twig', [
            'entity' => $entity,
        ]);
    }

}
