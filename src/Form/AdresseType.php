<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=> 'Votre nom',
                'attr' => [
                    'placeholder'=> 'Entrer votre nom'
                ]
            ])
            ->add('prenom', TextType::class,[
                'label'=> 'Votre prénom',
                'attr' => [
                    'placeholder'=> 'Entrer votre prénom'
                ]
            ])
            ->add('nomadr', TextType::class,[
                'label'=> 'Quel nom souhaitez-vous à votre adresse',
                'attr' => [
                    'placeholder'=> 'Nommez votre adresse'
                ]
            ])
            ->add('societe', TextType::class,[
                'label'=> 'Votre société',
                'attr' => [
                    'placeholder'=> '(facultatif) Entrer votre société'
                ]
            ])
            ->add('adresse', TextType::class,[
                'label'=> 'Votre adresse',
                'attr' => [
                    'placeholder'=> 'Entrer votre adresse'
                ]
            ])
            ->add('codepostal', TextType::class,[
                'label'=> 'Votre code postal ',
                'attr' => [
                    'placeholder'=> 'Entrer votre code postal'
                ]
            ])
     
            ->add('cite', TextType::class,[
                'label'=> 'Votre ville',
                'attr' => [
                    'placeholder'=> 'Entrer votre ville '
                ]
            ])
            ->add('pays', CountryType::class,[
                'label'=> 'Votre pays ',
                'attr' => [
                    'placeholder'=> 'Entrer votre pays'
                ]
            ])
            ->add('numtel', TelType::class,[
                'label'=> 'Votre téléphone',
                'attr' => [
                    'placeholder'=> 'Entrer votre téléphone'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=> 'Valider',
                'attr' => [
                    'class' => 'btn block btn-info'
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
