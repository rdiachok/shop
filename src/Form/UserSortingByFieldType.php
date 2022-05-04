<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Users;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserSortingByFieldType extends AbstractType
{
    const EMAIL = 'email';
    const FIRST_NAME = 'firstName';
    const LAST_NAME = 'lastName';
    const ROLE = 'role';
    const ASC = 'ASC';
    const DESC = 'DESC';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('field', ChoiceType::class, [
                'label' => 'Chouse field',
                'choices' => [
                    self::EMAIL => self::EMAIL,
                    'first name' => self::FIRST_NAME,
                    'last name' => self::LAST_NAME,
                    self::ROLE => self::ROLE,
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
