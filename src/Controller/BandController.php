<?php

namespace App\Controller;

use App\Entity\Band;
use App\Form\BandType;
use App\Repository\BandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/band")
 */
class BandController extends AbstractController
{
    /**
     * @Route("/", name="band_index", methods={"GET"})
     */
    public function index(BandRepository $bandRepository): Response
    {
        return $this->render('band/index.html.twig', [
            'bands' => $bandRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="band_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($band);
            $entityManager->flush();

            return $this->redirectToRoute('band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('band/new.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="band_show", methods={"GET"})
     */
    public function show(Band $band): Response
    {
        return $this->render('band/show.html.twig', [
            'members' => $band->getMembers(),
            'band' => $band,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="band_edit", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Band $band, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concerts = $form->get('concerts')->getData();
            foreach ($concerts as $concert) {
                $concert->addBand($band);
            }

            $entityManager->flush();

            return $this->redirectToRoute('band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('band/edit.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="band_delete", methods={"POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Band $band, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$band->getId(), $request->request->get('_token'))) {
            $entityManager->remove($band);
            $entityManager->flush();
        }

        return $this->redirectToRoute('band_index', [], Response::HTTP_SEE_OTHER);
    }
}
