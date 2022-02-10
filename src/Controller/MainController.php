<?php

namespace App\Controller;

use App\Entity\Concert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ManagerRegistry $registry): Response
    {
        return $this->render('main/index.html.twig', [
            'next_concerts' => $registry->getRepository(Concert::class)->findNext(),
            'concerts' => $registry->getRepository(Concert::class)->findAll()
        ]);
    }
}
