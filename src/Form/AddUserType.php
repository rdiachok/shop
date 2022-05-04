<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddUserType extends AbstractType
{
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const SALESMAN = 'salesman';
    const CUSTOMER = 'customer';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Set your name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Set your Last name',
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Chouse one role for user',
                'choices' => [
                    self::ADMIN => self::ADMIN ,
                    self::MANAGER => self::MANAGER,
                    self::SALESMAN => self::SALESMAN,
                    self::CUSTOMER => self::CUSTOMER,
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
