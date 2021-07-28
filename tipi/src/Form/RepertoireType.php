<?php

namespace App\Form;

use App\Entity\Repertoire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepertoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('adress')
            ->add('country')
            ->add('postalCode')
            ->add('phoneHome')
            ->add('indPhoneHome')
            ->add('phone')
            ->add('indPhone')
            ->add('phonePro')
            ->add('indPhonePro')
            ->add('email')
            ->add('emailPro')
            ->add('picture')
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repertoire::class,
        ]);
    }
}
