<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\BoSkCo;
use App\Entity\Contributor;
use App\Entity\Skill;
use App\Form\BookType;
use App\Form\ContributorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoSkCoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('book', EntityType::class, [
            //     'class' => Book::class,
            //     'choice_label' => 'id',
            // ])

            ->add('contributor', EntityType::class, [
                'class' => Contributor::class,
                'choice_label' => 'slug',
                'attr' => [
                    'class' => 'form-select'
                ],


            ])
            ->add('skill', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select'
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BoSkCo::class,
        ]);
    }
}
