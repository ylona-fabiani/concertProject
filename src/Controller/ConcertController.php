<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use App\Repository\ConcertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/concert")
 */
class ConcertController extends AbstractController
{
    /**
     * @Route("/", name="concert_index", methods={"GET"})
     */
    public function index(ConcertRepository $concertRepository): Response
    {
        return $this->render('concert/index.html.twig', [
            'concerts' => $concertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="concert_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $concert = new Concert();
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($concert);
            $entityManager->flush();

            return $this->redirectToRoute('concert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('concert/new.html.twig', [
            'concert' => $concert,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="concert_show", methods={"GET"})
     */
    public function show(Concert $concert): Response
    {
        return $this->render('concert/show.html.twig', [
            'concert' => $concert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="concert_edit", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Concert $concert, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('concert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('concert/edit.html.twig', [
            'concert' => $concert,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="concert_delete", methods={"POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Concert $concert, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$concert->getId(), $request->request->get('_token'))) {
            $entityManager->remove($concert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('concert_index', [], Response::HTTP_SEE_OTHER);
    }
}
