<?php

namespace App\Form;

use App\Entity\Documents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\CategoryDocument;
use App\Repository\CategoryDocumentRepository;

class DocumentAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('date')
            // ->add('fileTitle')
            //! crée une entrée temporaire modifier une fois le fichié upload
            //! voir pour crée plusieurs entrée en même tep (greg)
            ->add('titleDocument', TextType::class,[
                'label' => 'Nom du document'
            ])
            ->add('description', TextType::class,[
                'label' => 'Description du document'
            ])
            // ->add('user')
            //! titleCategoryDocument -> categoryDocumentTitle
            ->add('categoryDocumentTitle')
            // ->add('titleCategoryDocument', EntityType::class, [
            //     'class' => CategoryDocument::class,
            //     // 'class' => CategoryDocumentRepository::class, 
            //     // on précise de quelle entité provient ce champ
            //     'choice_label' => 'titleCategoryDocument' // le contenu de la liste déroulante sera le titre des catégories
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Documents::class,
        ]);
    }
}
