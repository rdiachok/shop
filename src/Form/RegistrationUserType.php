<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationUserType extends AbstractType
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MANAGER = 'ROLE_MANAGER';
    const ROLE_SALESMAN = 'ROLE_SALESMAN';
    const ROLE_CUSTOMER = 'ROLE_CUSTOMER';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
        ->add('email', EmailType::class)
        ->add('password', RepeatedType::class, [
            'type'=>PasswordType::class,
            'first_options'=>array('label' => 'Password'),
            'second_options'=>array('label' => 'Repeat Password'),
        ])
        ->add('save', SubmitType::class,['label' => 'Register'])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
