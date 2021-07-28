<?php

namespace App\Form;

use App\Entity\CategoryDocument;
use App\Entity\Documents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
//            ->add('fileTitle')
            ->add('titleDocument', TextType::class, [
                'label' => 'Nom du document'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description du document'
            ])
//            ->add('user')
            ->add('categoryDocument', EntityType::class, [
                'class' => CategoryDocument::class,
                'choice_label' => 'titleCategoryDoc'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Documents::class,
        ]);
    }
}
