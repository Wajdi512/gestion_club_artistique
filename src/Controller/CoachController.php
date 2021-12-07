<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Form\CoachType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{


    /**
     * @Route("/coach", name="ajout_caoch")
     * Method({"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $message = "";
        $succesDelete = $request->query->get("succesDelete");
        if ($succesDelete != null && $succesDelete == "1") {
            $message = 'Coach supprimé avec succés';
        }
        $request->query->remove("succesDelete");
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $entityManager = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = 'Coach crée avec succés';
            $coach = $form->getData();
            $entityManager->persist($coach);
            $entityManager->flush();
        }
        return $this->render('coach/index.html.twig', [
            'form' => $form->createView(),
            'lesCoachs' => $entityManager->getRepository(Coach::class)->
            findAll(),
            'message' => $message
        ]);
    }


    /**
     * @Route("/coach/delete/{id}", name="supprimer_coach")
     * Method({"GET", "DELETE"})
     */
    public function deleteCoach(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Coach::class);
        $coach = $repo->find($id);
        $entityManager->remove($coach);
        $entityManager->flush();
        $form = $this->createForm(CoachType::class, new Coach());
        return $this->redirectToRoute('ajout_caoch', ['succesDelete' => '1']);
    }


    /**
     * @Route("/coach/edit/{id}", name="edit_coach")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $message = "";
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Coach::class);
        $coach = $repo->find($id);
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);
        if ($coach != null && $form->isSubmitted() && $form->isValid()) {
            $message = 'Coach modifié avec succés';
            $coach = $form->getData();
            $entityManager->persist($coach);
            $entityManager->flush();
        }
        return $this->render('coach/update.html.twig', [
            'form' => $form->createView(),
            'message' => $message
        ]);
    }

}
