<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Products;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductSortingByFieldType extends AbstractType
{
    const NAME = 'name';
    const MAKER = 'maker';
    const PRICE = 'price';
    const DATECREATED = 'dateCreate';
    const DATEUPDETED = 'dateUpdate';
    const DESCRIPTION = 'description';
    const SUMM = 'summ';
    const ASC = 'ASC';
    const DESC = 'DESC';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('field', ChoiceType::class, [
                'label' => 'Chouse field',
                'choices' => [
                    self::NAME => self::NAME ,
                    self::MAKER => self::MAKER,
                    self::PRICE => self::PRICE,
                    self::DATECREATED => self::DATECREATED,
                    self::DATEUPDETED => self::DATEUPDETED,
                    self::DESCRIPTION => self::DESCRIPTION,
                    self::SUMM => self::SUMM,
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
