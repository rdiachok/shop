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
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MANAGER = 'ROLE_MANAGER';
    const ROLE_SALESMAN = 'ROLE_SALESMAN';
    const ROLE_CUSTOMER = 'ROLE_CUSTOMER';

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
            ->add('roles', ChoiceType::class, [
                'label' => 'Chouse one role for user',
                'multiple' => true,
                'choices' => [
                    self::ROLE_ADMIN => self::ROLE_ADMIN ,
                    self::ROLE_MANAGER => self::ROLE_MANAGER,
                    self::ROLE_SALESMAN => self::ROLE_SALESMAN,
                    self::ROLE_CUSTOMER => self::ROLE_CUSTOMER,
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
