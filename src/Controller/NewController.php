<?php

namespace App\Controller;

use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewController extends AbstractController
{
    #[Route('/new', name: 'app_new')]
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
    ): Response
    {
        $form = $this->createForm(TeamType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team = $form->getData();

            $entityManager->persist($team);
            $entityManager->flush();

            $this->addFlash('success', "{$team->getName()} successfully created!");

            return $this->redirectToRoute('app_index');
        }

        return $this->render('new/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
