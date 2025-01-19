<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Type;
use App\Entity\Format;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ISBN', TextType::class)
            ->add('priceHT', MoneyType::class)
            ->add('duration', IntegerType::class)
            ->add('wordsCount', IntegerType::class )
            ->add('pagesCount', IntegerType::class)
            ->add('fileSize', NumberType::class)
            ->add('filePath', UrlType::class)
            ->add('bookExtract', UrlType::class)
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
