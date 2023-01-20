<?php

namespace App\Form;

use App\Entity\Cadre;
use App\Entity\Corps;
use App\Entity\Ministere;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('date_naissance', DateType::class, [
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
            ])
            ->add('lieu_naissance', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('matricule', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('lieu_service', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('date_entree_service', DateType::class, [
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'html5' => false,
                    'attr' => [
                        'class' => 'js-datepicker',
                        'placeholder' => 'jj-mm-aaaa',
                    ],
            ])
            ->add('nombre_enfant', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('telephone_bureau', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('telephone_personnel', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('situation_matrimoniale', ChoiceType::class, [
                'choices' => $this->getSM(),
                'required'   => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('tutel', EntityType::class, [
                'class' => Ministere::class,
                'choice_label' =>'nom',
                'attr' => ['class' => 'form-control']
            ])
            // ->add('corps', EntityType::class, [
            //     'class' => Corps::class,
            //     'choice_label' =>'nom',
            //     'attr' => ['class' => 'form-control']
            // ])
            // ->add('cadre', EntityType::class, [
            //     'class' => Cadre::class,
            //     'choice_label' =>'nom',
            //     'attr' => ['class' => 'form-control']
            // ])
            ->add('grade',ChoiceType::class, [
                'choices' => $this->getGRADE(),
                'required'   => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('sexe',ChoiceType::class, [
                'choices' => $this->getSEXE(),
                'required'   => false,
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    private function getSM()
    {
        $choices = Patient::SM;
        $output = [];
        foreach ($choices as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }

    private function getGRADE()
    {
        $choices = Patient::GRADE;
        $output = [];
        foreach ($choices as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }

    private function getSEXE()
    {
        $choices = Patient::SEXE;
        $output = [];
        foreach ($choices as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}