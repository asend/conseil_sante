<?php

namespace App\Form;

use App\Entity\Conseil;
use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ConseilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('date_conseil', DateType::class, [
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'html5' => false,
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
            ])
            // ->add('patients', EntityType::class, [
            //     'required' => false,
            //     'class' => Patient::class,
            //     'choice_label' => 'matricule',
            //     'multiple' => true
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conseil::class,
        ]);
    }
}