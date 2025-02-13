<?php

namespace App\Form;

use App\Entity\ToBeRead;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ToBeReadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', HiddenType::class, [
                'data' => 'à lire',
                'mapped' => false,
            ])
            ->add('customer', HiddenType::class, [
                'mapped' => false, // Géré côté contrôleur
            ])
            ->add('book', HiddenType::class, [
                'mapped' => false, // Géré côté contrôleur
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'bookmark_heart',
                'attr' => ['class' => 'material-symbols-outlined pal'],
                'row_attr' => ['class' => 'to-be-read'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToBeRead::class,
        ]);
    }
}
