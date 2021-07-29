<?php

namespace App\Form;

use App\Entity\Repertoire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RepertoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,[
                'required' => false,
                'constraints' =>[
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit contenir au moins 2 caractères alphabétiques',
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern' => '/^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/',
                        'match' => true,
                        'message' => 'Veuillez entrer un prénom correct.',
                    )),
                    new NotBlank([
                        'message' => 'Veuiller renseigner un prénom',
                    ]),
                ]
            ])
            ->add('lastName', TextType::class,[
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit contenir au moins 2 caractères alphabétiques',
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern' => '/^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/',
                        'match' => true,
                        'message' => 'Veuillez entrer un nom correct.',
                    )),
                    new NotBlank([
                        'message' => 'Veuillez renseigner un prénom',
                    ]),
                ]
            ])
            ->add('adress', TextType::class,[
                'required' => false,
                'constraints' =>[
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre adresse doit contenir au moins 2 caractères alphabétique',
                        'max' => 4096,
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner une adresse',
                    ]),
                ]
            ])
            ->add('country', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre ville doit contenir au moins 2 caractères alphabétiques',
                        'max' => 4096,
                    ]),
                    new Regex(array(
                        'pattern' => '/^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]+$/',
                        'match' => true,
                        'message' => 'Veuillez entrer une ville correct',
                    )),
                ]
            ])
            ->add('postalCode', TextType::class,[
                'required' => false,
                'constraints' =>[
                    new Regex(array(
                        'pattern' => '/^((0[1-9])|([1-8][0-9])|(9[0-8])|(2A)|(2B))[0-9]{3}$/',
                        'match' => true,
                        'message' => 'Veuillez entrer un code postal correct.',
                    )),
                ]
            ])
            ->add('phoneHome')
            ->add('indPhoneHome', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'maxMessage' => 'Votre indicateur doit être similaire à +33',
                        'max' => 4,
                    ]),
                ]
            ])
            ->add('phone')
            ->add('indPhone', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'maxMessage' => 'Votre indicateur doit être similaire à +33',
                        'max' => 4,
                    ]),
                ]
            ])
            ->add('phonePro')
            ->add('indPhonePro', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'maxMessage' => 'Votre indicateur doit être similaire à +33',
                        'max' => 4,
                    ]),
                ]
            ])
            ->add('email')
            ->add('emailPro')
            ->add('pictureFile', FileTYpe::class, [
                'required'=>false
            ])
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
