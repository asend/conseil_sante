<?php

namespace App\Form;

use App\Entity\Certificat;
use App\Entity\Pathologie;
use App\Entity\Specialite;
use App\Repository\SpecialiteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avis_traitant')
            ->add('pathologie', EntityType::class, [
                'class' => Pathologie::class,
                'choice_label' => 'nom',
                'placeholder' => 'Veuillez choisir une pathologie',
                'required' => false
            ])
            ->add('plainte_doleance', null, [
                'label' => 'Plainte / Doléance'
            ])
            ->add('examen_clinique')
            ->add('avis_medecin_conseil')
            ->add('examen', ChoiceType::class, [
                'mapped' => false,
                'choices'  => [
                    'OUI' => '1',
                    'NON' => '0',
                ],
                'label' => 'Examens complémentaires Demandes',
                'expanded' => true,
                'required' => false,
            ])
            ->add('expertise', ChoiceType::class, [
                'mapped' => false,
                'choices'  => [
                    'OUI' => '1',
                    'NON' => '0',
                ],
                'label' => 'Expertise demandée',
                'expanded' => true,
                'required' => false,
                
            ])
            ->add('examens_complementaires')
            ->add('expertise_demandee')
            ->add('medecin')
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'nom',
                'placeholder' => 'Veuillez choisir une spécialité',
                'required' => false,
                'query_builder' => function(SpecialiteRepository $specialiteRepository){
                    return $specialiteRepository->createQueryBuilder('s')->orderBy('s.nom', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certificat::class,
        ]);
    }
}