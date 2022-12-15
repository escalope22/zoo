<?php

namespace App\Controller;

use App\Entity\Espaces;
use App\Form\EspaceCreationType;
use App\Form\EspaceDateOuvertureType;
use App\Form\EspaceDateFermetureType;
use App\Form\EspaceSupprimerType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class EspacesController extends AbstractController
{
    /**
     * @Route("/espaces", name="app_espaces")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        return $this->render('espaces/index.html.twig', [
            'espaces' => $doctrine->getRepository(Espaces::class)->findAll(),
        ]);
    }

    /**
     * @Route("/espaces/ajouter", name="app_espaces_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $espaces = new Espaces();
        $form = $this->createForm(EspaceCreationType::class, $espaces);

        //retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($espaces);
            $em->flush();
            return $this->redirectToRoute("app_espaces");
        }
        return $this->render('espaces/ajouter.html.twig', [
            'controller_name' => 'EspacesController',
            "formulaire" => $form->createView()
        ]);
    }

    /**
     * @Route("/espaces/supprimer{id}", name="app_espaces_supr")
     */
    public function supr($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $espace = $doctrine->getRepository(Espaces::class)->find($id);

        if (!$espace){
            throw $this->createAccessDeniedException("pas de catégories avec l'id $id");
        }

        $form = $this->createForm(EspaceSupprimerType::class, $espace);
        //retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->remove($espace);
            $em->flush();
            return $this->redirectToRoute("app_espaces");
        }
        return $this->render('espaces/supprimer.html.twig', [
            'controller_name' => 'EspacesController',
            "formulaire" => $form->createView(),
            "espace" => $espace
        ]);
    }

    /**
     * @Route("/espaces/date_ouverture/{id}", name="app_espaces_date_ouverture")
     */
    public function date_ouverture($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $espace = $doctrine->getRepository(Espaces::class)->find($id);

        if (!$espace){
            throw $this->createAccessDeniedException("pas d'espace avec l'id $id");
        }

        $form = $this->createForm(EspaceDateOuvertureType::class, $espace);
        //retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($espace);
            $em->flush();
            return $this->redirectToRoute("app_espaces");

        }
        return $this->render('espaces/date_ouverture.html.twig', [
            'controller_name' => 'EspacesController',
            "formulaire" => $form->createView(),
            "espace" => $espace
        ]);
    }

    /**
     * @Route("/espaces/date_fermeture/{id}{date_impossible}", name="app_espaces_date_fermeture")
     */
    public function date_fermeture($id, $date_impossible, ManagerRegistry $doctrine, Request $request): Response
    {
        $espace = $doctrine->getRepository(Espaces::class)->find($id);

        if (!$espace){
            throw $this->createAccessDeniedException("pas d'espace avec l'id $id");
        }

        $form = $this->createForm(EspaceDateFermetureType::class, $espace);
        //retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($espace->getDateOuverture()->getTimestamp() < $espace->getDateFermeture()->getTimestamp()){
                $em = $doctrine->getManager();
                $em->persist($espace);
                $em->flush();
                return $this->redirectToRoute("app_espaces");
            } else {
                $date_impossible = "1";
                return $this->redirectToRoute("app_espaces_date_fermeture", ['id' => $id,'date_impossible' => $date_impossible]);
            }
        }
        return $this->render('espaces/date_fermeture.html.twig', [
            'controller_name' => 'EspacesController',
            "formulaire" => $form->createView(),
            "espace" => $espace,
            "date_impossible" => $date_impossible
        ]);
    }
}
