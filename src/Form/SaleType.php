<?php

namespace App\Form;

use App\Entity\Format;
use App\Entity\Sale;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('salesStartDate', null, [
                'widget' => 'single_text',
            ])
            ->add('salesEndDate', null, [
                'widget' => 'single_text',
            ])
            ->add('reducedPriceHt', MoneyType::class, [
                'label' => 'Prix remisé Hors Taxes',
            ])
            ->add('reducedPriceTtc', MoneyType::class, [
                'label' => 'Prix remisé TTC',
            ])
            ->add('format', EntityType::class, [
                'class' => Format::class,
                'choice_label' => 'ISBN',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
        ]);
    }
}
