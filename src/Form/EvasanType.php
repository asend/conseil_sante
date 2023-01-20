<?php

namespace App\Form;

use App\Entity\Devise;
use App\Entity\Evasan;
use PHPUnit\TextUI\Help;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvasanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accompagnant', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('destination')
            ->add('montant', null, [
                'label' => 'Facture Proformat'
            ])
            ->add('devise', EntityType::class, [
                'class' => Devise::class,
                'choice_label' => 'nom',
                'expanded' => true,
            ])
            ->add('date_depart', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
            ])
            ->add('date_retour', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
            ])
            ->add('frais_hospitalisation_soins', null, [
                'label' => 'Facture définitive'
            ])
            ->add('rv_controle')
            ->add('date_demande', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
            ])
            ->add('n_bordereau_ministere_tutelle')
            ->add('n_date_decision', null, [
                'help' => 'format: 1234 du 22-10-2020',
            ])
            ->add('n_facture_date_transmission_solde', null, [
                'help' => 'format: n° 1234 du 22-10-2020',
                ])
            ->add('date_virement', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
            ])
            ->add('n_tresor', null, [
                'help' => 'H666'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evasan::class,
        ]);
    }
}