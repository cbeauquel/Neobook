<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Format;
use App\Entity\Tva;
use App\Entity\Type;
use App\Repository\TvaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FormatType extends AbstractType
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $rateDefault = $this->manager->getRepository(Tva::class)->find(1); // ID 1 par exemple
        $builder
            ->add('ISBN', TextType::class)
            ->add('priceHT', MoneyType::class, [
                'label' => 'Prix hors taxes',
                'attr' => [
                    'data-price-ht' => true, // Attribut pour JavaScript
                ],
            ])
            ->add('priceTTC', MoneyType::class, [
                'label' => 'Prix TTC',
                'attr' => [
                    'data-price-ttc' => true, // Attribut pour JavaScript
                    // 'readonly' => true,      // Champ en lecture seule
                ],
            ])
            ->add('tvaRate', EntityType::class, [
                'class' => Tva::class,
                'data' => $rateDefault,
                'expanded' => true,
                'choice_label' => 'taux',
                'choice_attr' => fn ($choice, $key, $value) => [
                    'data-taux-value' => $choice->getTaux(), // Ajouter la valeur réelle comme attribut HTML
                ],
                'row_attr' => [
                    'class' => 'form-radio',
                ],
                'attr' => [
                    'data-taux' => true, // Attribut pour JavaScript
                    'class' => 'radio',
                ],
            ])
            ->add('duration', IntegerType::class)
            ->add('wordsCount', IntegerType::class)
            ->add('pagesCount', IntegerType::class)
            ->add('fileSize', NumberType::class)
            ->add('filePath', FileType::class, [
                'label' => 'Fichier du format',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
    
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
    
                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '64M',
                        'mimeTypes' => [
                            // EPUB - tous les types MIME possibles
                            'application/epub+zip',
                            'application/x-epub+zip',
                            'application/epub',
                            'application/EPUB',
                            'application/zip', // EPUB peut être détecté comme ZIP
                            // PDF
                            'application/pdf',
                            // Audio MP3
                            'audio/mpeg',
                            'audio/mp3',
                            // Alternative MIME types parfois utilisés
                            'application/x-epub+zip',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file',
                    ])
                ],
                'attr' => [
                'accept' => '.epub,.pdf,.mp3',
                'class' => 'form-control-file',
                ]
            ])
            ->add('bookExtract', FileType::class, [
                'label' => 'Fichier de l\'extrait',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
    
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
    
                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '64M',
                        'mimeTypes' => [
                            // EPUB - tous les types MIME possibles
                            'application/epub+zip',
                            'application/x-epub+zip',
                            'application/epub',
                            'application/zip', // EPUB peut être détecté comme ZIP
                            // PDF
                            'application/pdf',
                            // Audio MP3
                            'audio/mpeg',
                            'audio/mp3',
                            // Alternative MIME types parfois utilisés
                            'application/x-epub+zip',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file',
                    ])
                ],
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'expanded' => true,
                'choice_label' => 'name',
                'row_attr' => [
                    'class' => 'form-radio',
                ],
                'attr' => [
                    'class' => 'radio',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Format::class,
        ]);
    }
}
