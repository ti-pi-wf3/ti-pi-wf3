<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('role')
            ->add('sexe')
            ->add('password',RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer mot de passe'],
            ])
            ->add('status')
            ->add('firstName', TextType::class,[
                // 'label'       => 'Prénom',
                'required'    => false,
                'constraints' =>[

                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit contenir au moins deux caractères alphabétiques',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern'   => '/^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/',
                        'match'     => true,
                        'message'   => 'Veuillez entrer un prénom correct !'
                    )),
                ]
            ])
            ->add('lastName', TextType::class, [
                // 'label'       => 'Nom',
                'required'    => false,
                'constraints' =>[
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit contenir au moins deux caractères alphabétiques',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern'   => '/^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/',
                        'match'     => true,
                        'message'   => 'Veuillez entrer un nom correct !'
                    )),
                ]
            ])
            ->add('maidenName', TextType::class, [
                // 'label'       => 'Nom de jeune fille',
                'required'    => false,
                'constraints' =>[
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit contenir au moins deux caractères alphabétiques',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern'   => '/^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/',
                        'match'     => true,
                        'message'   => 'Veuillez entrer un nom correct !'
                    )),
                ]
            ])
            ->add('email')
            ->add('birthDate', DateType::class, [
                //render it as a single text box
                'widget' => 'single_text',
            ])
            ->add('phone', TextType::class, [
                // 'label'     => 'Téléphone',
                'required' => false,
                'constraints' =>[
                    new Regex(array(
                        'pattern'   => '/^((0[1-9])|([1-8][0-9])|(9[0-8])|)[0-9]{10}$/',
                        'match'     => true,
                        'message'   => 'Veuillez entrer un téléphone correct !'
                    )),
                ]
            ])
            ->add('role', CollectionType::class, [
                'label' => false,
                'label_format' => false,
                'entry_type' => ChoiceType::class, 
                'entry_options' => [
                    'choices' => [
                        'Membre' => '',
                        'Chef' => 'ROLE_SUPER_USER'
                    ]
                ]
            ])
            ;
            // ->add('indPhone')
            // ->add('tribeId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
