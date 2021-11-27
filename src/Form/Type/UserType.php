<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add("first_name", TextType::class, [
                'attr' => ['placeholder' => 'First name']
            ])
            ->add("last_name", TextType::class, [
                'attr' => ['placeholder' => 'Last name']
            ])
            ->add("email", TextType::class, [
                'attr' => ['placeholder' => 'Email']
            ])
            ->add("phone_number", TelType::class, [
                'attr' => ['placeholder' => 'Phone number']
            ])
            ->add("role", TextType::class, [
                'attr' => ['placeholder' => 'Role']
            ])
            ->add("note", TextareaType::class, [
                'attr' => ['placeholder' => 'Note']
            ])
            ->add("username", TextType::class, [
                'attr' => ['placeholder' => 'Username']
            ])
            ->add("plain_password", RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password',
                    'attr' => ['placeholder' => 'Password']],
                'second_options' => ['label' => 'Confirm Password',
                    'attr' => ['placeholder' => 'Confirm Password']],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}