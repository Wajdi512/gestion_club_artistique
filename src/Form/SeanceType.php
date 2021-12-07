<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Coach;
use App\Entity\Seance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heureDebut')
            ->add('heureFin')
            ->add('coach', EntityType::class, [
                'class' => Coach::class,
                'choice_label' => function(Coach $coach) {
                    return sprintf('%s %s', $coach->getNom(), $coach->getPrenom());
                },
                'placeholder' => 'Choisir un coach'
            ])
            ->add('activite', EntityType::class, [
                'class' => Activite::class,
                'choice_label' => 'libAct',
                'placeholder' => 'Choisir une activité'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
