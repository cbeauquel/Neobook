<?php

namespace App\Form;

use App\Entity\Basket;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\Payment;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('newCustomer')
            // ->add('TotalHT')
            // ->add('TotalTTC')
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('customer', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('status', EntityType::class, [
            //     'class' => OrderStatus::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('paymentMode', EntityType::class, [
            //     'class' => Payment::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('basket', EntityType::class, [
            //     'class' => Basket::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('user_token', EntityType::class, [
            //     'class' => Basket::class,
            //     'choice_label' => 'id',
            // ])
            -> add('submit', SubmitType::class, ['label' => 'Je commande'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
