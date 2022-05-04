<?php

namespace App\Form;

use App\Entity\Orders;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seller', TextType::class, [
                'label' => 'name seller',
            ])
            ->add('dateSold', DateType::class, [
                'label' => 'date',
            ])
            ->add('isPaid')
            ->add('customer', EntityType::class, [
                'class' => Users::class,
                'choice_label' => function ($id) {
                    return $id->getId();
                },
                'label' => 'choose your id',
            ])
            ->add('save', SubmitType::class, ['label' => 'Save']);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
