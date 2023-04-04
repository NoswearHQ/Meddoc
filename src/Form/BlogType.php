<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Introduction',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Introduction'])
            ->add('Definition',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Definition'])
            ->add('Signescliniques',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Signes cliniques'])
            ->add('Examens',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Examens'])
            ->add('complementaires',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'complementaires'])
            ->add('Diagnostic',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Diagnostic'])
            ->add('PronosticEvaluation',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Pronostic Evaluation'])
            ->add('Priseencharge',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Prise en charge'])
            ->add('Pointscles',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Points cles'])
            ->add('Diagnosticdifficile',TextareaType::class,['attr'=>['class'=>'input1'],'label'=>'Diagnostic difficile'])
            ->add('cat',ChoiceType::class,
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
                    ),'multiple'=>false,'attr'=>['class'=>'form-control'],'label'=>'Catégories '))
            ->add('image',FileType::class,
                ['attr'=>['class'=>'form-control'],
                    'label'=>'Photo de larticle',
                    'required'=>false,
                    'mapped'=>false,
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


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
