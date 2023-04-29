<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          
            ->add('old_password',PasswordType::class,[
                'label'=>'Mon mot de passe actuel',
                'mapped'=>false,
                'attr'=> [
                    'placeholder'=>'veuillez saisir votre mot de passe actuel',
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'mapped'=>false,
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
                'label' => 'Mettre à jour',
            
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
