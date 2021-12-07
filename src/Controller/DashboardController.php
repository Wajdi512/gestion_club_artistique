<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Coach;
use App\Entity\Seance;
use App\Form\SeanceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="app_dashboard")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        return $this->render('dashboard/index.html.twig', [
            'lesSeances' => $entityManager->getRepository(Seance::class)->
            findAll(),
        ]);
    }
}
