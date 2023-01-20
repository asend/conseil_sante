<?php

namespace App\Twig;

use App\Entity\Patient;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PatientExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('age', [$this, 'getAge']),
            new TwigFilter('etatCivil', [$this, 'getEtatCivil']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function getAge(Patient $patient)
    {
        $am = explode('/', $patient->getDateNaissance()->format("d/m/Y"));
        $an = explode('/', date('d/m/Y'));
        if(($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0]))){
            return $an[2] - $am[2];
        }else{
            return $an[2] - $am[2] - 1;
        }
    }

    public function getEtatCivil(Patient $patient){
        if ($patient->getSexe() == 0) {
            $sexe = "H";
            $domicile = "domicilié à";
        } else {
            $sexe = "F";
            $domicile = "domiciliée à";
        }
        $age = PatientExtension::getAge($patient);
        return $sexe.', '.PatientExtension::getAge($patient).' ans '.$patient->getCorps()->getNom().', '.Patient::SM[$patient->getSituationMatrimoniale()].', '.$patient->getNombreEnfant().', en service depuis '.$patient->getDateEntreeService()->format("Y").', '.$patient->getLieuService().' '.$domicile.' '.$patient->getAdresse();
        
        
    }
}