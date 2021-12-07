<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ActiviteController extends AbstractController
{

    /**
     * @Route("/activite", name="ajout_activite")
     * Method({"GET", "POST"})
     */
    public function ajoutActivite(Request $request): Response
    {
        $message = "";
        $succesDelete = $request->query->get("succesDelete");
        if ($succesDelete != null && $succesDelete == "1") {
            $message = 'Activité supprimé avec succés';
        }
        $request->query->remove("succesDelete");
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $entityManager = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = 'Activité crée avec succés';
            $article = $form->getData();
            $entityManager->persist($article);
            $entityManager->flush();
        }
        return $this->render('activite/index.html.twig', [
            'form' => $form->createView(),
            'lesActivites' => $entityManager->getRepository(Activite::class)->
            findAll(),
            'message' => $message
        ]);
    }

    /**
     * @Route("/activite/delete/{id}", name="supprimer_activite")
     * Method({"GET", "DELETE"})
     */
    public function deleteActivite(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Activite::class);
        $activite = $repo->find($id);
        $entityManager->remove($activite);
        $entityManager->flush();
        return $this->redirectToRoute('ajout_activite', ['succesDelete' => '1']);
    }

    /**
     * @Route("/activite/edit/{id}", name="edit_activite")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id): Response
    {
        $message = "";
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Activite::class);
        $coach = $repo->find($id);
        $form = $this->createForm(ActiviteType::class, $coach);
        $form->handleRequest($request);
        if ($coach != null && $form->isSubmitted() && $form->isValid()) {
            $message = 'Activité modifié avec succés';
            $coach = $form->getData();
            $entityManager->persist($coach);
            $entityManager->flush();
        }
        return $this->render('activite/update.html.twig', [
            'form' => $form->createView(),
            'message' => $message
        ]);
    }

}
