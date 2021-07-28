<?php

namespace App\Form;

use App\Entity\Council;
use App\Form\CouncilType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CouncilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleCouncilTribe')
            ->add('comments')
            ->add('dateStart', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('dateEnd', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])
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
