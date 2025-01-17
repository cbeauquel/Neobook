<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Editor;
use App\Entity\Category;
use App\Form\FormatType;
use App\Entity\Contributor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('cover', UrlType::class)
            ->add('summary', TextType::class)
            ->add('genre', TextType::class)
            ->add('parutionDate', null, [
                'widget' => 'single_text',
            ])
            ->add('bookUpdate', null, [
                'widget' => 'single_text',
            ])
            ->add('status', CheckboxType::class)
            ->add('creationDate', null, [
                'widget' => 'single_text',
            ])
            // ->add('keyWords', EntityType::class, [
            //     'class' => KeyWords::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            ->add('formats', CollectionType::class, [
                'entry_type' => FormatType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false],
                'attr' => [
                    'data-controller' => 'form-collection',
                    'data-form-collection-add-label-value' => 'Ajouter un format',
                    'data-form-collection-delete-label-value' => 'Supprimer le format'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'Name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
