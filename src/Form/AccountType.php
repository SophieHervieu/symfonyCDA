<?php

namespace App\Form;

use App\Entity\Account;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Saisir le prénom de l\'utilisateur'
            ],[
                'attr' =>[
                    'placeholder' => 'Prénom utilisateur'   
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Saisir le nom de l\'utilisateur'
            ],[
                'attr' =>[
                    'placeholder' => 'Nom utilisateur'   
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Saisir l\'email de l\'utilisateur'
            ],[
                'attr' =>[
                    'placeholder' => 'Email utilisateur'   
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Saisir le mot de passe',
                    'hash_property_path' => 'password'],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe'],
                'mapped' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Inscription',

                'attr'=> ['class' => 'bg-teal']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
