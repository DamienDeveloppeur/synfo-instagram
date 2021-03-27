<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input_instagram mb-2 col-9',
                    'placeholder' => 'e-mail'

                ]
            ])
            ->add('pseudo', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input_instagram mb-2 col-9',
                    'placeholder' => 'nom d\'utilisateur'

                ]
            ])
            ->add('meta_name', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input_instagram mb-2 col-9',
                    'placeholder' => 'nom_complet'

                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input_instagram mb-2 col-9',
                    'placeholder' => 'Mot de passe'
                ]
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input_instagram mb-2 col-9',
                    'placeholder' => 'Confirmer le mot de passe'
                ]
            ])
            ->add('Inscription', SubmitType::class, [
                'attr' => [
                    'class' => 'btn button_background col-9',
                    'type' => 'submit'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
