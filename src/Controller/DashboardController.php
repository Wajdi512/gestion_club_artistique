<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Coach;
use App\Entity\Seance;
use App\Form\SeanceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'lesActivites' => $entityManager->getRepository(Activite::class)->findAll(),
            'lesCoachs' => $entityManager->getRepository(Coach::class)->findAll()
        ]);
    }

    /**
     * @Route("/search", name="search_dashboard")
     */
    public function search(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $activiteId = $request->query->get('activiteId');
        $coachId = $request->query->get('coachId');
        $criteres = [];
        if ($coachId != 0) {
            $criteres['coach'] = $coachId;
        }
        if ($activiteId != 0) {
            $criteres['activite'] = $activiteId;
        }
        $lesSeances = [];
        if (count($criteres) > 0) {
            $lesSeances = $entityManager->getRepository(Seance::class)
                ->findBy($criteres);
        } else {
            $lesSeances = $entityManager->getRepository(Seance::class)->findAll();
        }
        //dd($criteres);
        return $this->render('dashboard/index.html.twig', [
            'lesSeances' => $lesSeances,
            'lesActivites' => $entityManager->getRepository(Activite::class)->findAll(),
            'lesCoachs' => $entityManager->getRepository(Coach::class)->findAll()
        ]);
    }
}
