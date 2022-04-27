<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Users;
use App\Form\Category;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'name product',
            ])
            ->add('maker', TextType::class, [
                'label' => 'name maker',
            ])
            ->add('price', IntegerType::class, [
                'label' => 'price',
            ])
            ->add('description', TextType::class, [
                'label' => 'some discription',
                'required' => false,
            ])
            ->add('dateCreate', DateType::class, [
                'label' => 'date',
            ])
            ->add('dateUpdate', DateType::class, [
                'label' => 'date update',
                'required' => false,
            ])
            ->add('summ', IntegerType::class, [
                'label' => 'summ',
            ])
            ->add('userAdd', EntityType::class, [
                'class' => Users::class,
                'choice_label' => function ($id) {
                    return $id->getId();
                },
                'label' => 'choose your id',
            ])
            ->add('save', SubmitType::class, ['label' => 'Save']);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $product = $event->getData();
            $form = $event->getForm();
            if (!$product || null === $product->getId()) {
                $form->add('name', TextType::class, [
                    'label' => 'name product',
                ])
                    ->add('maker', TextType::class, [
                        'label' => 'name maker',
                    ])
                    ->add('price', IntegerType::class, [
                        'label' => 'price',
                    ])
                    ->add('description', TextType::class, [
                        'label' => 'some discription',
                        'required' => false,
                    ])
                    ->add('dateCreate', DateType::class, [
                        'label' => 'date',
                    ])
                    ->add('dateUpdate', DateType::class, [
                        'label' => 'date update',
                        'required' => false,
                    ])
                    ->add('summ', IntegerType::class, [
                        'label' => 'summ',
                    ])
                    ->add('userAdd', EntityType::class, [
                        'class' => Users::class,
                        'choice_label' => function ($id) {
                            return $id->getId();
                        },
                        'label' => 'choose your id',
                    ])
                    ->add('save', SubmitType::class, ['label' => 'Save']);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
