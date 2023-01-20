<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Souhait;
use App\Entity\Questionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q1', ChoiceType::class, [
                'choices'  => [
                    'OUI' => '1',
                    'NON' => '0',
                ],
                'expanded' => true,
                ])
            ->add('q2autre')
            ->add('q3', ChoiceType::class, [
                'choices'  => [
                    'OUI' => '1',
                    'NON' => '0',
                ],
                'expanded' => true,
                ])
            ->add('q4', ChoiceType::class, [
                'choices'  => [
                    'OUI' => '1',
                    'NON' => '0',
                ],
                'expanded' => true,
                ])
            ->add('q4datesuspension', DateType::class, [ 
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'html5' => false,
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
                ])
            ->add('q3datecessation', DateType::class, [ 
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'html5' => false,
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
                ])
            ->add('q5')
            ->add('q6')
            ->add('q7')
            ->add('q2', EntityType::class, ['required' => false,
                'class' => Demande::class,
                'choice_label' => 'nom',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('q8', EntityType::class,[
                'required' => true,
                'class' => Souhait::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => false
            ])
            ->add('lieu_de_rapprochement')
            ->add('demande_traduction', ChoiceType::class, [
                'choices'  => [
                    'Agent' => 'Agent',
                    'Hierarchie' => 'Hierarchie',
                ],
                'expanded' => true,
            ])
            ->add('date_conseil', DateType::class, [ 
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'html5' => false,
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
                ])
            ->add('decision_conseil')
            ->add('numero_certificat')
            ->add('date_transmission_resultat', DateType::class, [ 
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'html5' => false,
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
                ])
            ->add('numero_bordereau')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
        ]);
    }
}