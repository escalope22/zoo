<?php

namespace App\Controller;

use App\Entity\Animals;
use App\Entity\Enclos;
use App\Form\AnimalsCreationType;
use App\Form\AnimalSupprimerType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;
use function Sodium\add;

class AnimalsController extends AbstractController
{
    /**
     * @Route("/animal", name="app_animals")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        return $this->render('animals/index.html.twig', [
            'animals' => $doctrine->getRepository(Animals::class)->findAll(),
        ]);
    }

    /**
     * @Route("/animal/enclos/{id}", name="app_animals_enclos")
     */
    public function index_enclos($id, ManagerRegistry $doctrine): Response
    {
        $animals = [];
        $tous = $doctrine->getRepository(Animals::class)->findAll();
        foreach ($tous as $animal)
            if ($animal->getEnclos()->getId() == $id)
                $animals[] = $animal;
        return $this->render('animals/afficher_enclos.html.twig', [
            'animals' => $animals,
            'enclo' => $doctrine->getRepository(Enclos::class)->find($id)
        ]);
    }

    /**
     * @Route("/animal/ajouter", name="app_animals_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $animals = new Animals();
        $form = $this->createForm(AnimalsCreationType::class, $animals);
        //retour
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->verificationFormulaireAnimalAjout($animals);
            if (count($errors) == 0) {
                $em = $doctrine->getManager();
                $em->persist($animals);
                $em->flush();
                return $this->redirectToRoute("app_animals");
            } else {
                foreach($errors as $error){
                    $this->addFlash("error",$error);
                }
            }
        }

        return $this->render('animals/ajouter.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }


    /**
     * @Route("/animal/supprimer{id}", name="app_animals_supprimer")
     */
    public function supr($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $animal = $doctrine->getRepository(Animals::class)->find($id);

        if (!$animal){
            throw $this->createAccessDeniedException("pas de catégories avec l'id $id");
        }

        $form = $this->createForm(AnimalSupprimerType::class, $animal);
        //retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->remove($animal);
            $em->flush();
            return $this->redirectToRoute("app_animals");
        }
        return $this->render('animals/supprimer.html.twig', [
            "formulaire" => $form->createView(),
            "animal" => $animal
        ]);
    }

    /**
     * @Route("/animal/modifier{id}", name="app_animals_modifier")
     */
    public function modifier($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $animal = $doctrine->getRepository(Animals::class)->find($id);
        $form = $this->createForm(AnimalsCreationType::class, $animal);
        //retour
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && $this->verificationFormulaireAnimalAjout($animal)) {
            $em = $doctrine->getManager();
            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute("app_animals");
        }

        return $this->render('animals/ajouter.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }

    /**
     * @Route("/enclos/animal/quarantaine{id}", name="app_animals_change_quarantaine")
     */
    public function quarantaine($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $animal = $doctrine->getRepository(Animals::class)->find($id);

        if (!$animal){
            throw $this->createAccessDeniedException("pas de catégories avec l'id $id");
        }

        if ($animal->isQuarantaine()){
            $animal->setQuarantaine(false);
        }else{
            $animal->setQuarantaine(true);
        }

        $enclos_quitte_quarantaine = true;

        foreach ($animal->getEnclos()->getAnimals()->toArray() as $animal_enclos )
            if ($animal_enclos->isQuarantaine())
                $enclos_quitte_quarantaine = false;

        if($enclos_quitte_quarantaine)
            $animal->getEnclos()->setQuarantaine(false);

        $em = $doctrine->getManager();
        $em->persist($animal);
        $em->flush();

        return $this->redirectToRoute("app_animals_enclos", ['id' => $animal->getEnclos()->getId()]);
    }


    private function verificationFormulaireAnimalAjout(Animals $animals) : array {
        $response = [];

        if (! (strlen((string)$animals->getNumeroId()) == 14 && ctype_digit($animals->getNumeroId()))) //Le numéro d’identification a toujours exactement 14 chiffres
            $response[] = "Le numéro d'ID doit contenir 14 chiffre";

        if ($animals->getDateNaissance() != null)
            if($animals->getDateNaissance()->getTimestamp() > $animals->getDateArrivee()->getTimestamp()) //La date de naissance ne doit pas être supérieure à la date d’arrivée au zoo.
                $response[] = "date de naissance ne doit pas être supérieur à la date d'arrivée au zoo";

        if ($animals->isMale() == null && $animals->isSterilise())
            $response[] = "L’animal ne peut pas être stérilisé si on n’a pas déterminé son sexe";

        if (count($animals->getEnclos()->getAnimals()) >= $animals->getEnclos()->getCapacite() )
            $response[] = "Il n'y a plus de place dans l'enclos!!";

        return $response;
    }
}
