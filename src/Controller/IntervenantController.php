<?php

namespace App\Controller;

use App\Entity\Intervenant;
use App\Form\IntervenantType;
use App\Repository\IntervenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/intervenant')]
class IntervenantController extends AbstractController
{
    #[Route('/', name: 'app_intervenant_index', methods: ['GET'])]
    public function index(IntervenantRepository $intervenantRepository): Response
    {
        return $this->render('intervenant/index.html.twig', [
            'intervenants' => $intervenantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_intervenant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $intervenant = new Intervenant();
        $form = $this->createForm(IntervenantType::class, $intervenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($intervenant);
            $entityManager->flush();

            return $this->redirectToRoute('app_intervenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intervenant/new.html.twig', [
            'intervenant' => $intervenant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_intervenant_show', methods: ['GET'])]
    public function show(Intervenant $intervenant): Response
    {
        return $this->render('intervenant/show.html.twig', [
            'intervenant' => $intervenant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_intervenant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intervenant $intervenant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IntervenantType::class, $intervenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_intervenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intervenant/edit.html.twig', [
            'intervenant' => $intervenant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_intervenant_delete', methods: ['POST'])]
    public function delete(Request $request, Intervenant $intervenant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intervenant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($intervenant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_intervenant_index', [], Response::HTTP_SEE_OTHER);
    }
}
