<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Orders;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrderSortingByFieldType extends AbstractType
{
    const SELLER = 'seller';
    const IS_PAID = 'isPaid';
    const DATE_SOLD = 'dateSold';
    const ASC = 'ASC';
    const DESC = 'DESC';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('field', ChoiceType::class, [
                'label' => 'Chouse field',
                'choices' => [
                    self::SELLER => self::SELLER,
                    'is paid' => self::IS_PAID,
                    'date sold' => self::DATE_SOLD,
                ],
            ])
            ->add('sort', ChoiceType::class, [
                'label' => 'Chouse how to sorting',
                'choices' => [
                    'from A' => self::ASC,
                    'from Z' => self::DESC,
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Sort']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
