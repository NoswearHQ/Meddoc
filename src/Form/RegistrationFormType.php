<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,['attr'=>['class'=>'form-control'],'label'=>'Email'])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label'=>'Mot de passe',
                'attr' => ['class' => 'password-field'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => [
                    'label' => 'Repeter votre mot de passe',
                ],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
            ->add('nom',TextType::class,['attr'=>['class'=>'form-control'],'label'=>'Nom'])
            ->add('prenom',TextType::class,['attr'=>['class'=>'form-control'],'label'=>'Prenom'])
            ->add('avatar',FileType::class,
                ['attr'=>['class'=>'form-control'],
                    'label'=>'Photo de profil',
                    'mapped'=>false,
                    'required'=>false,
                    'constraints'=>
                        [
                            new File([
                                'mimeTypes'=>[
                                    'image/jpg',
                                    'image/png',
                                    'image/jpeg',
                                    'image/gif',
                                ],
                                'mimeTypesMessage'=>'Please upload a valid image'
                            ])
                        ]])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('Pays', CountryType::class, array(
                'label' => 'Pays',
                'placeholder' => 'Pays',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('Specialite',ChoiceType::class,
                array('choices' =>
                    array(
                        'Cardiologie' => 'Cardiologie',
                        'Pédiatrique Endocrinologie' => 'Pédiatrique Endocrinologie',
                        'Dermatologie' => 'Dermatologie',
                        'Gastro-entérologie' => 'Gastro-entérologie',
                        'Hépatologie' => 'Hépatologie',
                        'Gynécologie-Obstétrique' => 'Gynécologie-Obstétrique',
                        'Obstétrique' => 'Obstétrique',
                        'Hématologie' => 'Hématologie',
                        'Oncologie' => 'Oncologie',
                        'Maladie infectieuse' => 'Maladie infectieuse',
                        'Médecine interne ' => 'Médecine interne ',
                        'Gériatrie' => 'Gériatrie',
                        'Néphrologie' => 'Néphrologie',
                        'Neurologie Ophtalmologie' => 'Neurologie Ophtalmologie',
                        'ORL' => 'ORL',
                        'Pédiatrie' => 'Pédiatrie',
                        'Pédiatrie métaboliques' => 'Pédiatrie métaboliques',
                        'Pneumologie' => 'Pneumologie',
                        'Psychiatrie' => 'Psychiatrie',
                        'Réanimation' => 'Réanimation',
                        'Rhumatologie' => 'Rhumatologie',
                        'Urologie' => 'Urologie',
                        'Urgence' => 'Urgence',
                    ),'multiple'=>false,'attr'=>['class'=>'form-control'],'label'=>'Specialite ','required' => true))
            ->add('Ville',TextType::class,['attr'=>['class'=>'form-control'],'label'=>'Ville']);



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
