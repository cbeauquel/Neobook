<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Editor;
use App\Entity\Category;
use App\Form\BoSkCoType;
use App\Form\FormatType;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('BoSkCos', CollectionType::class, [
                'entry_type' => BoSkCoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false],
                'attr' => [
                    'data-controller' => 'form-collection',
                ],
                'row_attr' => [
                    'class' => 'form-book-contributor',
                ]
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'Name',
                'attr' => [
                    'class' => 'form-select mb-3'
                ],
                'row_attr' => ['class' => 'form-book-editor']
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'by_reference' => false,
                'attr' => [
                    'class' => 'form-select'
                ],
                'multiple' => true,
                'row_attr' => [
                    'class' => 'form-book-category',
                ]
            ])
            ->add('title', TextType::class)
            ->add('cover', FileType::class, [
                'label' => 'cover (img file)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
    
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
    
                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '300k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/JPG',
                            'image/jpeg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid IMG document',
                    ])
                ],
            ])
            ->add('summary', CKEditorType::class)
            ->add('genre', TextType::class)
            ->add('parutionDate', null, [
                'widget' => 'single_text',
            ])
            ->add('status', CheckboxType::class,  [
                'required' => false,
                'row_attr' => [
                'class' => 'form-checkbox',
                ],
                'attr' => [
                    'class' => 'checkbox',
                ],
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
                'entry_options' => [
                    'label' => false,
                    'attr' =>[
                        'data-taux-group' => true,
                        'class' => 'book-formats',
                ],

                ],
                'attr' => [
                    'data-controller' => 'form-collection',
                ],
                'row_attr' => ['
                    class' => 'form-book-formats',
                    ]
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
