<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class ,  [
            'label' => 'Votre Nom',
            'attr' => ['placeholder' => 'Nom'],
            ])
            ->add('prenom',TextType::class ,  [
                'label' => 'Votre Prénom',
                'attr' => ['placeholder' => 'Prénom'],
            ])
            ->add('email',EmailType::class, [
                'label' => 'Votre E-mail',
                'attr' => ['placeholder' => 'E-mail'],
                ])
                ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=>'Le mot de passe et la confiramtion doivent etre identiques',
                'label' => 'Votre Mot de passe',
                'required'=>true,
                'first_options'=>['label'=>'Votre mot de passe'],
                'second_options'=>['label'=>'Confirmer votre mot de passe'],
                'attr' => ['autocomplete' => 'Nouveau mot de passe','placeholder' => 'Mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Taper votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    
                ],
                
            ])
            
            
            ->add('submit',SubmitType::class ,  [
                'label' => 'Inscrivez-Vous',
            
            ])
        
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
