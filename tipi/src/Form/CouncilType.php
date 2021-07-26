<?php

namespace App\Form;

use App\Entity\Council;
use App\Form\CouncilType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CouncilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleCouncilTribe')
            ->add('comments')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('hourStart')
            ->add('hourEnd')
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Council::class,
        ]);
    }
}
