<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
        ->add('new_password', RepeatedType::class, [
            'type'=>PasswordType::class,
            'invalid_message'=>'Le mot de passe et la confiramtion doivent etre identiques',
            'label' => 'Mon nouveau Mot de passe',
            'required'=>true,
            'first_options'=>['label'=>'Mon nouveau mot de passe','attr' => ['placeholder' => 'Nouveau Mot de passe'],],
            'second_options'=>['label'=>'Confirmer votre nouveau mot de passe','attr' => ['placeholder' => 'Confirmer votre nouveau mot de passe'],],
            'attr' => ['autocomplete' => 'Nouveau mot de passe','placeholder' => 'Nouveau Mot de passe'],
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
            'label' => 'Mettre à jour mon mot de passe',
            'attr' => [ 
                'class' => 'btn-block btn-info'
            ]
        
        ])
        
    ;

}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
