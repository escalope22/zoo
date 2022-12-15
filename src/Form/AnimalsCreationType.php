<?php

namespace App\Form;

use App\Entity\Animals;
use App\Entity\Enclos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalsCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_id')
            ->add('nom')
            ->add('date_naissance')
            ->add('date_arrivee')
            ->add('date_depart')
            ->add('zoo_proprietaire')
            ->add('genre', TextType::class)
            ->add('espece', TextType::class)
            ->add('male', ChoiceType::class, [
                'label' => "Sexe",
                'choices'=>[
                    "Mâle" => true,
                    "Femelle" => false,
                    "Non-définis" => null
                ],
            ])
            ->add('sterilise')
            ->add('quarantaine')
            ->add('enclos', EntityType::class, [
                "class"=>Enclos::class,
                "choice_label"=>"nom",
                "multiple"=>false,
                "expanded"=>false
            ])
            ->add("ok", SubmitType::class, ["label"=>"OK"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
        ]);
    }
}
