<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Coach;
use App\Entity\Seance;
use App\Form\SeanceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class SeanceController extends AbstractController
{
    /**
     * @Route("/seance", name="ajout_seance")
     * Method({"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $coachs = $entityManager->getRepository(Coach::class)->findAll();
        $activites = $entityManager->getRepository(Activite::class)->findAll();
        $form = $this->createForm(SeanceType::class, new Seance(new \DateTime(), new \DateTime(), $coachs[0], $activites[0]));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = 'Activité crée avec succés';
            $seance = $form->getData();
            $entityManager->persist($seance);
            $entityManager->flush();
        }
        return $this->render('seance/index.html.twig', [
            'form' => $form->createView(),
            'lesSeances' => $entityManager->getRepository(Seance::class)->
            findAll(),
        ]);

    }

    /**
     * @Route("/activite/delete/activite/{idAct}/coach/{idCoach}", name="supprimer_activite")
     * Method({"GET", "DELETE"})
     */
    public function deleteSeance(Request $request, $idAct,$idCoach): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Seance::class);
        $seance = $repo->find(['activite' => $idAct, 'coach' => $idCoach]);
        $entityManager->remove($seance);
        $entityManager->flush();
        return $this->redirectToRoute('ajout_seance', ['succesDelete' => '1']);
    }


}
