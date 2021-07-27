<?php

namespace App\Form;

use App\Entity\Documents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('fileTitle')
            ->add('titleDocument')
            ->add('description')
            // ->add('user')
            // ->add('titleCategoryDocument')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Documents::class,
        ]);
    }
}
