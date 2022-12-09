<?php

namespace App\Controller;

use App\Entity\Enclos;
use App\Form\EnclosCreationType;
use App\Form\EncloSupprimerType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnclosController extends AbstractController
{
    /**
     * @Route("/enclos", name="app_enclos")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        return $this->render('enclos/index.html.twig', [
            'enclos' => $doctrine->getRepository(Enclos::class)->findAll()
        ]);
    }

    /**
     * @Route("/enclos/ajouter", name="app_enclos_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $enclos = new Enclos();
        $form = $this->createForm(EnclosCreationType::class, $enclos);

        //retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($enclos);
            $em->flush();
            return $this->redirectToRoute("app_enclos");
        }
        return $this->render('enclos/ajouter.html.twig', [
            'controller_name' => 'EnclosController',
            "formulaire" => $form->createView()
        ]);
    }
    /**
     * @Route("/enclos/supprimer{id}", name="app_enclos_supr")
     */
    public function supr($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $enclo = $doctrine->getRepository(Enclos::class)->find($id);

        if (!$enclo){
            throw $this->createAccessDeniedException("pas de catégories avec l'id $id");
        }

        $form = $this->createForm(EncloSupprimerType::class, $enclo);
        //retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->remove($enclo);
            $em->flush();
            return $this->redirectToRoute("app_enclos");
        }
        return $this->render('enclos/supprimer.html.twig', [
            "formulaire" => $form->createView(),
            "enclo" => $enclo
        ]);
    }

    /**
     * @Route("/enclos/quarantaine{id}", name="app_change_quarantaine")
     */
    public function quarantaine($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $enclo = $doctrine->getRepository(Enclos::class)->find($id);

        if (!$enclo){
            throw $this->createAccessDeniedException("pas de catégories avec l'id $id");
        }

        if ($enclo->isQuarantaine()){
            $enclo->setQuarantaine(false);
        }else{
            $enclo->setQuarantaine(true);
            //TODO mettre tous les animaux en quarantaine
        }

        $em = $doctrine->getManager();
        $em->persist($enclo);
        $em->flush();

        return $this->redirectToRoute("app_enclos");
    }
}
