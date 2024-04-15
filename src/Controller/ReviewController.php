<?php

namespace App\Controller;

use App\Entity\Intervenant;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\IntervenantRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/review')]
class ReviewController extends AbstractController
{
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_review_index', methods: ['GET'])]
    public function index(ReviewRepository $reviewRepository): Response
    {
        return $this->render('review/index.html.twig', [
            'reviews' => $reviewRepository->findAllSortedByDate()
        ]);
    }

    #[Route("/new/{intervenantid}", name: 'app_review_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, IntervenantRepository $intervenantRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $intervenant = $intervenantRepository->find($request->get('intervenantid'));
        if (!$intervenant->getClassesTaught()->contains($user->getClasse())) {
            $this->addFlash('danger', 'Vous ne pouvez pas commenter un intervenant qui n\'enseigne pas dans votre classe');
            return $this->redirectToRoute('app_intervenant_show', ['id'=> $request->get('intervenantid')], Response::HTTP_SEE_OTHER);
        }
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review, ['intervenant' => $intervenant, 'user'=>$user] );
        $form->handleRequest($request);
        $review->setAuthor($user);
        $review->setIntervenant($intervenant);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('app_intervenant_show', ['id'=> $request->get('intervenantid')], Response::HTTP_SEE_OTHER);
        }

        return $this->render('review/new.html.twig', [
            'review' => $review,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_review_show', methods: ['GET'])]
    public function show(Review $review): Response
    {
        return $this->render('review/show.html.twig', [
            'review' => $review,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_review_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Review $review, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Votre commentaire a été modifié avec succès');
            return $this->redirectToRoute('app_intervenant_show', ['id' => $review->getIntervenant()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('review/edit.html.twig', [
            'review' => $review,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_review_delete', methods: ['GET','DELETE'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $review = $entityManager->getRepository(Review::class)->find($request->get('id'));
        if ($this->security->getUser() === $review->getAuthor() || $this->security->isGranted('ROLE_ADMIN')) {
            $intervenantid = $review->getIntervenant()->getId();
            $entityManager->remove($review);
            $entityManager->flush();
            $this->addFlash('success', 'Votre commentaire a été supprimé avec succès');
        }
        $intervenantid = $review->getIntervenant()->getId();

        return $this->redirectToRoute('app_intervenant_show', ['id'=>$intervenantid], Response::HTTP_SEE_OTHER);

    }

    #[Route("/like/{id}", name: "like_review", methods: ["GET"])]
    #[IsGranted("ROLE_USER")]
    public function like(Review $review, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->getUser()->getLikedReviews()->contains($review)) {
            $this->getUser()->removeLikedReview($review);
            $review->setLikes($review->getLikes() - 1);
            $entityManager->flush();
            $this->addFlash('success', 'La review a été unlikée avec succès');
            return $this->redirect($request->headers->get('referer'));
        }
        if ($this->getUser()->getDislikedReviews()->contains($review)) {
            $this->getUser()->removeDislikedReview($review);
            $review->setDislikes($review->getDislikes() - 1);
        }
        $this->getUser()->addLikedReview($review);
        $review->setLikes($review->getLikes() + 1);
        $entityManager->flush();
        $this->addFlash('success', 'La review a été likée avec succès');
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route("/dislike/{id}", name: "dislike_review", methods: ["GET"])]
    #[IsGranted("ROLE_USER")]
    public function dislike(Review $review, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->getUser()->getDislikedReviews()->contains($review)) {
            $this->getUser()->removeDislikedReview($review);
            $review->setDislikes($review->getDislikes() - 1);
            $entityManager->flush();
            $this->addFlash('success', 'La review a été undislikée avec succès');
            return $this->redirect($request->headers->get('referer'));
        }
        if ($this->getUser()->getLikedReviews()->contains($review)) {
            $this->getUser()->removeLikedReview($review);
            $review->setLikes($review->getLikes() - 1);
        }
        $review->setDislikes($review->getDislikes() + 1);
        $this->getUser()->addDislikedReview($review);
        $entityManager->flush();
        $this->addFlash('success', 'La review a été dislikée avec succès');
        return $this->redirect($request->headers->get('referer'));
    }

}
