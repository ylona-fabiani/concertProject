<?php

namespace App\Controller;

use App\Entity\Artists;
use App\Form\ArtistsType;
use App\Repository\ArtistsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artists")
 */
class ArtistsController extends AbstractController
{
    /**
     * @Route("/", name="artists_index", methods={"GET"})
     */
    public function index(ArtistsRepository $artistsRepository): Response
    {
        return $this->render('artists/index.html.twig', [
            'artists' => $artistsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="artists_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artist = new Artists();
        $form = $this->createForm(ArtistsType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('artists_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artists/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="artists_show", methods={"GET"})
     */
    public function show(Artists $artist): Response
    {
        return $this->render('artists/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artists_edit", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Artists $artist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtistsType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bands = $form->get("bands")->getData();
            foreach ($bands as $band) {
                $band->addMember($artist);
            }

            $entityManager->flush();

            return $this->redirectToRoute('artists_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artists/edit.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="artists_delete", methods={"POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Artists $artist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $entityManager->remove($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artists_index', [], Response::HTTP_SEE_OTHER);
    }
}
