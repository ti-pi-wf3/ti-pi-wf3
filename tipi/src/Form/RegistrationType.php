<?php

namespace App\Form;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('role')
            ->add('sexe', CollectionType::class, [
                'label' => false,
                'label_format' => false,
                'entry_type' => ChoiceType::class, 
                'entry_options' => [
                    'choices' => [
                        'feminin' => 'f',
                        'masculin' => 'm'
                    ]
                ]
            ])
            ->add('password',RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer mot de passe'],
            ])
            ->add('status')
            ->add('firstName')
            ->add('lastName')
            ->add('maidenName')
            ->add('email')
            ->add('birthDate', DateType::class, [
                //render it as a single text box
                'widget' => 'single_text',
            ])
            ->add('phone')
            // ->add('indPhone')
            //->add('tribeId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
