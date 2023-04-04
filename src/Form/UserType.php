<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,['attr'=>['class'=>'wrap-input1 validate-input'],'label'=>'Email'])
            ->add('prenom',TextType::class,['attr'=>['class'=>'wrap-input1 validate-input'],'label'=>'Prenom'])
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
            ->add('nom',TextType::class,['attr'=>['class'=>'wrap-input1 validate-input'],'label'=>'Nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
